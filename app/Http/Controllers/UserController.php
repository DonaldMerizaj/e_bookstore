<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Classes\LoginClass;
use App\Http\Controllers\Classes\UserClass;
use App\Models\KlientModel;
use App\Models\LoginModel;
use App\Models\UserModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;

class UserController extends Controller
{
    public function login(Request $request){
        $this->validate($request, [
            'username'=>'required',
            'password'=>'required'
        ]);
        $pass=Utils::enkripto($request->password);

        $user=LoginModel::where('username',htmlentities(trim($request->username)))->where('password',$pass)
            ->first();

        if (count($user) > 0){
            $role = $user->role;
            if ($role == LoginClass::KLIENT) {
                $useri = KlientModel::where('id_login', $user->login_id)->first();
            } else {
                $useri = UserModel::where('id_login', $user->login_id)->first();
            }
            Utils::setLogin($user->login_id, $role);
            return Redirect::route('dashboard');
        }
           else{
            return Redirect::back()->withErrors('Të dhënat nuk u gjetën, ju lutemi vendosni të dhënat e sakta!');
        }
    }

    public function listoPunonjes(){
        $punonjes = UserModel::select(UserClass::TABLE_NAME.'.'.UserClass::EMRI, UserClass::TABLE_NAME.'.'.UserClass::MBIEMRI,
            UserClass::TABLE_NAME.'.'.UserClass::EMAIL)
            ->join(LoginClass::TABLE_NAME, LoginClass::TABLE_NAME.'.'.LoginClass::ID, UserClass::TABLE_NAME.'.'.UserClass::ID_LOGIN)
            ->where(LoginClass::TABLE_NAME.'.'.LoginClass::ROLE, LoginClass::PUNONJES)
            ->get();
        if ($punonjes) {
            return view('backend.users.users')
                ->with('users', $punonjes);
        }else{
            return Redirect::back();
        }
    }

    //funksioni qe ben signup nje klient i ri
    public function register(Request $request){
        $this->validate($request, [
            'name'=>'required',
            'surname'=>'required',
            'email'=>'required|unique:klient,email',
            'city'=>'required',
            'username'=>'required|unique:login,username',
            'password'=>'required',
        ],
            [
            'name.required' => 'Name is required',
            'surname.required' => 'Surname is required',
            'email.required' => 'Name is required',
            'email.unique' => 'This email is already in use',
            'city.required' => 'City is required',
            'username.required' => 'Username is required',
            'username.unique' => 'This username is already in use',
            'password.required' => 'Passowrd is required',
        ]); //validon inputin e userit

        $name = htmlentities(trim($request->name));
        $surname = htmlentities(trim($request->surname));
        $email = htmlentities(trim($request->email));
        $city = htmlentities(trim($request->city));
        $cel = $request->cel ? htmlentities(trim($request->cel)) : 0;
        $username = $request->username;
        $pass = Utils::enkripto(htmlentities(trim($request->password)));

        try {

            DB::beginTransaction();
            $login = new LoginModel();
            $login->username = $username;
            $login->password = $pass;
            $login->role = LoginClass::KLIENT;
            $login->save();

            $id_login = DB::getPDO()->lastInsertId();
            //merr id e loginit te userit te ri dhe e ben FK te tabela Klient

            if ($id_login != '') {
                $user = new KlientModel();
                $user->emri = $name;
                $user->mbiemri = $surname;
                $user->email = $name;
                $user->emri = $email;
                $user->city = $city;
                $user->cel = $cel;
                $user->id_login = $id_login;
                $user->save();
                DB::commit();

                return Redirect::route('loginView');
            } else {
                DB::rollback();
                return Redirect::back()
                    ->withErrors('Ndodhi nje problem dhe llogaria juaj nuk u krijua, ju lutem provoni perseri!');
            }

        }catch (\Exception $e){
            DB::rollback();
            return Redirect::back()
                ->withInput(Input::all())
                ->withErrors("Dicka nuk shkoi mire, provoni perseri");
        }
    }

    public function index(){
        $username = LoginModel::where(LoginClass::TABLE_NAME.'.'.LoginClass::ID, Utils::getLoginId())->first()->username;

        if (Utils::getRole()<= LoginClass::PUNONJES){
            //librat qe kane kaluar afatin
            $jashteAfati = DB::select('SELECT titulli 
                                        FROM libri as l 
                                        JOIN huazim as h 
                                          ON l.libri_id=h.id_libri 
                                      WHERE datediff(CURRENT_DATE(),data_dorezimit)>0 and h.kthyer=0 AND h.shitur = 0');
            $huazuar = DB::select('SELECT titulli 
                                        FROM libri as l 
                                        JOIN huazim as h 
                                          ON l.libri_id=h.id_libri 
                                       where h.shitur = 0 and h.kthyer=0');
//                                      WHERE datediff(CURRENT_DATE(),data_dorezimit)>0 and h.kthyer=1');

            if (count($huazuar) > 0){
                $raporti = round((count($jashteAfati) / count($huazuar)) * 100);
            }else{
                $raporti = 0;
            }
        }else{
            $jashteAfati = DB::select('SELECT titulli 
                                        FROM libri as l 
                                        JOIN huazim as h 
                                          ON l.libri_id=h.id_libri 
                                      WHERE datediff(CURRENT_DATE(),data_dorezimit)>0 and h.kthyer=0 AND h.shitur = 0 AND h.id_klient = ?', array(Utils::getKlientId()));

//            $huazuar = DB::select('SELECT titulli
//                                        FROM libri as l
//                                        JOIN huazim as h
//                                          ON l.libri_id=h.id_libri
//                                          WHERE h.id_user');
//                                      WHERE datediff(CURRENT_DATE(),data_dorezimit)>0 and h.kthyer=1');

//            $raporti = round((count($jashteAfati) / count($huazuar)) * 100);
        }
        $sasia_nr = count($jashteAfati);
        if (Utils::getRole()<= LoginClass::PUNONJES) {
            //librat me pak se 3 ne gjendje
            $libramin = DB::select('SELECT l.titulli, l.cmimi
                                    from inventar as i, libri as l
                                    where i.id_libri = l.libri_id and i.gjendje < 3');


            $shitje = DB::select('SELECT SUM(cmimi) as total, COUNT(libri_id) as nr
                                        FROM libri as l 
                                        JOIN huazim as h 
                                          ON l.libri_id=h.id_libri
                                       WHERE shitur = 1');
        }else{
            $shitje = DB::select('SELECT SUM(cmimi) as total, COUNT(libri_id) as nr
                                        FROM libri as l 
                                        JOIN huazim as h 
                                          ON l.libri_id=h.id_libri
                                       WHERE h.shitur = 1 AND h.kthyer=1 and h.id_klient = ?', array(Utils::getKlientId()));
        }
//        echo Utils::getUserId();die();

        if (Utils::getRole() <= LoginClass::PUNONJES) {

            return view('backend.home')
                ->with('raporti', $raporti)
                ->with('sasia_nr', $sasia_nr)
                ->with('shitje', $shitje)
                ->with('libramin', $libramin)
                ->with('username', $username);
        }else{
            return view('backend.home')
                ->with('sasia_nr', $sasia_nr)
                ->with('shitje', $shitje)
                ->with('username', $username);
        }
    }

    public function pass(){
        echo Utils::enkripto('123456');
    }

    public function logout(){
        Session::forget(Utils::SESSION_USER_ID );
        Session::forget(Utils::SESSION_ROLE);

        return Redirect::route('loginView');

    }
}

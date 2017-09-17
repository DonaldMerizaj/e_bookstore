<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Classes\FeedbackClass;
use App\Http\Controllers\Classes\LoginClass;
use App\Http\Controllers\Classes\UserClass;
use App\Models\FeedbackModel;
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
    //ben login useri
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
                $user->email = $email;
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

    //ben logout
    public function logout(){
        //fshin variablat e sesionit
        Session::forget(Utils::SESSION_USER_ID );
        Session::forget(Utils::SESSION_ROLE);

        return Redirect::route('loginView');

    }

    //admini shikon gjith sms e userave
    public function viewAllMsg(){
        $sms = FeedbackModel::where(FeedbackClass::TABLE_NAME.'.'.FeedbackClass::STATUS, FeedbackClass::PENDING)
                ->orderBy('created_at', 'desc')
                ->get();

        return view('backend.allmsg')
            ->with('sms', $sms);
    }

    //admini fshin sms e klienteve
    public function fshiMsg(Request $request){

        if (isset($request->id)) {
            $id = htmlentities(trim($request->id));

            try {
                $sms = FeedbackModel::where(FeedbackClass::TABLE_NAME . '.' . FeedbackClass::ID, $id)
                    ->update([FeedbackClass::STATUS => FeedbackClass::DELETED]);

                return [
                    'sts' => 1
                ];
            } catch (\Exception $e) {
                return [
                    'sts' => 0,
                    'msg' => $e->getMessage()
                ];
            }
        }else{
            return [
                'sts' => 0
            ];
        }
    }
}

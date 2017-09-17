<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Classes\AutoriClass;
use App\Http\Controllers\Classes\FeedbackClass;
use App\Http\Controllers\Classes\HuazimClass;
use App\Http\Controllers\Classes\KlientClass;
use App\Http\Controllers\Classes\LibriClass;
use App\Models\FeedbackModel;
use App\Models\HuazimModel;
use App\Models\KlientModel;
use App\Models\LibriModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;

class KlientController extends Controller
{
    //liston klientet
    public function index(){
        $klient = KlientModel::select(KlientClass::TABLE_NAME.'.'.KlientClass::ID,KlientClass::TABLE_NAME.'.'.KlientClass::EMRI,
            KlientClass::TABLE_NAME.'.'.KlientClass::MBIEMRI, KlientClass::TABLE_NAME.'.'.KlientClass::EMAIL,
            KlientClass::TABLE_NAME.'.'.KlientClass::CEL )
            ->get();

        return view('backend.klient.index')
            ->with('klient', $klient)
            ;
    }

    //klienti krijon nje mesazh per adminin
    public function krijomsg(){
        return view('backend.klient.msg');
    }

    //ruhet sms i userit
    public function ruajmsg(Request $request){

        $this->validate($request,[
            'emri'=> 'required',
            'email'=> 'required|email',
            'desc'=> 'required',
        ]);

        $emri = htmlentities(trim($request->emri));
        $email = htmlentities(trim($request->email));
        $desc = htmlentities(trim($request->desc));

        try{

            $new = new FeedbackModel();
            $new->emri = $emri;
            $new->email = $email;
            $new->desc = $desc;
            $new->status = FeedbackClass::PENDING;
            $new->save();

            return Redirect::route('listLibrat');
        }catch (\Exception $e){
            return Redirect::back()
                ->withInput(Input::all())
                ->withErrors($e->getMessage());
        }

    }
}

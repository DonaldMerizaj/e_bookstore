<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Classes\AutoriClass;
use App\Http\Controllers\Classes\BasketClass;
use App\Http\Controllers\Classes\LibriClass;
use App\Models\BasketModel;
use Exception;
use Illuminate\Http\Request;

class CardController extends Controller
{
    public function save(Request $request){

        if (isset($request->id_libri)){
            $id_libri = htmlentities(trim($request->id_libri));

            try {

                $card = new BasketModel();
                $card->id_klient = Utils::getKlientId();
                $card->id_libri = $id_libri;
                $card->status = BasketClass::ACTIVE;
                $card->save();

                return [
                    'sts' => 1,
                ];

            } catch (Exception $e) {
                return [
                    'sts' => 0,
                    'error' => $e->getMessage()
                ];
            }
        }
    }

    public function view(){
        $librat = BasketModel::select(LibriClass::TABLE_NAME.'.'.LibriClass::TITULLI,LibriClass::TABLE_NAME.'.'.LibriClass::ID,
            LibriClass::TABLE_NAME.'.'.LibriClass::CMIMI, LibriClass::TABLE_NAME.'.'.LibriClass::SHTEPI_BOTUESE,
            LibriClass::TABLE_NAME.'.'.LibriClass::VITI, AutoriClass::TABLE_NAME.'.'.AutoriClass::EMRI,
            AutoriClass::TABLE_NAME.'.'.AutoriClass::MBIEMRI, LibriClass::TABLE_NAME.'.'.LibriClass::IMAGE)
            ->join(LibriClass::TABLE_NAME, LibriClass::ID, BasketClass::TABLE_NAME.'.'.BasketClass::ID_LIBRI)
            ->join(AutoriClass::TABLE_NAME, AutoriClass::ID, LibriClass::TABLE_NAME.'.'.LibriClass::ID_AUTOR)
            ->where(BasketClass::TABLE_NAME.'.'.BasketClass::ID_KLIENT, Utils::getKlientId())
            ->where(BasketClass::TABLE_NAME.'.'.BasketClass::STATUS, BasketClass::ACTIVE)
            ->get();

        return view('backend.klient.card')
            ->with('librat', $librat)
            ;
    }

    public function fshi(Request $request){
        if (isset($request->id_libri)){
            $id_libri = htmlentities(trim($request->id_libri));

            try{
                $found = BasketModel::where(BasketClass::TABLE_NAME.'.'.BasketClass::ID_LIBRI, $id_libri)
                    ->where(BasketClass::TABLE_NAME.'.'.BasketClass::ID_KLIENT, Utils::getKlientId())
                    ->delete();

                if ($found){
                    return [
                        'sts'=> 1,
                    ];
                }else{
                    return [
                        'sts'=> 0,
                    ];
                }
            } catch (Exception $e) {
            return [
                'sts' => 0,
                'error' => $e->getMessage()
            ];
        }

        }
    }

}

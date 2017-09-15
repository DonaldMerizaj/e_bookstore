<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Classes\AutoriClass;
use App\Http\Controllers\Classes\LibriClass;
use App\Models\AutorModel;
use App\Models\LibriModel;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AutorController extends Controller
{
    public function view(){
        $autor = AutorModel::get();
        return view('backend.autor.view')
            ->with('autor', $autor);
    }

    public function save(Request $request){

        if (isset($request->emri) && isset($request->mbiemri)){
            try {
                $category = new AutorModel();
                $category->emri = htmlentities(trim($request->emri));
                $category->mbiemri = htmlentities(trim($request->mbiemri));
                $category->save();

                $id = DB::getPDO()->lastInsertId();
                return [
                    'sts' => 1,
                    'id' => $id
                ];

            } catch (Exception $e) {
                return [
                    'sts' => 0,
                    'error' => $e->getMessage()
                ];
            }
        }
    }

    public function edit(){

    }

    public function update(){

    }

    public function delete(Request $request){
        if (isset($request->id)){

            $exists = LibriModel::where(LibriClass::TABLE_NAME.'.'.LibriClass::ID_AUTOR, htmlentities(trim($request->id)))
                ->first();
            if ($exists){
                return [
                    'sts' => 2
                ];
            }

            $zhanri = AutorModel::where(AutoriClass::TABLE_NAME.'.'.AutoriClass::ID, htmlentities(trim($request->id)))
                ->delete();

            if ($zhanri){
                return [
                    'sts'=> 1,
                ];
            }else{
                return [
                    'sts' => 0
                ];
            }
        }else{
            return [
                'sts' => 0
            ];
        }
    }
}

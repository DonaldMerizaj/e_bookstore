<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Classes\ZhanriClass;
use App\Models\CategoryModel;
use App\Models\ZhanriModel;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Validator;

class ZhanriController extends Controller
{

    public function save(Request $request)
    {

        if (isset($request->emri)){
            try {

                $category = new ZhanriModel();
                $category->emri = htmlentities(trim($request->emri));
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

    public function update(Request $request)
    {
        try {

            $validator = Validator::make(
                $request->all(),
                [
                    'category_id'   => 'required|exists:categories,id',
                    'category_name' => 'required'
                ]
            );

            if($validator->fails()) {
                return $this->doResponse('ERR', $validator->errors(), 401);
            }

            $category = Category::find($request->input('category_id'));
            $category->name = $request->input('category_name');
            $category->save();

            return $this->doResponse('OK', $category, 200);


        } catch (Exception $e) {
            return $this->doResponse('ERR', $e->getMessage(), 500);
        }
    }

    public function destroy(Request $request)
    {
        try {

            $validator = Validator::make(
                $request->all(),
                [
                    'category_id'   => 'required|exists:categories,id',
                ]
            );

            if($validator->fails()) {
                return $this->doResponse('ERR', $validator->errors(), 401);
            }

            $category = Category::find($request->input('category_id'));
            $category->delete();

            return $this->doResponse('OK', $category, 200);


        } catch (Exception $e) {
            return $this->doResponse('ERR', $e->getMessage(), 500);
        }
    }

    public function fshi(Request $request){
//        echo $request->id;die();
        if (isset($request->id)){
            $zhanri = ZhanriModel::where(ZhanriClass::TABLE_NAME.'.'.ZhanriClass::ID, htmlentities(trim($request->id)))
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

    public function view(){
        $zhanri = ZhanriModel::get();

        return view('backend.zhaner.view')
            ->with("zhanri", $zhanri)
            ;
    }

}

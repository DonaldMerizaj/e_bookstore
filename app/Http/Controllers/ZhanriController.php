<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Classes\ZhanriClass;
use App\Models\CategoryModel;
use App\Models\ZhanriModel;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Validation\Validator;

class ZhanriController extends Controller
{

    public function store(Request $request)
    {
        try {

           $this->validate($request,
                [
                    'category_name' => 'required'
                ]
            );

            $category = new CategoryModel();
            $category->emri = $request->category_name;
            $category->save();

            return [
                'status' => 1,
                'data' => $category
            ];


        } catch (Exception $e) {
            return [
                'status' => 0,
                'error' => $e->getMessage()
            ];
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
        if (isset($request->id)){
            $zhanri = ZhanriModel::where(ZhanriClass::TABLE_NAME.'.'.ZhanriClass::ID, htmlentities(trim($request->id)))
                ->delete();

            if ($zhanri){
                return [
                    'sts'=> 1
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

    public function view(Request $request){
        $zhanri = ZhanriModel::get();

        return view('backend.zhaner.view')
            ->with("zhanri", $zhanri)
            ;
    }

}

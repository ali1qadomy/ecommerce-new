<?php

namespace App\Http\Controllers\api\admin;

use App\Http\Controllers\Controller;
use App\Models\category;
use App\Trait\GeneralTraits;
use Illuminate\Http\Request;
use Validator;

class CategoryController extends Controller
{

    use GeneralTraits;
    public function index()
    {
        try {

            $categories = Category::with('children')->select('id', 'category_name_' . app()->getLocale() . ' AS name', 'parent', 'active')->whereNull('parent')->paginate(10);
            if($data)
            {
                return $this->returnSuccess('s001', 'retrive data successfully', 'data', $categories);

            }
        } catch (\Throwable $th) {

            return $this->returnError('e001', $th->getMessage());
        }
    }

    public function GetCategoryId(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'id' => 'required',
        ]);

        if ($validator->fails()) {

            return $this->returnError('e001', $validator->errors());
        }

        try {
            $category  = new category();
            $data = $category->getCategories(app()->getLocale(), ['id' => $request->id])->first();
            if($data)
            {
                return $this->returnSuccess('s001', 'retrive data successfully', 'data', $data);
            }
        } catch (\Throwable $th) {
            return $this->returnError('e001', $th->getMessage());
        }
    }

    public function store(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'category_name_en' => 'required|string',
            'category_name_ar' => 'required|string',
            'active' => 'required',
        ]);

        if ($validator->fails()) {

            return $this->returnError('e001', $validator->errors());
        }
        try {
            $data = category::Create([
                'category_name_en' => $request->category_name_en,
                'category_name_ar' => $request->category_name_en,
                'parent' => $request->parent ,
                'active' => $request->active,
            ]);
            if($data)
            {
                return $this->returnSuccess('s001', 'data saved successfully', 'data', $data);

            }
        } catch (\Throwable $th) {
            return $this->returnError('e001', $th->getMessage());
        }
    }
    public function update(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'id' => 'required',
            'category_name_en' => 'required|string',
            'category_name_ar' => 'required|string',
            'active' => 'required',
        ]);

        if ($validator->fails()) {

            return $this->returnError('e001', $validator->errors());
        }
        try {
            $data = category::find($request->id);
            $data->category_name_en = $request->category_name_en;
            $data->category_name_ar = $request->category_name_ar;
            $data->parent = $request->parent;
            $data->active = $request->active;
            $data->save();
            if($data)
            {
                return $this->returnSuccess('s001', 'data update successfully', 'data', $data);

            }
        } catch (\Throwable $th) {
            return $this->returnError('e001', 'something is error');
        }
    }
    public function delete(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required',
        ]);

        if ($validator->fails()) {

            return $this->returnError('e001', $validator->errors());
        }

        try {
            $data = category::find($request->id);
            $data->delete();
            if($data)
            {
                return $this->returnSuccess('s001', 'data delete successfully', 'data', $data);

            }
        } catch (\Throwable $th) {
            return $this->returnError('e001', $th->getMessage());;
        }
    }
}

<?php

namespace App\Http\Controllers\api\user;

use App\Http\Controllers\Controller;
use App\Models\category;
use Illuminate\Http\Request;
use App\Trait\GeneralTraits;
use Validator;


class UserCategoryController extends Controller
{
    use GeneralTraits;
    public function index()
    {
        try {

            $categories = category::with('children')->select('id', 'category_name_' . app()->getLocale() . ' AS name', 'parent', 'active')->whereNull('parent')->paginate(10);

            return $this->returnSuccess('s001', 'retrive data successfully', 'data', $categories);
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

            return $this->returnSuccess('s001', 'retrive data successfully', 'data', $data);
        } catch (\Throwable $th) {
            return $this->returnError('e001', $th->getMessage());
        }
    }

}

<?php

namespace App\Http\Controllers\api\user;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Trait\GeneralTraits;
use Validator;
class UserProductController extends Controller
{
    use GeneralTraits;

    public function index(Request $request)
    {
        try {
            $product = Product::with('category')->select('id', 'name_' . app()->getLocale() . ' AS name', 'description_' . app()->getLocale() . ' AS description', 'image_url', 'category_id', 'active')->paginate(10);
            if ($product) {
                return $this->returnSuccess('s001', 'Retrive Successfully', 'result', $product);
            }
            return $this->returnError('e001', 'failed retrive data');
        } catch (\Throwable $th) {
            return $this->returnError('e001', $th->getMessage());
        }
    }
    public function GetProductId(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'id' => 'required',
        ]);

        if ($validator->fails()) {

            return $this->returnError('e001', $validator->errors());
        }
        try {
            $product = Product::where('id',$request->id)->with('category')->select('id', 'name_' . app()->getLocale() . ' AS name', 'description_' . app()->getLocale() . ' AS description', 'image_url', 'category_id', 'active')->first();
            if ($product) {
                return $this->returnSuccess('s001', 'Retrive Successfully', 'result', $product);
            }
            return $this->returnError('e001', 'failed retrive data');
        } catch (\Throwable $th) {
            return $this->returnError('e001', $th->getMessage());
        }
    }
}

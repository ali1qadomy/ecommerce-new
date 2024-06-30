<?php

namespace App\Http\Controllers\api\admin;

use App\Http\Controllers\Controller;
use App\Models\category;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Trait\GeneralTraits;
use Illuminate\Support\Facades\Storage;
use Validator;

class ProductController extends Controller
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



    public function category()
    {
        try {

            $categories = Category::with('children')->select('id', 'category_name_' . app()->getLocale() . ' AS name', 'parent', 'active')->get();

            return $this->returnSuccess('s001', 'retrive data successfully', 'data', $categories);
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
            $product = Product::with('category')->select('id', 'name_' . app()->getLocale() . ' AS name', 'description_' . app()->getLocale() . ' AS description', 'image_url', 'category_id', 'active')->first();
            if ($product) {
                return $this->returnSuccess('s001', 'Retrive Successfully', 'result', $product);
            }
            return $this->returnError('e001', 'failed retrive data');
        } catch (\Throwable $th) {
            return $this->returnError('e001', $th->getMessage());
        }
    }


    public function store(Request $request){
        $validator = Validator::make($request->all(), [
            'name_en' => 'required',
            'name_ar' => 'required',
            'description_en' => 'required',
            'description_ar' => 'required',
            'category_id'=>'required',
            'image_url'=>'required|file',
            'active'=>'required'
        ]);

        if ($validator->fails()) {

            return $this->returnError('e001', $validator->errors());
        }
        try {
            $product_image="";
            if($request->file('image_url'))
            {
                $image_name=$request->file('image_url')->getClientOriginalName();
                $path=$request->file('image_url')->storeAs('product',$image_name);
                $product_image = "https://www.cfc.sa".Storage::url($path);
            }
            $product=Product::create([
                'name_en' => $request->name_en,
                'name_ar' => $request->name_ar,
                'description_en' => $request->description_en,
                'description_ar' => $request->description_ar,
                'category_id'=>$request->category_id,
                'image_url'=>$product_image,
                'active'=>$request->active,
            ]);

            // $product->image()->create(['url'=>$product_image]);


                return $this->returnSuccess('s001', 'Retrive Successfully', 'result', $product);
            
            return $this->returnError('e001', 'failed retrive data');
        } catch (\Throwable $th) {
            return $this->returnError('e001', $th->getMessage());
        }
    }
    public function update(Request $request){
        $validator = Validator::make($request->all(), [
            'id'=>'required',
            'name_en' => 'required',
            'name_ar' => 'required',
            'description_en' => 'required',
            'description_ar' => 'required',
            'category_id'=>'required',
            'image_url'=>'required',
            'active'=>'required'
        ]);

        if ($validator->fails()) {

            return $this->returnError('e001', $validator->errors());
        }
        try {

            $data = Product::find($request->id);
            $data->name_en = $request->name_en;
            $data->name_ar = $request->name_ar;
            $data->description_en = $request->description_en;
            $data->description_ar = $request->description_ar;
            $data->category_id = $request->category_id;
            $data->image_url = $request->image_url;
            $data->active = $request->active;
            $data->save();

            if ($data) {
                return $this->returnSuccess('s001', 'update Successfully', 'result', $data);
            }
            return $this->returnError('e001', 'failed update data');
        } catch (\Throwable $th) {
            return $this->returnError('e001', $th->getMessage());
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
            $data = Product::find($request->id);
            $data->delete();

            return $this->returnSuccess('s001', 'data delete successfully', 'data', $data);
        } catch (\Throwable $th) {
            return $this->returnError('e001', $th->getMessage());;
        }
    }
}

<?php
namespace App\Trait;

trait GeneralTraits{

    public function returnError($errNum,$msg){
        return response()->json([
            'status'=>'false',
            'message'=>$msg,
            'errorNum'=>$errNum
        ],400);
    }
    public function returnSuccess($errNum,$msg,$key="",$value=""){
        return response()->json([
            'status'=>'true',
            'message'=>$msg,
            'successNum'=>$errNum,
            $key=>$value
        ],200);
    }


}

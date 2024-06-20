<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Trait\GeneralTraits;
use Carbon\Carbon;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Validator;

class RestPasswordAdmin extends Controller
{

    use GeneralTraits;

    public function sendEmail(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|string|email|exists:admins,email',
        ]);

        if ($validator->fails()) {

            $data = [
                'message' => $validator->errors()
            ];
            return $this->returnError('e001', $data);
        }
        $this->send($request->email);
        return $this->returnSuccess('s001','email send successfully');
    }

    public function send($email)
    {
        $token =$this->createToken($email);

        Mail::to()
    }
    public function createToken($email)
    {
        $oldToken=PasswordReset::where('email',$email)->first();

        if($oldToken)
        {
            return  $oldToken->token;
        }
        $token=Str::random(40);
        $this->saveToken($token,$email);
        return $token;
    }
    public function saveToken($token,$email)
    {
      DB::table('password_reset_tokens')->insert([
        'email'=>$email,
        'token'=>$token,
        ' created_at'=>Carbon::now()
      ]);

    }

}

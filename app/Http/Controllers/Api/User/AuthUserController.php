<?php

namespace App\Http\Controllers\api\user;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use App\Trait\GeneralTraits;
use Validator;
use Tymon\JWTAuth\Facades\JWTAuth;
use Auth;
class AuthUserController extends Controller
{
    use GeneralTraits;
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|string|email',
            'password' => 'required'
        ]);

        if ($validator->fails()) {

            $data = [
                'message' => $validator->errors()
            ];
            return $this->returnError('e001', $data);
        }
        $credentials = request(['email', 'password']);
        $token = Auth::guard('user-api')->attempt($credentials);
        if (!$token || $token==null) {
            return $this->returnError('e001', 'unAuthrized');
        }
        $user = Auth::guard('user-api')->user();
        $user->token = $token;

        return $this->returnSuccess('s001', 'success login', 'user', $user);
    }

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'password' => 'required|string|min:8',
            'email' => 'required|email',
        ]);
        if ($validator->fails()) {
            $data = [
                'message' => $validator->errors()
            ];
            return $this->returnError('e001', $data);
        }
   try {
    $user = new User();
    $user->name = $request->name;
    $user->email = $request->email;
    $user->password = bcrypt($request->password);

    $user->save();



    return $this->returnSuccess('s001', 'success registration', 'user', $user);
   } catch (\Throwable $th) {
    return $this->returnError('e001', $th->getMessage());   }
    }
    public function logout()
    {
        try {

            JWTAuth::parseToken()->invalidate();
            return $this->returnSuccess('s001', 'User logged out successfully');
        } catch (\Exception $e) {
            return $this->return('e001', $e->getMessage());
        }
    }
}

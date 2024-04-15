<?php

namespace App\Http\Controllers\Api\Admin;

use Auth;
use Validator;
use App\Models\admins;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\role;
use App\Trait\GeneralTraits;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
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
        $token = Auth::guard('admin-api')->attempt($credentials);
        if (!$token) {
            return $this->returnError('e001','unAuthrized');
        }
        $admin = Auth::guard('admin-api')->user()->with('roles')->get();
        $admin->token = $token;

        return $this->returnSuccess('s001', 'success login', 'admin', $admin);
    }

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'username' => 'required|string|max:255',
            'role' => 'required|array|max:255',
            'password' => 'required|string|min:8',
            'email' => 'required|email',
        ]);
        if ($validator->fails()) {
            return $this->returnError('E001', "$validator->errors()");
        }


        $admin = new admins();
        $admin->username = $request->username;
        $admin->email = $request->email;
        $admin->password = bcrypt($request->password);

        $admin->save();
        $roleIds = [];
        foreach ($request->role as $roleName) {
            $role = role::where('name_en', $roleName)->first();
            if ($role) {
                $roleIds[] = $role->id;
            }
        }
        $admin->roles()->attach($roleIds);
        $data = admins::where('id', $admin['id'])->with('roles')->get();
        return $this->returnSuccess('s001', 'success registration', 'admin', $data);
    }
    public function logout()
    {
        try {

            JWTAuth::parseToken()->invalidate();
            return $this->returnSuccess('s001', 'User logged out successfully');
        } catch (\Exception $e) {
            return $this->return('e001', 'Failed to logout');
        }
    }
    public function resetPassword(Request $request)
    {
    }
}

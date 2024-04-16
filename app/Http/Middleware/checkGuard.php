<?php

namespace App\Http\Middleware;
use App\Trait\GeneralTraits;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Http\Middleware\BaseMiddleware;

class checkGuard
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next,$quard=null): Response
    {


        if($quard != null)
        {
            auth()->shouldUse($quard);
            $token=$request->header('Authrization');
            try {

                $user = JWTAuth::parseToken()->authenticate();
                        } catch (\Tymon\JWTAuth\Exceptions\TokenExpiredException $th) {
                return response()->json([
                    'status'=>'e001',
                    'message'=>'unauthrized'
                ]);
            }catch(JWTException $e)
            {
                return response()->json([
                    'staus'=>'e001',
                    'message'=>'unauthrized'
                ]);
            }
        }
        return $next($request);

    }
}

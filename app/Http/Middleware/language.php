<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

use function PHPUnit\Framework\isEmpty;

class language
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $lang=request()->header("language");

        if($lang == "" ||$lang == null)
        {
            return response()->json([
                'staus'=>'e001',
                'message'=>'language not found',
                'data' => $lang
            ]);
        }
        app()->setLocale('ar');

        if(isset($request->lang) && $request->lang == 'en')
        {
            app()->setLocale('en');
        }

        return $next($request);
    }
}

<?php

use App\Http\Controllers\Api\Admin\AuthController;
use App\Http\Controllers\api\admin\CategoryController;
use App\Http\Controllers\Api\Admin\RestPasswordAdmin;
use App\Http\Controllers\api\user\profile;
use App\Models\admins;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/



Route::group(['middleware::api'],function(){

  Route::group(['prefix'=>'admin','namespace'=>'Admin'],function(){
    Route::post('login',[AuthController::class,'login']);
    Route::post('register',[AuthController::class,'register']);
    Route::post('logout',[AuthController::class,'logout']);
    Route::post('reset_password',[RestPasswordAdmin::class,'sendEmail']);
  });


  Route::group(['middleware'=>'authGuard:admin-api','prefix'=>'admin'],function(){

    Route::group(['prefix'=>'category'],function(){
        Route::get('/',[CategoryController::class,'index'])->middleware('lang');
        Route::get('/details',[CategoryController::class,'GetCategoryId'])->middleware('lang');
        Route::post('/store',[CategoryController::class,'store']);
        Route::post('/update',[CategoryController::class,'update']);
        Route::post('/delete',[CategoryController::class,'delete']);
    });
});

Route::group(['middleware'=>'authGuard:user-api','prefix'=>'user'],function(){

});

});




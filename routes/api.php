<?php

use App\Http\Controllers\Api\Admin\AuthController;
use App\Http\Controllers\api\admin\CategoryController;
use App\Http\Controllers\api\admin\ProductController;
use App\Http\Controllers\Api\Admin\RestPasswordAdmin;
use App\Http\Controllers\api\user\AuthUserController;
use App\Http\Controllers\api\user\profile;
use App\Http\Controllers\api\user\UserCategoryController;
use App\Http\Controllers\api\user\UserProductController;
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


  });

  Route::group(['prefix'=>'user','namespace'=>'User'],function(){
    Route::post('login',[AuthUserController::class,'login']);
    Route::post('register',[AuthUserController::class,'register']);

    // Route::post('reset_password',[RestPasswordAdmin::class,'sendEmail']);
  });


  Route::group(['middleware'=>'authGuard:admin-api','prefix'=>'admin'],function(){
    Route::post('logout',[AuthController::class,'logout']);
    Route::post('reset_password',[RestPasswordAdmin::class,'sendEmail']);

    Route::group(['prefix'=>'category'],function(){
        Route::get('/',[CategoryController::class,'index'])->middleware('lang');
        Route::get('/details',[CategoryController::class,'GetCategoryId'])->middleware('lang');
        Route::post('/store',[CategoryController::class,'store']);
        Route::post('/update',[CategoryController::class,'update']);
        Route::post('/delete',[CategoryController::class,'delete']);
    });
    Route::group(['prefix'=>'product'],function(){
        Route::get('/',[ProductController::class,'index'])->middleware('lang');
        Route::get('/details',[ProductController::class,'GetProductId'])->middleware('lang');
        Route::get('/category',[ProductController::class,'category'])->middleware('lang');

        Route::post('/store',[ProductController::class,'store']);
        Route::post('/update',[ProductController::class,'update']);
        Route::post('/delete',[ProductController::class,'delete']);
    });
});

Route::group(['middleware'=>'authGuard:user-api','prefix'=>'user'],function(){
    Route::post('logout',[AuthUserController::class,'logout']);
    Route::group(['prefix'=>'UserCategory'],function(){
        Route::get('/',[UserCategoryController::class,'index'])->middleware('lang');
        Route::get('/details',[UserCategoryController::class,'GetCategoryId'])->middleware('lang');
    });
    Route::group(['prefix'=>'UserProduct'],function(){
        Route::get('/',[UserProductController::class,'index'])->middleware('lang');
        Route::get('/details',[UserProductController::class,'GetProductId'])->middleware('lang');
    });
});

});




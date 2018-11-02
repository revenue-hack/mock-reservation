<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/


Route::group(['middleware' => ['login_session', 'user_action']], function()
{
    // Authentication routes
    Route::group(['namespace' => 'Auth'], function()
    {
        // App\Http\Controllers\Auth
        // 認証
        Route::group(['prefix' => 'auth/'], function()
        {
            Route::get('login', 'AuthController@getLogin');
            Route::post('login', 'AuthController@postLogin');
            Route::get('logout', 'AuthController@getLogout');
            Route::get('register', 'AuthController@getRegister');
            Route::post('register', 'AuthController@postRegister');

        });
        // パスワード
        /*
        Route::group(['prefix' => 'password/'], function()
        {
            Route::get('email', 'PasswordController@getEmail');
            Route::post('email', 'PasswordController@postEmail');
            Route::get('reset/{token?}', 'PasswordController@getReset');
            Route::post('reset', 'PasswordController@postReset');
        });
        //*/
    });

    Route::group(['middleware' => ['auth']], function()
    {
        Route::get('/', 'HomeController@index');
        Route::resource('/homes', 'HomeController', ['only' => ['edit', 'update']]);
        Route::resource('/reservations', 'ReserveController');
        Route::group(['middleware' => ['admin']], function()
        {
            Route::resource('/reservation_frames', 'ReserveFrameController');
            Route::resource('/roles', 'RoleController', ['except' => ['show']]);
            Route::resource('/users', 'UserController', ['except' => ['show', 'create', 'store']]);
        });
    });

    Route::group(['namespace' => 'Api'], function()
    {
        Route::group(['middleware' => ['ajax', 'auth']], function()
        {
            Route::resource('/api/reserve', 'ReserveController', ['only' => ['index', 'store', 'destroy']]);
            Route::resource('/api/reserve_frame', 'ReserveFrameController', ['only' => ['index', 'update']]);
            Route::resource('/api/home_reserve', 'HomeReserveController', ['only' => ['index']]);
        });
    });
});

<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::group(['namespace' => '\App\Http\Controllers\Auth'], function () {
    Route::group(['middleware' => ['web','guest']], function () {
        Route::get('auth/login', 'LoginController@showLoginForm')->name('login');
        Route::post('auth/login', 'LoginController@login')->name('postLogin');

        Route::get('password/reset', 'ForgotPasswordController@showLinkRequestForm')->name('password.request');
        Route::post('password/email', 'ForgotPasswordController@sendResetLinkEmail')->name('password.email');
        Route::get('password/reset/{token}', 'ResetPasswordController@showResetForm')->name('password.reset');
        Route::post('password/reset', 'ResetPasswordController@reset');
    });

    Route::group(['middleware' => 'web'], function () {
        Route::get('auth/logout', 'LoginController@logout')->name('getLogout');
    });
});

Route::group(['namespace' => '\App\Http\Controllers\User'], function () {
    Route::group(['middleware' => ['web','auth']], function () {
        Route::resource('User/User', 'UserController');
        Route::resource('User/Department', 'DepartmentController');
        Route::resource('User/Permission', 'PermissionController');
        Route::resource('User/Role', 'RoleController');
        Route::resource('User/RolePerm', 'RolePermController');
        Route::resource('User/UserRole', 'UserRoleController');
    });
});

Route::group(['namespace' => '\App\Http\Controllers\Install'], function () {
    Route::group(['middleware' => 'web'], function () {
        Route::get('initdb', 'InstallController@index');
        Route::get('makeall', 'InstallController@create');
    });
});

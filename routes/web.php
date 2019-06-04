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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::group(['prefix' => 'admin'], function () {
    Route::get('/', 'AdminAuth\LoginController@showLoginForm');
    Route::get('/login', 'AdminAuth\LoginController@showLoginForm');
    Route::post('/login', 'AdminAuth\LoginController@login');
    Route::post('/logout', 'AdminAuth\LoginController@logout');

    Route::get('/register', 'AdminAuth\RegisterController@showRegistrationForm');
    Route::post('/register', 'AdminAuth\RegisterController@register');

    Route::post('/password/email', 'AdminAuth\ForgotPasswordController@sendResetLinkEmail');
    Route::post('/password/reset', 'AdminAuth\ResetPasswordController@reset');
    Route::get('/password/reset', 'AdminAuth\ForgotPasswordController@showLinkRequestForm');
    Route::get('/password/reset/{token}', 'AdminAuth\ResetPasswordController@showResetForm');

    //COUNTRY
    Route::get('/country', 'CMS\CountryController@index');
    Route::get('/country/create', 'CMS\CountryController@create');
    Route::post('/country/store', 'CMS\CountryController@store');
    Route::get('/country/edit/{id}', 'CMS\CountryController@edit');
    Route::post('/country/update/{id}', 'CMS\CountryController@update');
    Route::post('/country/destroy', 'CMS\CountryController@destroy');

    //REGULATORY
    Route::get('/regulatory', 'CMS\RegulatoryController@index');
    Route::get('/regulatory/create', 'CMS\RegulatoryController@create');
    Route::post('/regulatory/store', 'CMS\RegulatoryController@store');
    Route::get('/regulatory/edit/{id}', 'CMS\RegulatoryController@edit');
    Route::post('/regulatory/update/{id}', 'CMS\RegulatoryController@update');
    Route::post('/regulatory/destroy', 'CMS\RegulatoryController@destroy');

    //TOPIC
    Route::get('/topic', 'CMS\TopicController@index');
    Route::get('/topic/create', 'CMS\TopicController@create');
    Route::post('/topic/store', 'CMS\TopicController@store');
    Route::get('/topic/edit/{id}', 'CMS\TopicController@edit');
    Route::post('/topic/update/{id}', 'CMS\TopicController@update');
    Route::post('/topic/destroy', 'CMS\TopicController@destroy');
});

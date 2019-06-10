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

    //CONTACT
    Route::get('/contact-enquiry', 'CMS\ContactEnquiryController@index');

    //REGULATORY
    Route::get('/group-management', 'CMS\GroupManagementController@index');
    Route::get('/group-management/create', 'CMS\GroupManagementController@create');
    Route::post('/group-management/store', 'CMS\GroupManagementController@store');
    Route::get('/group-management/edit/{id}', 'CMS\GroupManagementController@edit');
    Route::post('/group-management/update/{id}', 'CMS\GroupManagementController@update');
    Route::post('/group-management/destroy', 'CMS\GroupManagementController@destroy');
	
		  /*start filter Module backend*/
  Route::get('/filter', 'CMS\FilterController@index')->name('filter.index');
  Route::get('/filter/create', 'CMS\FilterController@create');
  Route::post('/filter/store', 'CMS\FilterController@store');
  Route::get('/filter/edit/{id}', 'CMS\FilterController@edit');
  Route::post('/filter/update/{id}', 'CMS\FilterController@update');
  Route::get('/filter/destroy/{id}', 'CMS\FilterController@destroy');
  
  Route::get('/banner', 'CMS\BannerController@index')->name('banner.index');
  Route::get('/banner/create', 'CMS\BannerController@create');
  Route::post('/banner/store', 'CMS\BannerController@store');
  Route::get('/banner/edit/{id}', 'CMS\BannerController@edit');
  Route::post('/banner/update/{id}', 'CMS\BannerController@update');
  Route::get('/banner/destroy/{id}', 'CMS\BannerController@destroy');
  
  Route::get('/page', 'CMS\PageController@index')->name('page.index');
  Route::get('/page/create', 'CMS\PageController@create');
  Route::post('/page/store', 'CMS\PageController@store');
  Route::post('/page/search', 'CMS\PageController@search');
  Route::get('/page/edit/{id}', 'CMS\PageController@edit');
  Route::post('/page/update/{id}', 'CMS\PageController@update');
  Route::get('/page/destroy/{id}', 'CMS\PageController@destroy');
  /*end filter module backend*/

});

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
    return view('page');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::group(['prefix' => 'admin'], function () {
    Route::get('/', 'AdminAuth\LoginController@showLoginForm');
    Route::get('/login', 'AdminAuth\LoginController@showLoginForm')->name('admin_login');
    Route::post('/login', 'AdminAuth\LoginController@login');
    Route::post('/logout', 'AdminAuth\LoginController@logout');

    Route::get('/register', 'AdminAuth\RegisterController@showRegistrationForm');
    Route::post('/register', 'AdminAuth\RegisterController@register');

    Route::post('/password/email', 'AdminAuth\ForgotPasswordController@sendResetLinkEmail');
    Route::post('/password/reset', 'AdminAuth\ResetPasswordController@reset');
    Route::get('/password/reset', 'AdminAuth\ForgotPasswordController@showLinkRequestForm');
    Route::get('/password/reset/{token}', 'AdminAuth\ResetPasswordController@showResetForm');


    //COUNTRY
    Route::get('/country-information', 'CMS\CountryInformationController@index');
    Route::get('/country-information/create', 'CMS\CountryInformationController@create');
    Route::post('/country-information/store', 'CMS\CountryInformationController@store');
    Route::get('/country-information/edit/{id}', 'CMS\CountryInformationController@edit');
    Route::post('/country-information/update/{id}', 'CMS\CountryInformationController@update');
    Route::post('/country-information/destroy', 'CMS\CountryInformationController@destroy');

    Route::get('/country-information/list/{country_id}/{information_filter_id}', 'CMS\CountryInformationController@information_list');

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



  Route::get('/filter', 'CMS\FilterController@index')->name('filter.index');
  Route::get('/filter/create', 'CMS\FilterController@create');
  Route::post('/filter/store', 'CMS\FilterController@store');
  Route::get('/filter/edit/{id}', 'CMS\FilterController@edit');
  Route::post('/filter/update/{id}', 'CMS\FilterController@update');
  Route::get('/filter/destroy/{id}', 'CMS\FilterController@destroy');
  //BANNER
  Route::get('/banner', 'CMS\BannerController@index')->name('banner.index');
  Route::get('/banner/create', 'CMS\BannerController@create');
  Route::post('/banner/store', 'CMS\BannerController@store');
  Route::get('/banner/edit/{id}', 'CMS\BannerController@edit');
  Route::post('/banner/update/{id}', 'CMS\BannerController@update');
  Route::get('/banner/destroy/{id}', 'CMS\BannerController@destroy');
  //PAGE
  Route::get('/page', 'CMS\PageController@index')->name('page.index');
  Route::get('/page/create', 'CMS\PageController@create');
  Route::post('/page/store', 'CMS\PageController@store');
  Route::post('/page/search', 'CMS\PageController@search');
  Route::get('/page/edit/{id}', 'CMS\PageController@edit');
  Route::post('/page/update/{id}', 'CMS\PageController@update');
  Route::get('/page/destroy/{id}', 'CMS\PageController@destroy');

  //PAYMENT
  Route::get('/payment', 'CMS\PaymentController@index')->name('payment.index');
  Route::get('/payment/create', 'CMS\PaymentController@create');
  Route::post('/payment/store', 'CMS\PaymentController@store');
  Route::get('/payment/edit/{id}', 'CMS\PaymentController@edit');
  Route::post('/payment/update/{id}', 'CMS\PaymentController@update');
  Route::get('/payment/destroy/{id}', 'CMS\PaymentController@destroy');
    Route::post('/payment/date-range-search', 'CMS\PaymentController@date_range_search');



   //Menu
  Route::get('/menu', 'CMS\MenuController@index')->name('menu.index');
  Route::get('/menu/type-edit/{id}', 'CMS\MenuController@type_edit')->name('type-edit');
  Route::post('/menu/type-update/{id}', 'CMS\MenuController@type_update');
  Route::get('/menu-list/{id}', 'CMS\MenuController@menu_list')->name('menu-list');
  Route::get('/get-sub-menu/{id}', 'CMS\MenuController@getSubMenus')->name('get-sub-menu');
  Route::get('/menu/create', 'CMS\MenuController@create')->name('menu-create');
  Route::post('/menu/store', 'CMS\MenuController@store');
  Route::get('/menu/edit/{id}', 'CMS\MenuController@edit')->name('menu-edit');
  Route::post('/menu/update/{id}', 'CMS\MenuController@update');
  Route::get('/menu/destroy/{id}', 'CMS\MenuController@destroy')->name('menu-destroy');


 Route::get('/system-setting', 'CMS\SystemSettingController@index')->name('system-setting.index');
  Route::get('/system-setting/create', 'CMS\SystemSettingController@create');
  Route::post('/system-setting/store', 'CMS\SystemSettingController@store');
  Route::get('/system-setting/edit/{id}', 'CMS\SystemSettingController@edit');
  Route::post('/system-setting/update/{id}', 'CMS\SystemSettingController@update');
  Route::get('/system-setting/destroy/{id}', 'CMS\SystemSettingController@destroy');
  /*end filter module backend*/
Route::get('/access-not-allowed', 'AdminAuth\Account\PermissionController@access_not_allowed');
    Route::get('/roles-and-permission', 'AdminAuth\Account\PermissionController@index');
    Route::get('/roles-and-permission/create', 'AdminAuth\Account\PermissionController@create');
    Route::post('/roles-and-permission/store', 'AdminAuth\Account\PermissionController@store');
    Route::get('/roles-and-permission/edit/{id}', 'AdminAuth\Account\PermissionController@edit');
    Route::post('/roles-and-permission/update/{id}', 'AdminAuth\Account\PermissionController@update');
    Route::post('/roles-and-permission/delete', 'AdminAuth\Account\PermissionController@destroy');

    Route::get('/roles/create', 'AdminAuth\Account\PermissionController@create_roles');
    Route::post('/roles/store', 'AdminAuth\Account\PermissionController@store_roles');
    Route::get('/roles/edit/{id}', 'AdminAuth\Account\PermissionController@edit_roles');
    Route::post('/roles/update/{id}', 'AdminAuth\Account\PermissionController@update_roles');
    Route::post('/roles/delete', 'AdminAuth\Account\PermissionController@delete_roles');

	 /*Email Templates route start*/
  Route::get('/email-template', 'CMS\EmailTemplateController@index')->name('email-template.index');
  Route::get('/email-template/create/', 'CMS\EmailTemplateController@create');
  Route::post('/email-template/store', 'CMS\EmailTemplateController@store');
  Route::get('/email-template/edit/{id}', 'CMS\EmailTemplateController@edit');
  Route::post('/email-template/update/{id}', 'CMS\EmailTemplateController@update');
  //Route::get('/email-template/destroy/{id}', 'CMS\EmailTemplateController@destroy');
  /*Email Templates route end*/

});

Route::get('/country-information-details', 'CMS\PagesController@country_information_details');

Route::get('/{page}', 'CMS\PagesController@index');

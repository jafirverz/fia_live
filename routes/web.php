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

use App\Page;


Route::get('/home', 'HomeController@index')->name('home');
Route::get('/', 'HomeController@index')->name('home');
Route::get('/email-verification/{id}','Auth\RegisterController@emailVerification');
Route::get('/resend-email-verification','Auth\RegisterController@resendEmailVerification');
Route::post('/resend-email-verification','Auth\RegisterController@resendEmailVerificationPost')->name('resend.email.verification');
Route::get('/register', 'Auth\RegisterController@showRegistrationForm');
Route::get('/register/verification/{user_id}', 'Auth\RegisterController@verification');
Route::get('/login', 'Auth\LoginController@showLoginForm');
Auth::routes();
Route::get('/clear', function () {
    $exitCode2 = \Illuminate\Support\Facades\Artisan::call('cache:clear');
    $exitCode2 = \Illuminate\Support\Facades\Artisan::call('config:clear');
    $exitCode1 = \Illuminate\Support\Facades\Artisan::call('config:cache');
    $exitCode1 = \Illuminate\Support\Facades\Artisan::call('route:clear');
    $exitCode3 = \Illuminate\Support\Facades\Artisan::call('view:clear');
    //$exitCode3 = \Illuminate\Support\Facades\Artisan::call('vendor:publish');
    return '<h1>CLEARED All </h1>';

});
Route::get('/storage-link', function () {
    $exitCode2 = \Illuminate\Support\Facades\Artisan::call('storage:link');

    return $exitCode2;

});

Route::get('/safelogin', 'AdminAuth\LoginController@showLoginForm')->name('admin_login');
Route::group(['prefix' => 'admin'], function () {

    Route::get('/profile/edit', 'AdminAuth\ProfileController@edit');
    Route::post('/profile/update', 'AdminAuth\ProfileController@update');
    //Route::get('/', 'AdminAuth\LoginController@showLoginForm');

    Route::post('/login', 'AdminAuth\LoginController@login');
    Route::post('/logout', 'AdminAuth\LoginController@logout');

    // Route::get('/register', 'AdminAuth\RegisterController@showRegistrationForm');
    // Route::post('/register', 'AdminAuth\RegisterController@register');


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
    Route::post('/country-information/check-view-order', 'CMS\CountryInformationController@checkViewOrder');

    Route::get('/country-information/list/{country_id}/{information_filter_id}', 'CMS\CountryInformationController@information_list');

    //REGULATORY
    Route::get('/regulatory', 'CMS\RegulatoryController@index');
    Route::get('/regulatory/create', 'CMS\RegulatoryController@create');
    Route::post('/regulatory/store', 'CMS\RegulatoryController@store');
    Route::get('/regulatory/edit/{id}', 'CMS\RegulatoryController@edit');
    Route::post('/regulatory/update/{id}', 'CMS\RegulatoryController@update');
    Route::post('/regulatory/destroy', 'CMS\RegulatoryController@destroy');

    Route::get('/regulatory/list/{parent_id}', 'CMS\RegulatoryListController@index');
    Route::get('/regulatory/list/{parent_id}/create', 'CMS\RegulatoryListController@create');
    Route::post('/regulatory/list/{parent_id}/store', 'CMS\RegulatoryListController@store');
    Route::get('/regulatory/list/{parent_id}/edit/{id}', 'CMS\RegulatoryListController@edit');
    Route::post('/regulatory/list/{parent_id}/update/{id}', 'CMS\RegulatoryListController@update');
    Route::post('/regulatory/list/{parent_id}/destroy', 'CMS\RegulatoryListController@destroy');

    Route::get('/regulatory/highlight/edit', 'CMS\RegulatoryHighlightController@edit');
    Route::post('/regulatory/highlight/update', 'CMS\RegulatoryHighlightController@update');

    //TOPIC
    Route::get('/topic', 'CMS\TopicController@index');
    Route::get('/topic/create', 'CMS\TopicController@create');
    Route::post('/topic/store', 'CMS\TopicController@store');
    Route::get('/topic/edit/{id}', 'CMS\TopicController@edit');
    Route::post('/topic/update/{id}', 'CMS\TopicController@update');
    Route::post('/topic/destroy', 'CMS\TopicController@destroy');

    //CONTACT
    Route::get('/contact-enquiry', 'CMS\ContactEnquiryController@index');
    Route::post('/user-bulk-delete', 'CMS\ContactEnquiryController@bulkRemove')->name('user-bulk-remove');

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
    Route::get('/banner/type/{type}', 'CMS\BannerController@index');
    Route::get('/banner/create', 'CMS\BannerController@create')->name('banner.create');
    Route::post('/banner/store', 'CMS\BannerController@store');
    Route::get('/banner/edit/{id}', 'CMS\BannerController@edit')->name('banner.edit');
    Route::post('/banner/update/{id}', 'CMS\BannerController@update');
    Route::get('/banner/destroy/{id}', 'CMS\BannerController@destroy')->name('banner.destroy');
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
    Route::get('/payment/view/{id}', 'CMS\PaymentController@view');
    Route::get('/payment/destroy/{id}', 'CMS\PaymentController@destroy');
    Route::post('/payment/date-range-search', 'CMS\PaymentController@date_range_search');


    //Menu
    Route::get('/menu', 'CMS\MenuController@index')->name('menu');
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
    //FEATURED RESOURCES
	Route::get('/featured-resources', 'CMS\FeaturedResourceController@index')->name('featured-resources.index');
	Route::post('/featured-resources/detail', 'CMS\FeaturedResourceController@detail');
	Route::post('/featured-resources/update', 'CMS\FeaturedResourceController@update');
    /*Email Templates route start*/
    Route::get('/email-template', 'CMS\EmailTemplateController@index')->name('email-template.index');
    Route::get('/email-template/create/', 'CMS\EmailTemplateController@create');
    Route::post('/email-template/store', 'CMS\EmailTemplateController@store');
    Route::get('/email-template/edit/{id}', 'CMS\EmailTemplateController@edit');
    Route::post('/email-template/update/{id}', 'CMS\EmailTemplateController@update');
    //Route::get('/email-template/destroy/{id}', 'CMS\EmailTemplateController@destroy');
    /*Email Templates route end*/
    Route::get('/events', 'CMS\EventsController@index')->name('events.index');
    Route::get('/events/create', 'CMS\EventsController@create');
    Route::post('/events/store', 'CMS\EventsController@store');
    Route::get('/events/edit/{id}', 'CMS\EventsController@edit');
    Route::post('/events/update/{id}', 'CMS\EventsController@update');
    Route::get('/events/destroy/{id}', 'CMS\EventsController@destroy');
	
	/**/
	Route::get('/thinking_piece', 'CMS\ThinkingPieceController@index')->name('thinking_piece.index');
    Route::get('/thinking_piece/create', 'CMS\ThinkingPieceController@create');
    Route::post('/thinking_piece/store', 'CMS\ThinkingPieceController@store');
    Route::get('/thinking_piece/edit/{id}', 'CMS\ThinkingPieceController@edit');
    Route::post('/thinking_piece/update/{id}', 'CMS\ThinkingPieceController@update');
    Route::get('/thinking_piece/destroy/{id}', 'CMS\ThinkingPieceController@destroy');

    Route::get('/topical-report', 'CMS\TopicalReportController@index')->name('topical_report.index');
    Route::get('/topical-report/create', 'CMS\TopicalReportController@create');
    Route::post('/topical-report/store', 'CMS\TopicalReportController@store');
    Route::get('/topical-report/edit/{id}', 'CMS\TopicalReportController@edit');
    Route::post('/topical-report/update/{id}', 'CMS\TopicalReportController@update');
    Route::get('/topical-report/destroy/{id}', 'CMS\TopicalReportController@destroy');
	
	//PODCAST
	Route::get('/podcast', 'CMS\PodcastController@index')->name('podcast.index');
    Route::get('/podcast/create', 'CMS\PodcastController@create');
    Route::post('/podcast/store', 'CMS\PodcastController@store');
    Route::get('/podcast/edit/{id}', 'CMS\PodcastController@edit');
    Route::post('/podcast/update/{id}', 'CMS\PodcastController@update');
    Route::get('/podcast/destroy/{id}', 'CMS\PodcastController@destroy');

    /*start User Module backend*/
    
	Route::get('/user', 'CMS\UserController@index')->name('user.index');
	Route::get('/user/log-status/{id}', 'CMS\UserController@log_status');
    Route::get('/user/create', 'CMS\UserController@create');
    Route::post('/user/store', 'CMS\UserController@store');
    Route::get('/user/search', 'CMS\UserController@index');
    Route::post('/user/search', 'CMS\UserController@search');
    Route::get('/user/edit/{id}', 'CMS\UserController@edit');
    Route::get('/user/view/{id}', 'CMS\UserController@view');
    Route::post('/user/update/{id}', 'CMS\UserController@update');
    Route::post('/user/update-status', 'CMS\UserController@updateStatus');
    Route::get('/user/destroy/{id}', 'CMS\UserController@destroy');
    Route::get('/user/update-status', 'CMS\UserController@updateStatus')->name('update-status');
    Route::get('/user/cron', 'CMS\UserController@userStatusExpired')->name('cron');
    Route::get('/user/weekly-report', 'CMS\UserController@weeklyReport')->name('weekly-report');
    /*end user module backend*/

    /*Master Setting Start*/
    Route::get('/master-setting', 'CMS\MasterSettingController@index')->name('master-setting.index');
    Route::get('/master-setting/create', 'CMS\MasterSettingController@create');
    Route::post('/master-setting/store', 'CMS\MasterSettingController@store');
    Route::get('/master-setting/edit/{id}', 'CMS\MasterSettingController@edit');
    Route::post('/master-setting/update/{id}', 'CMS\MasterSettingController@update');
    Route::get('/master-setting/destroy/{id}', 'CMS\MasterSettingController@destroy');
    /*Master Setting End*/

});
Route::get('/contact-us', 'ContactController@index');
Route::post('/contact-store', 'ContactController@store')->name('contacts');
Route::post('/feedback-store', 'ContactController@feedback_store')->name('feedbacks');
Route::get('/feedback-store', 'ContactController@feedback_store')->name('feedbacks');
Route::post('/events/search', 'EventController@search');
Route::get('/events/search', 'EventController@search');
Route::get('/events', 'EventController@index')->name('events');
Route::get('/topical-reports', 'EventController@reports')->name('reports');
Route::post('/topical-reports/search', 'EventController@search_report');

Route::get('/topical-reports/search', 'EventController@search_report');
Route::get('/event/{slug}', 'EventController@detail');
Route::get('/country-information-details', 'PagesFrontController@country_information_details');
Route::get('/country-information-print', 'PagesFrontController@country_information_print');
Route::get('/regulatory-details/{slug}', 'PagesFrontController@regulatory_details');
Route::post('/load-more-regulatories', 'PagesFrontController@loadMoreRegulatories');
Route::get('/regulatory-details-search', 'PagesFrontController@regulatory_details_search');
Route::get('/regulatory-print/{slug}', 'PagesFrontController@regulatory_print');
Route::post('/profile-update/{student_id}', 'PagesFrontController@profileUpdate');
Route::get('/profile-detail', 'PagesFrontController@profileDetail');
Route::post('/update-profile-status', 'PagesFrontController@updateStatus');
Route::get('/update-profile-status', 'PagesFrontController@updateStatus')->name('update-profile-status');
Route::post('/subscribers', 'HomeController@subscribers');
Route::get('/subscribers', 'HomeController@subscribers');
Route::get('/post-unsubscribe/{id}', 'HomeController@unsubscribe');
Route::get('/unsubscribe', 'HomeController@getUnsubscribe');

Route::get('/search-results', 'HomeController@search');
Route::get('/country-information-category', 'HomeController@get_category');
Route::get('/search-results-regulatory', 'HomeController@search_regulatory');
Route::get('/change-password', 'PagesFrontController@showChangePassword');
Route::post('/change-password', 'PagesFrontController@updateChangePassword');

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

//Route::post('/podcast', 'PodcastController@index');
Route::get('/thinking-piece', 'ThinkingPieceController@index');
Route::get('/thinking-piece/search', 'ThinkingPieceController@search');
Route::get('/thinking-piece/{slug}', 'ThinkingPieceController@detail');
Route::get('/podcast', 'PodcastController@index');
Route::get('/podcast/search', 'PodcastController@search');
Route::get('/subscription', 'PayPalController@getIndex');
Route::get('paypal/ec-checkout', 'PayPalController@getExpressCheckout');
Route::get('paypal/ec-checkout-success', 'PayPalController@getExpressCheckoutSuccess');
Route::get('paypal/adaptive-pay', 'PayPalController@getAdaptivePay');
Route::post('paypal/notify', 'PayPalController@notify');
Route::get('recurring-profile/{id}', 'PayPalController@recurringPaymentProfileDetail');
Route::get('recurring-profile-update/{id}', 'PayPalController@recurringPaymentProfileDetailUpdate');

Route::get('/{slug}', 'PagesFrontController@index');

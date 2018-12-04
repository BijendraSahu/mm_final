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

/***********************Custom Route********************************/
Route::get('access', function () {
    return view('login');
});

Route::get('test', function () {
    return view('web.profile.test');
});

Route::GET('logout', function () {
    session_start();
    $_SESSION['user_master'] = null;
    return redirect('/');
});
Route::GET('adminlogout', function () {
    session_start();
    $_SESSION['admin_master'] = null;
    return redirect('/access');
});

Route::get('create-category', 'CategoryController@create');
Route::post('create-category', 'CategoryController@store');

Route::GET('change_password', function () {
    return view('change_password');
});
Route::POST('reset_password', 'LoginMasterController@reset_password');
Route::GET('user_master/{id}/resetPassword', 'LoginMasterController@reset');

Route::get('verify_otp', 'User_loginController@verify_otp');
Route::get('forgot_password', 'User_loginController@forgot_password');

Route::POST('change_password', 'LoginMasterController@change_password');

Route::get('hotel/{id}/booked', 'HotelMasterController@booked');
Route::get('hotel/{id}/available', 'HotelMasterController@available');

Route::get('hotel_info/{id}/info', 'HotelInfoController@index');
Route::get('hotel_info/{id}/create', 'HotelInfoController@create');
Route::GET('dashboard', 'LoginMasterController@login_user');
/****************************Crud Route******************************/
Route::resource('home', 'LoginMasterController');
Route::post('admin_login', 'LoginMasterController@store');
Route::resource('user_master', 'ProfileController');
Route::get('user_list', 'ProfileController@user_list');
Route::resource('hotel', 'HotelMasterController');
Route::resource('hotel_info', 'HotelInfoController');
/****************************Crud Route******************************/


/********delete Route***********/
Route::get('hotel/{id}/delete', 'HotelMasterController@destroy');
Route::get('user_master/{id}/delete', 'UserMasterController@destroy');
Route::get('user_master/{id}/activate', 'UserMasterController@activate');
Route::get('mark_as_paid/{id}', 'UserMasterController@mark_as_paid');
Route::get('mark_as_unpaid/{id}', 'UserMasterController@mark_as_unpaid');
/********delete Route***********/

Route::get('getdetails', 'UserMasterController@getdetails');

/***************Frontend*******************/

Route::get('/', 'FrontendController@home');
Route::get('registration', 'FrontendController@registration');
Route::get('a_registration', 'FrontendController@a_registration');
Route::post('search', 'FrontendController@ajax_candidate_list');//candidate list
Route::get('candidate_list', 'FrontendController@candidate_list');//candidate list
Route::get('view_profile/{id}', 'FrontendController@view_candidate');//candidate list
Route::get('view_profile_admin/{id}', 'FrontendController@view_candidate_admin');//candidate list
Route::get('membership', 'FrontendController@membership');//candidate list
Route::get('userProfiles', 'FrontendController@userProfiles');//candidate list


Route::get('candidates/{id}', 'FrontendController@candidates');
Route::get('search_by_id', 'FrontendController@search_by_id');


Route::POST('searchfilter', 'FrontendController@candidate_list');
Route::get('refine_candidate_list', 'FrontendController@refine_candidate_list');
Route::POST('profile_update', 'User_loginController@profile_update');

Route::get('advance_search', 'FrontendController@advance_search');
Route::post('search_advance', 'FrontendController@search_advance');
Route::get('get_search_advance', 'FrontendController@get_search_advance');

Route::post('search_side', 'FrontendController@search_side');
Route::get('get_search_side', 'FrontendController@get_search_side');

Route::get('desire_candidates', 'FrontendController@desire_candidates');


Route::get('getUpload', 'User_loginController@getUpload');
Route::POST('upload_pic', 'User_loginController@upload_pic');
Route::get('picture/{id}/delete', 'User_loginController@getUploadedUpdate');

Route::get('getAadhar', 'User_loginController@getAadhar');
Route::POST('aadhar_upload', 'User_loginController@aadhar_upload');
Route::get('aadhar/{id}/delete', 'User_loginController@aadharUpdate');


Route::post('register', 'User_loginController@register');
Route::get('login_user', 'User_loginController@login');

///interest
Route::post('sendrequest', 'ProfileController@sendrequest');
Route::post('cancelrequest', 'ProfileController@cancelrequest');
Route::post('acceptfrequest', 'ProfileController@acceptfrequest');
Route::get('wunfriend', 'ProfileController@unfriend');

Route::get('viewcontact', 'ProfileController@viewcontact');
Route::get('show_contact', 'ProfileController@show_contact');
Route::get('show_contact_admin', 'ProfileController@show_contact_admin');


Route::get('myp', 'ProfileController@myprofile');//myprofile
Route::get('edit_profile', 'ProfileController@edit_profile');//myprofile
Route::get('profile_photo', 'ProfileController@profile_photo');//profile_photo
Route::post('change_password', 'ProfileController@change_password');

Route::get('getpayment', 'FrontendController@payment');
Route::post('success', 'FrontendController@payment_success');
Route::post('failed', 'FrontendController@payment_failed');

Route::get('privacy_control', 'FrontendController@getprivacy_control');
Route::post('privacy_update', 'FrontendController@privacy_update');
Route::get('contact_us', 'FrontendController@contact_us');
Route::get('policy', 'FrontendController@policy');

Route::get('payment', function () {
    return view('web.payment');
});


/***************Frontend*******************/


//admin

Route::get('edit_profile/{id}', 'ProfileController@edit_profile_admin');//myprofile
Route::POST('profile_update_admin', 'User_loginController@profile_update_admin');

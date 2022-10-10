<?php

use Illuminate\Support\Facades\Route;

Route::group(['middleware' => 'auth'], function(){
    Route::get('/dashboard', 'CommunitiesController@showCommunities')->name('dashboard');
    Route::get('/profile/settings', 'UserController@getProfileInfo')->name('profileSettings');
    Route::view('/change/password', 'changePassword')->name('changePassword');
    Route::view('/join', 'joinCommunity')->name('joinCommunity');
    Route::view('/create', 'createCommunity')->name('createCommunity');

	Route::group(['prefix' => '{code}', 'middleware' => 'neighbor_exists'], function(){
	    Route::group(['middleware' => 'is_admin'], function (){
            Route::get('/waiting/room', 'NeighborsController@showPendings')->name('waitingRoom');
            Route::get('/mark/as/denied/{email}', 'NeighborsController@markAsDenied')->name('markAsDenied');
            Route::get('/mark/as/accepted/{email}', 'NeighborsController@markAsAccepted')->name('markAsAccepted');
        });

        Route::group(['middleware' => 'is_treasurer'], function (){
            Route::get('/add/payment', 'PaymentsController@showAddPaymentPage')->name('addPayment');
            Route::get('change/is/paid/{month}/{type}/{apNum}/{isPaid}', 'PaymentsController@changeIsPaid')->name('changeIsPaid');
        });

        Route::get('/redirect/to/main/page', 'NeighborsController@redirectToMainPage')->name('mainPage');
        Route::get('/community', 'CommunitiesController@myCommunity')->name('community');
        Route::get('/messenger/{id?}', 'MessageController@load')->name('messenger');
        Route::get('/neighbors', 'NeighborsController@showNeighbors')->name('neighbors');
        Route::get('payments/{month?}/{type?}', 'PaymentsController@showPayments')->name('payments');
        Route::get('payments/{month}/{type}/orderBy={orderBy}/{direction}', 'PaymentsController@sortPayments')->name('sortPayments');
    });
});

Route::view('/', 'index')->name('index');
Route::view('/login', 'login')->name('login');
Route::view('/sign/up', 'signUp')->name('signUp');

Route::post('/post/create/community', 'CommunitiesController@createCommunity')->name('postCreateCommunity');
Route::post('/post/save/message', 'MessageController@store')->name('saveMessage');
Route::post('/post/send/message/all', 'MessageController@sendMessageAll')->name('sendMessageAll');
Route::post('/post/fetch/messages', 'MessageController@fetchMessages')->name('fetchMessages');
Route::post('/post/fetch/contacts/{code}', 'MessageController@fetchContacts')->name('fetchContacts');
Route::post('/post/messages/seen', 'MessageController@makeSeen')->name('makeSeen');
Route::post('/post/count/unseen', 'MessageController@countUnSeenMessages')->name('countUnSeenMessages');
Route::post('/post/sign/up', 'UserController@signUp')->name('postSignUp');
Route::post('/post/log/in', 'UserController@login')->name('postLogin');
Route::get('/post/log/out', 'UserController@logOut')->name('logOut');
Route::post('/post/change/password', 'UserController@changePassword')->name('postChangePassword');
Route::post('/post/check/code', 'CommunitiesController@checkCode')->name('checkCode');
Route::post('/post/check/apartment', 'CommunitiesController@checkApartment')->name('checkApartment');
Route::post('/post/enter/waiting/room', 'NeighborsController@enterWaitingRoom')->name('enterWaitingRoom');
Route::post('/post/change/rights', 'NeighborsController@changeRights')->name('changeRights');
Route::post('/post/add/payment/{code}', 'PaymentsController@addPayment')->name('postAddPayment');
Route::post('/post/change/profile/settings', 'UserController@changeProfileSettings')->name('changeProfileSettings');
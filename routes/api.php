<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes 
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('login', 'AuthController@login'); //okk
Route::post('register', 'AuthController@signup'); //okk
Route::post('resendmail', 'AuthController@reconfirm_account'); //okk
// Route::post('signup/activate/{token}', 'AuthController@signupActivate');
Route::post('resetpassword', 'AuthController@resetpassword'); //okk
Route::post('changeresetpassword', 'AuthController@changeresetpassword'); //okk
Route::post('country', 'AuthController@country'); //okk
//Route::post('refresh', 'AuthController@refreshToken');



//Password Reset
//Route::post('password/email', 'Auth\ForgotPasswordController@getResetToken');
//Route::post('password/reset', 'Auth\ResetPasswordController@reset');

Route::post('gettradepairlist', 'TradeController@gettradepairlist'); //okk
Route::post('getTradeCommissionlist', 'TradeController@getTradeCommission'); //okk

Route::post('coinlist', 'WalletController@coinList'); //okk
Route::get('/marketdepthchart/{pair}', 'ChartController@marketdepthData'); //notok

Route::post('defaultpair', 'TradeController@pairDefault');
Route::post('getcms', 'HomeController@getCms');
Route::post('contactus', 'HomeController@contactsave');
Route::post('gethomepage', 'HomeController@homepage');
Route::post('homelivePrice', 'HomeController@homelivePrice');
Route::post('gethome', 'HomeController@landingPage');
Route::post('getsubscribe', 'HomeController@subscriber');
Route::post('getsocialmedia', 'HomeController@Socialmedia');
Route::post('admindata', 'HomeController@admindata');
Route::post('faq', 'HomeController@faq');
Route::post('getbasicsettings', 'HomeController@generalSettings');

Route::post('getmarketpair', 'TradeController@getMarketPair'); //okk
Route::post('getorderbooknologin', 'TradeController@orderBookNologin'); //okk
// Route::post('orderbooksocket', 'TradeController@orderBookSocket');
// Route::post('commissionsocket', 'TradeController@orderCommission');
//API Documentation
//Route::post('/getapidocument', 'APIController@viewDetails');
Route::middleware('auth:api')->get('/user', 'AuthController@getUser');
Route::group([
    'middleware' => ['api', 'jwt.verify'],
], function ($router) {
    Route::post('removeme', 'UserController@removeme'); // Route added to satisfy the app store requirement. For now users are temporarily deleted.
    Route::post('logout', 'AuthController@logout'); //okk
});
Route::group([
    'middleware' => ['api', 'jwt.verify', 'user_deleted'],
], function ($router) {
    //sendPushToUsers
    // Route::post('sendpushtousers', 'AuthController@sendPushToUsers');
    Route::post('marketpair', 'TradeController@livePrice'); //okk
    Route::post('refresh', 'AuthController@refresh'); //ok
    // Route::post('me', 'AuthController@me');
    Route::post('commissionsocket', 'TradeController@orderCommission'); //notok
    Route::post('usdt_in_kes', 'TradeController@usdt_in_kes'); //notok
    Route::post('orderbooksocket', 'TradeController@orderBookSocket'); //notok
    //Profile
    Route::post('getprofile', 'UserController@userProfileDetails'); //okk
    Route::post('userprofileupdate', 'UserController@profileupdate'); //okk
    Route::post('profileimageupdate', 'UserController@profileimage'); //okk
    // Route::post('profileimageupdatephone','UserController@profileimagePhone');
    Route::post('changepassword', 'UserController@changePassword'); //okk
    //KYC
    Route::post('updatekyc', 'UserController@update_kyc'); //okk
    Route::post('front_upload_id', 'UserController@front_upload_id'); //okk
    Route::post('back_upload_id', 'UserController@back_upload_id'); //okk
    //Route::post('selfie_image','UserController@selfie_img');
    Route::post('address_image', 'UserController@address_img'); //okk
    Route::post('kycdetails', 'UserController@Kycdetails'); //okk

    //Two FA
    Route::post('googleauthenticator', 'UserController@userGoogleAuthenticator'); //okk
    Route::post('enableemailotp', 'UserController@enableEmailTwoFactor'); //okk
    Route::post('disabletwofa', 'UserController@disableTwoFactor'); //okk
    Route::post('generateotp', 'UserController@generateTwoFactorotp'); //okk
    Route::post('verifyotp', 'UserController@verifyTwoFactorotp'); //okk
    Route::post('verifytfa', 'UserController@verifyTfa'); //okk

    //Refresh Twofa Token
    // Route::post('refreshdata','AuthController@refresh123');
    //Wallet    
    Route::post('walletbalance', 'WalletController@walletBalance'); //okk
    Route::post('coindeposit', 'WalletController@deposit_coin'); //okk
    Route::post('fiatdeposit', 'WalletController@AdminBankDetails'); //okk

    Route::post('fiatdepositrequest', 'WalletController@deposit_fiat'); //okk
    Route::post('withdrawdetails', 'WalletController@coinwithdraw_details'); //okk
    Route::post('withdraw/{coin}', 'WalletController@withdraw'); //okk//1268

    Route::post('/fiatbalance', 'WalletController@fiatbalance'); //okk

    //Bank
    Route::post('getbanklist', 'WalletController@getUserBanklist'); //okk
    Route::post('getbankdetails', 'WalletController@getuserBankDetails'); //okk
    Route::post('addbankdetails', 'WalletController@addBankList'); //okk
    Route::post('editbankdetails', 'WalletController@updateBankDetails'); //okk
    Route::post('deletebankdetails', 'WalletController@deleteUserBank'); //okk
    //Histroy
    Route::post('deposithistroy', 'HistroyController@depositHistroy'); //okk
    Route::post('withdrawhistroy', 'HistroyController@withdrawHistroy'); //okk
    Route::post('tradehistroy', 'HistroyController@tradeHistroy'); //okk

    //OrderBook
    Route::post('openorderbook', 'TradeController@openOrderBook');
    Route::post('postbuylimit', 'TradeLimitController@buylimit')->name('buylimit'); //okk
    Route::post('postselllimit', 'TradeLimitController@selllimit')->name('selllimit'); //okk
    Route::post('postbuymarket', 'TradeMarketController@buymarket')->name('buymarket'); //okk
    Route::post('postsellmarket', 'TradeMarketController@sellmarket')->name('sellmarket'); //okk
    Route::post('cancelorder', 'TradeLimitController@cancelOrder')->name('canceltrade'); //okk
    Route::post('getorderbook', 'TradeController@orderBook'); //okk
    Route::post('gettradebalance', 'TradeController@getTradeBalance'); //okk
    Route::post('gettradecommission', 'TradeController@getTradeCommission'); //okk

    //Support Ticket
    Route::post('/ticketlist', 'SupportController@TicketList')->name('ticketlist'); //okk
    Route::post('/createticket', 'SupportController@createTicket')->name('raiseticket'); //okk
    Route::post('/viewchats', 'SupportController@viewTicket')->name('viewchats'); //okk
    Route::post('/replychat', 'SupportController@createChat')->name('replaychat'); //okk

    Route::post('/displaytoken', 'WalletController@displaytoken')->name('displaytoken');

    Route::post('/pusherticketlist', 'SupportController@Pusherticketlist')->name('pusherticketlist'); //okk

    //tinypesa
    Route::post('/tinypesavalidation', 'MpesaController@tinyvalidation')->name('tinypesavalidation'); //okk

});

<?php

use App\Http\Controllers\API\V1\ApiController;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['prefix' => 'v1',], function ($route) {
    $route->group(['namespace' => 'App\Http\Controllers\API\V1'], function ($backendroute) {
        $backendroute->post('/register-user', [ApiController::class, 'registerUser']);
        $backendroute->post('/login-user', [ApiController::class, 'userLogin']);
        $backendroute->post('/forgot-password-user', [ApiController::class, 'userForgotPassword']);
        $backendroute->post('/verify-otp-user', [ApiController::class, 'userVerifyOtp']);
        $backendroute->post('/reset-password-user', [ApiController::class, 'resetPassword']);
        $backendroute->get('/aboutus', [ApiController::class, 'aboutUs']);
        $backendroute->get('/privacypolicy', [ApiController::class, 'privacyPolicy']);
        $backendroute->get('/termsconditions', [ApiController::class, 'TermsConditions']);
        $backendroute->get('/testcronjob', [ApiController::class, 'testCronJob']);
        $backendroute->post('/socialLogin', [ApiController::class, 'socialLogin']);

        Route::get('send-notification',[ApiController::class, 'testNotification']);


        Route::middleware(['auth:sanctum', 'verified'])->group(function ($route) {
            $route->get('/get-profile-user', [ApiController::class, 'getUserProfile']);
            $route->post('/update-profile-user', [ApiController::class, 'updateUserProfile']);
            $route->post('/update-email', [ApiController::class, 'updateEmail']);
            $route->post('/update-password', [ApiController::class, 'updatePassword']);
            $route->post('/user-address-create', [ApiController::class, 'createUserAddress']);
            $route->post('/help-and-support', [ApiController::class, 'createHelpAndSupport']);
            $route->post('/update-user-address', [ApiController::class, 'updateUserAddress']);

            /* -----------------Business Details With Sub Module------------------------- */
            $route->get('/get-business-detail', [ApiController::class, 'getBusinessDetail']);
            $route->post('/get-business', [ApiController::class, 'getBusinessById']);
            $route->get('/servicelist', [ApiController::class, 'serviceList']);
            $route->get('/getbusinessrecentvisits', [ApiController::class, 'getBusinessRecentVisits']);
            $route->post('/getbusinessserviceandsubservice', [ApiController::class, 'getBusinessServiceAndSubService']);
            $route->post('/bookappointment', [ApiController::class, 'bookAppointment']);
            $route->get('/getfaqlist', [ApiController::class, 'getFaqList']);
            $route->post('/addusercarddetails', [ApiController::class, 'addUserCardDetails']);
            $route->get('/getusercardlist', [ApiController::class, 'getUserCardList']);
            $route->get('/appointmentlist', [ApiController::class, 'getAppointmentList']);
            $route->post('/editappointment', [ApiController::class, 'editAppointment']);
            $route->post('/cancelappointment', [ApiController::class, 'cancelAppointment']);
            $route->get('/getnotificationlist', [ApiController::class, 'getNotificationList']);
            $route->post('/appointmentpayment', [ApiController::class, 'appointmentPayment']);
            $route->post('/getteammemberlistbusinesssubservicewise', [ApiController::class, 'getTeammemberListBusinessSubServiceWise']);
            $route->post('/getteammembertimeslotlist', [ApiController::class, 'getTeammemberTimeSlotList']);
            $route->post('/getbusinessofferslist', [ApiController::class, 'getBusinessOffersList']);
            $route->post('/updatedevicetoken', [ApiController::class, 'updateDeviceToken']);
            $route->post('/checkoffer', [ApiController::class, 'checkOffer']);
            $route->post('/getappointmentbyid', [ApiController::class, 'getAppointmentById']);
            $route->post('/getappointmentbyidbusiness', [ApiController::class, 'getAppointmentByIdBusiness']);
            $route->post('/logout', [ApiController::class, 'logout']);
        });
    });
});

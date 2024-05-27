<?php

use App\Models\User;
use App\Models\BusinessNotification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Notification;
use App\Http\Controllers\admin\CmsController;
use App\Http\Controllers\admin\FaqController;
use App\Http\Controllers\admin\AdminController;
use App\Http\Controllers\admin\UsersController;
use App\Http\Controllers\admin\ProfileController;
use App\Http\Controllers\admin\BusinessController;
use App\Http\Controllers\admin\EFoodFaqController;
use App\Http\Controllers\admin\ServicesController;
use App\Http\Controllers\admin\DashboardController;
use App\Http\Controllers\admin\EFoodTypeController;
use App\Http\Controllers\admin\AdminLoginController;
use App\Http\Controllers\admin\AdminSubscriptionController;
use App\Http\Controllers\admin\AdminVideoController;
use App\Http\Controllers\admin\EFoodUsersController;
use App\Http\Controllers\admin\EFoodOwnersController;
use App\Http\Controllers\admin\SiteSettingController;

use App\Http\Controllers\admin\TeamMembersController;
use App\Http\Controllers\business\AppUsersController;
use App\Http\Controllers\admin\EFoodCuisineController;
use App\Http\Controllers\admin\BusinessOfferController;
use App\Http\Controllers\admin\BusinessOwnerController;
use App\Http\Controllers\admin\BusinessUsersController;
use App\Http\Controllers\admin\ForgotPasswordController;
use App\Http\Controllers\admin\HelpAndSupportController;
use App\Http\Controllers\admin\BusinessServiceController;
use App\Http\Controllers\admin\OrderManagementController;
use App\Http\Controllers\business\AppointmentsController;
use App\Http\Controllers\business\BusinessLoginController;
use App\Http\Controllers\admin\BusinessTeamMemberController;
use App\Http\Controllers\business\BusinessProfileController;
use App\Http\Controllers\business\BusinessDashboardController;
use App\Http\Controllers\business\BusinessTeamMemberTimeSlotController;
use App\Http\Controllers\business\BusinessUserBusinessOfferController;
use App\Http\Controllers\admin\BusinessAppointmentController;
use App\Http\Controllers\business\BusinessNotificationController;
use App\Http\Controllers\business\BusinessSubscriptionController;
use App\Http\Controllers\business\BusinessForgotPasswordController;
use App\Http\Controllers\business\BusinessSettingsController;
use App\Http\Controllers\admin\AdminNotificationController;
use App\Http\Controllers\admin\AdminReportController;
use App\Http\Controllers\business\BusinessVideoController;
use App\Http\Controllers\business\BusinessSendNotificationController;
use App\Http\Controllers\business\BusinessCMSController;




use App\Http\Controllers\Cronjob\CronJobController;

use App\Notifications\UserBookingNotification;
use App\Http\Controllers\business\SubServicesController;


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
Route::get('/clear-compiled', function () {
    Artisan::call('clear-compiled');
});

Route::get('/clear-optimize', function () {
    Artisan::call('optimize:clear');
    echo '<script>alert("Clear Success")</script>';
});

Route::get('/clear1', function () {

    Artisan::call('config:clear');
});
Route::get('/clear2', function () {
    Artisan::call('cache:clear');
});

Route::get('/clear', function () {
    Artisan::call('cache:clear');
    Artisan::call('config:clear');
    Artisan::call('config:cache');
    Artisan::call('view:clear');
    Artisan::call('route:clear');
    echo '<script>alert("All Cache & Clear Success")</script>';
});
Route::get('getCustomer', [CronJobController::class, 'getCustomer'])->name('getCustomer');
Route::get('sendReminderNotification', [CronJobController::class, 'sendReminderNotification'])->name('sendReminderNotification');
Route::get('sendOrderNotification', [CronJobController::class, 'sendOrderNotification'])->name('sendOrderNotification');
Route::get('sendDayBeforeNotification', [CronJobController::class, 'sendDayBeforeNotification'])->name('sendDayBeforeNotification');
Route::get('sendTwentyMinsAgoNotification', [CronJobController::class, 'sendTwentyMinsAgoNotification'])->name('sendTwentyMinsAgoNotification');
Route::get('privacy-policy', [BusinessCMSController::class, 'index'])->name('privacy-policy');
Route::get('cookies', [BusinessCMSController::class, 'list'])->name('cookies');
Route::get('terms-conditions', [BusinessCMSController::class, 'terms'])->name('terms-conditions');



Route::post('save-token', [BusinessSendNotificationController::class, 'saveToken'])->name('save-token');
Route::post('send-notification', [BusinessSendNotificationController::class, 'sendNotification'])->name('send.notification');
Route::get('testing', [BusinessSendNotificationController::class, 'index'])->name('testing');

Route::group(['namespace' => 'App\Http\Controllers'], function () {

    if (Auth::guard('admin')->check()) {
        $this->data['module'] = 'Dashboard';
        return view('dashboard', $this->data);
    } else {
        Route::get('admin-login', [AdminLoginController::class, 'index'])->name('admin-login');
        Route::post('/authenticate', [AdminLoginController::class, 'store'])->name('admin-authenticate');
        Route::post('/admin-logout', [AdminLoginController::class, 'logout'])->name('admin-logout');
        Route::get('/email-html', [UsersController::class, 'emailHtml'])->name('email');

        /*---------------------------ForgotPassword-------------------------*/
        Route::get('admin-forgot-password', [ForgotPasswordController::class, 'list'])->name('admin-forgot-password');

        Route::post('check-email1', [ForgotPasswordController::class, 'verifyEmail'])->name('admin-check-email');
        Route::get('reset-password-view/{id}', [ForgotPasswordController::class, 'resetPasswordView'])->name('admin-reset-password-view');
        Route::post('reset-password/{id}', [ForgotPasswordController::class, 'resetPassword'])->name('admin-reset-password');
        Route::get('admin-check-email', [ForgotPasswordController::class, 'checkEmail'])->name('admin-user-email');
        Route::post('admin-reset-password/{id}', [ForgotPasswordController::class, 'resetPassword'])->name('admin-reset-password');
    }
});

if (Auth::guard('business_user')->check()) {
    return redirect()->route('business-dashboard');
} else {

    Route::get('business-register', [BusinessLoginController::class, 'register'])->name('business-register');
    Route::post('business-store', [BusinessLoginController::class, 'storeRegister'])->name('store-register');
    Route::get('verify-business-user', [BusinessLoginController::class, 'checkBusinessUser'])->name('verify-register');
    Route::get('conform-email/{email}', [BusinessLoginController::class, 'checkBusinessUser']);
    Route::get('check-business-email', [BusinessLoginController::class, 'checkEmail'])->name('businessuser-check-email');

    Route::get('/app-link', [BusinessLoginController::class, 'appDownloadLink'])->name('app-link');

    Route::get('business-login', [BusinessLoginController::class, 'login'])->name('business-login');
    Route::post('business-authenticate', [BusinessLoginController::class, 'checkCreadentials'])->name('business-authenticate');
    Route::post('business-logout', [BusinessLoginController::class, 'logout'])->name('business-logout');
    Route::get('business-forgot-password', [BusinessForgotPasswordController::class, 'List'])->name('business-forgot-password');
    Route::get('check-email1', [BusinessForgotPasswordController::class, 'checkEmail'])->name('business-check-email');
    Route::post('send-link', [BusinessForgotPasswordController::class, 'sendLink'])->name('business-send-link');
    Route::get('business-reset-password/{email}/{token}', [BusinessForgotPasswordController::class, 'checkLink'])->name('business-check-link');
    Route::post('business-reset-password', [BusinessForgotPasswordController::class, 'resetPassword'])->name('business-reset-password');
}


Route::middleware(['auth:business_user', 'verified'])->group(function ($route) {
    $route->group(['namespace' => 'App\Http\Controllers\business'], function ($businessVerified) {

        /*------------------------Business User Paymenet-------------------------------*/
        $businessVerified->get('/subscription', [BusinessLoginController::class, 'subscription'])->name('subscription');
        $businessVerified->get('/upgrade-subscription', [BusinessLoginController::class, 'upgradeSubscription'])->name('upgrade-subscription');
        $businessVerified->get('/cancel-subscription', [BusinessLoginController::class, 'cancelSubscription'])->name('cancel-subscription');
        $businessVerified->get('subscription-purchase', [BusinessLoginController::class, 'subscription_purchase'])->name('subscription-purchase');
        $businessVerified->get('makePayment/{businessId}/{businessStripeId}', [BusinessLoginController::class, 'makePayment'])->name('makePayment');
        $businessVerified->post('createPaymentSession',  [BusinessLoginController::class, 'createPaymentSession'])->name('createPaymentSession');
        $businessVerified->get('paymentSuccess/{paymentId}', [BusinessLoginController::class, 'paymentSuccess'])->name('paymentSuccess');
        $businessVerified->get('paymentFailed/{paymentId}', [BusinessLoginController::class, 'paymentFailed'])->name('paymentFailed');

        $businessVerified->middleware(['checkStatus'])->group(function ($businessVerifiedWithSubscription) {
            $businessVerifiedWithSubscription->post('topup-orders', [BusinessDashboardController::class, 'topup_orders'])->name('topup-orders');
            $businessVerifiedWithSubscription->post('getMonthlyData', [BusinessDashboardController::class, 'getMonthlyData'])->name('getMonthlyData');
            $businessVerifiedWithSubscription->get('getWeeklyData', [BusinessDashboardController::class, 'getWeeklyData'])->name('getWeeklyData');
            $businessVerifiedWithSubscription->get('makepaymentTopup/{businessId}/{businessStripeId}', [BusinessDashboardController::class, 'makepaymentTopup'])->name('makepaymentTopup');

            $businessVerifiedWithSubscription->get('paymentSuccessTopup/{paymentId}', [BusinessDashboardController::class, 'paymentSuccessTopup'])->name('paymentSuccessTopup');
            $businessVerifiedWithSubscription->get('paymentFailedTopup/{paymentId}}', [BusinessDashboardController::class, 'paymentFailedTopup'])->name('paymentFailedTopup');
            $businessVerifiedWithSubscription->post('create-payment-session-topup', [BusinessDashboardController::class, 'createPaymentSessiontopup'])->name('create-payment-session-topup');
            $businessVerifiedWithSubscription->post('updateStripeKey', [BusinessDashboardController::class, 'stripeKeyUpdate'])->name('updateStripeKey');


            $businessVerifiedWithSubscription->get('/business-dashboard', [BusinessDashboardController::class, 'index'])->name('business-dashboard');
            /*------------------------Business User Profile-------------------------------*/
            $businessVerifiedWithSubscription->get('/business-profile', [BusinessProfileController::class, 'List'])->name('business-profile');
            $businessVerifiedWithSubscription->put('/update-business-profile', [BusinessProfileController::class, 'update'])->name('update-business-profile');

            $businessVerifiedWithSubscription->get('/get-notifications', [BusinessProfileController::class, 'getNotifications'])->name('getNotificationsByBusinessId');
            $businessVerifiedWithSubscription->get('/get-web-notifications', [BusinessProfileController::class, 'getWebNotifications'])->name('getWebNotifications');
            
            $businessVerifiedWithSubscription->post('/mark-as-read-notification-by-id', [BusinessProfileController::class, 'markAsReadNotificationById'])->name('markAsReadNotificationById');
            $businessVerifiedWithSubscription->post('/clear-notification-by-id', [BusinessProfileController::class, 'markAsReadNotificationById'])->name('clearNotificationById');

            /*----------------------Business User Team Member Module---------------------------------------*/
            $businessVerifiedWithSubscription->resource('/business-user', 'BusinessUserBusinessController');

            /*----------------------Business User Business About Us Module---------------------------------------*/
            $businessVerifiedWithSubscription->resource('/business-user-about-us', 'BusinessUserAboutUsController');

            /*---------------------Business User Service Module-----------------------------------------*/
            $businessVerifiedWithSubscription->resource('/business-user-business-services', 'BusinessUserServiceController');

            /*---------------------Business User Sub Service Module-----------------------------------------*/
            $businessVerifiedWithSubscription->resource('/business-owner-subservices', 'BusinessUserSubServicesController');

            $businessVerifiedWithSubscription->get('/team-member-price', 'BusinessUserSubServicesController@getTeamMembersPrice')->name('team-member-price');

            /*---------------------Business User Team Member Module----------------------------------*/
            $businessVerifiedWithSubscription->resource('/business-team-members', 'BusinessUserBusinessTeamMemberController');

            $businessVerifiedWithSubscription->get('/team-member-check-email', [BusinessTeamMemberController::class, 'teamMemberCheckEmail'])->name('team-member-check-email');
            $businessVerifiedWithSubscription->get('/team-member-check-mobile', [BusinessTeamMemberController::class, 'teamMemberCheckMobile'])->name('team-member-check-mobile');

            $businessVerifiedWithSubscription->get('/team-member-time-slot/{id}', [BusinessTeamMemberTimeSlotController::class, 'index'])->name('time-slot');
            $businessVerifiedWithSubscription->post('/add-time-slot', [BusinessTeamMemberTimeSlotController::class, 'store'])->name('add-time-slot');
            $businessVerifiedWithSubscription->get('/show-time-slot', [BusinessTeamMemberTimeSlotController::class, 'getTimeSlotDetails'])->name('show-time-slot');

            /*----------------------Sub Services Module---------------------------------------*/
            $businessVerifiedWithSubscription->resource('/sub-services', 'SubServicesController');

            /*---------------------------Business User Offer Module------------------------------------------ */
            $businessVerifiedWithSubscription->resource('/business-user-offers', 'BusinessUserBusinessOfferController');
            $businessVerifiedWithSubscription->get('/get-coupon-code-business-user', [BusinessUserBusinessOfferController::class, 'getCouponCode'])->name('business-user-coupon-code');
            $businessVerifiedWithSubscription->post('/update-offer-status', [BusinessUserBusinessOfferController::class, 'updateOfferToggle'])->name('businessUserofferStatus');

            $businessVerifiedWithSubscription->post('/update-business-user-service-status', [BusinessServiceController::class, 'updateBusinessServiceStatus'])->name('businessUserServiceStatus');

            $businessVerifiedWithSubscription->post('/update-business-user-team-member-status', [BusinessTeamMemberController::class, 'updateBusinessTeamMemberStatus'])->name('businessUserTeamMemberStatus');
            $businessVerifiedWithSubscription->resource('/business-time-slots', 'BusinessTimeSlotsController');
            $businessVerifiedWithSubscription->get('/checkedTimeTeamMemberSlots', [BusinessTimeSlotsController::class, 'checkedTeamMemberTime'])->name('checkedTimeTeamMemberSlots');

            /*---------------------Business Appointment List----------------------------------*/
            $businessVerifiedWithSubscription->get('/appointments', [AppointmentsController::class, 'index'])->name('appointments');
            $businessVerifiedWithSubscription->get('/appointments-table', [AppointmentsController::class, 'index1'])->name('appointments-table');
            $businessVerifiedWithSubscription->post('/get-business-appointments', [AppointmentsController::class, 'getBusinessAppointment'])->name('list-appointments');
            $businessVerifiedWithSubscription->any('/get-business-appointments-bydate', [AppointmentsController::class, 'getAppointmentsByDate'])->name('list-appointments-bydate');
            $businessVerifiedWithSubscription->post('/change-appointment-status', [AppointmentsController::class, 'changeAppointmentStatus'])->name('appointment-status-change');
            $businessVerifiedWithSubscription->get('/appointment-details/{id}', [AppointmentsController::class, 'getAppointmentDetails'])->name('appointment-details');
            $businessVerifiedWithSubscription->post('/update-appointment-status', [AppointmentsController::class, 'updateAppointmentStatus'])->name('update-appointment-status');


            /*---------------------Business Notification List----------------------------------*/
            $businessVerifiedWithSubscription->get('business-notification', [BusinessNotificationController::class, 'list'])->name('business-notification');

            /*---------------------App Users List----------------------------------*/
            $businessVerifiedWithSubscription->get('app-users', [AppUsersController::class, 'index'])->name('app-users');
            $businessVerifiedWithSubscription->get('app-users-show/{id}', [AppUsersController::class, 'show'])->name('app-users-show');

            /*------------------Subscription-------------------*/
            $businessVerifiedWithSubscription->get('subscription-details', [BusinessSubscriptionController::class, 'index'])->name('subscription-details');


            $businessVerifiedWithSubscription->get('week-settings', [BusinessSettingsController::class, 'index'])->name('week-settings');
            $businessVerifiedWithSubscription->post('/add-weekly-schedule', [BusinessSettingsController::class, 'store'])->name('add-weekly-schedule');

            $businessVerifiedWithSubscription->get('video-details', [BusinessVideoController::class, 'index'])->name('video-details');
            $businessVerifiedWithSubscription->get('/details-video/{id}', [BusinessVideoController::class, 'viewDetails'])->name('details-video');

            
        });
    });
});

Route::middleware(['auth:admin', 'verified'])->group(function ($route) {
    $route->group(['namespace' => 'App\Http\Controllers\admin'], function ($backendVerified) {
        $backendVerified->get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
        /*------------------------Update Admin Profile-------------------------------*/
        $backendVerified->get('/admin-profile', [ProfileController::class, 'List'])->name('admin-profile');
        $backendVerified->put('/update-admin-profile', [ProfileController::class, 'update'])->name('update-admin-profile');

        $backendVerified->get('/site-settings', [SiteSettingController::class, 'index'])->name('site-settings');
        $backendVerified->put('/update-site-settings', [SiteSettingController::class, 'update'])->name('update-site-settings');

        /*-----------------------Admin module-----------------------------------------*/
        $backendVerified->post('/admin-email-check', [AdminController::class, 'checkEmail'])->name('admin-email-check');
        $backendVerified->post('/admin-password-check', [AdminController::class, 'checkPassword'])->name('admin-password-check');

        /*----------------------Services Module---------------------------------------*/
        $backendVerified->resource('/services', 'ServicesController');

        /*----------------------Sub Services Module---------------------------------------*/
        // $backendVerified->resource('/sub-services', 'SubServicesController');

        /*----------------------Team Members Module---------------------------------------*/
        $backendVerified->resource('/team-members', 'TeamMembersController');

        /*----------------------Business Module---------------------------------------*/
        $backendVerified->resource('/business-admin', 'BusinessController');

        /*----------------------App User Module---------------------------------------*/
        $backendVerified->resource('/users', 'UsersController');

        /*----------------------Business Owners Module---------------------------------------*/
        $backendVerified->resource('/business-owners', 'BusinessUsersController');
        $backendVerified->get('/check-email', [BusinessUsersController::class, 'checkBusinessOwnerEmail'])->name('checkEmail');
        $backendVerified->get('/check-email-and-id', [BusinessUsersController::class, 'checkBusinessOwnerEmailWithId'])->name('checkEmailWithId');

        /*-----------------------Reset Password Ajax--------------------------------------*/
        $backendVerified->post('/business-owner-reset-pwd', [BusinessUsersController::class, 'resetPassword'])->name('businessOwnerPwdReset');



        /*---------------------All Module Status Update-----------------------*/
        $backendVerified->post('/update-user-status', [UsersController::class, 'updateUserToggle'])->name('userStatus');
        $backendVerified->post('/update-business-user-status', [BusinessUsersController::class, 'updateUserToggle'])->name('businessUserStatus');
        $backendVerified->post('/update-admin-status', [AdminController::class, 'updateAdminStatus'])->name('adminStatus');
        $backendVerified->post('/update-service-status', [ServicesController::class, 'updateServiceStatus'])->name('serviceStatus');
        $backendVerified->post('/update-team-member-status', [TeamMembersController::class, 'updateTeamMemberStatus'])->name('teamMemberStatus');
        $backendVerified->post('/update-business-status', [BusinessController::class, 'updateBusinessStatus'])->name('businessStatus');
        $backendVerified->post('/update-business-service-status', [BusinessServiceController::class, 'updateBusinessServiceStatus'])->name('businessServiceStatus');
        $backendVerified->post('/update-business-team-member-status', [BusinessTeamMemberController::class, 'updateBusinessTeamMemberStatus'])->name('businessTeamMemberStatus');
        $backendVerified->post('/update-cms-status', [CmsController::class, 'updateCmsStatus'])->name('CmsStatus');
        $backendVerified->post('/update-has-status', [HelpAndSupportController::class, 'updateHasStatus'])->name('hasStatus');
        $backendVerified->post('/update-sub-services-status', [SubServicesController::class, 'updateSubServiceStatus'])->name('subServicesStatus');

        /*----------------------Business About Us Module---------------------------------------*/
        $backendVerified->resource('/business-about-us', 'BusinessAboutUsController');

        /*---------------------Business Service Module-----------------------------------------*/
        $backendVerified->get('/business/service/{id}', [BusinessServiceController::class, 'BusinessServiceIndex'])->name('business-service-index');
        $backendVerified->get('/business/service/create/{id}', [BusinessServiceController::class, 'BusinessServiceCreate'])->name('business-service-create');
        $backendVerified->post('/business/service/store/{id}', [BusinessServiceController::class, 'BusinessServiceStore'])->name('business-service-store');
        $backendVerified->get('/business/service/edit/{id}', [BusinessServiceController::class, 'BusinessServiceEdit'])->name('business-service-edit');
        $backendVerified->put('/business/service/update/{id}', [BusinessServiceController::class, 'BusinessServiceUpdate'])->name('business-service-update');
        $backendVerified->delete('/business/service/delete/{id}', [BusinessServiceController::class, 'BusinessServiceDelete'])->name('business-service-delete');

        /*---------------------Business Team Member Module----------------------------------*/
        $backendVerified->get('/business/team-member/{id}', [BusinessTeamMemberController::class, 'BusinessTeamMembersIndex'])->name('business-team-member-index');
        $backendVerified->post('/business/team-member/store', [BusinessTeamMemberController::class, 'BusinessTeamMembersStore'])->name('business-team-member-store');
        $backendVerified->delete('/business/team-member/delete/{id}', [BusinessTeamMemberController::class, 'BusinessTeamMemberDelete'])->name('business-team-member-delete');
        $backendVerified->put('/business/team-member/update/', [BusinessTeamMemberController::class, 'BusinessTeamMemberUpdate'])->name('business-team-member-update');
        $backendVerified->post('/business/team-member/timeSlots', [BusinessTeamMemberController::class, 'insertTime'])->name('business-time-slots-store');

        $backendVerified->get('/checkedTimeSlots', [BusinessTeamMemberController::class, 'checkedTime'])->name('checkedTimeSlots');


        /*-----------------------Reset Password Ajax--------------------------------------*/
        $backendVerified->post('/reset-password', [UsersController::class, 'resetPassword'])->name('reset-password');

        /*-----------------------Get User Address Ajax--------------------------------------*/
        $backendVerified->get('/get-user-address/{id}', [UsersController::class, 'getUserAddressById'])->name('get-user-address');

        /*---------------------------Admin Module------------------------------------------ */
        $backendVerified->get('/admin', [AdminController::class, 'index'])->name('admin-index');
        $backendVerified->get('/admin-create', [AdminController::class, 'create'])->name('admin-create');
        $backendVerified->post('/admin-store', [AdminController::class, 'store'])->name('admin-store');
        $backendVerified->get('/admin-edit/{id}', [AdminController::class, 'edit'])->name('admin-edit');
        $backendVerified->put('/admin-update/{id}', [AdminController::class, 'update'])->name('admin-update');
        $backendVerified->delete('/admin-delete/{id}', [AdminController::class, 'destroy'])->name('admin-delete');

        /*---------------------------CMS Module------------------------------------------ */
        $backendVerified->resource('/cms', 'CmsController');

        /*---------------------------Business FAQ Module------------------------------------------ */
        $backendVerified->resource('/faq', 'FaqController');

        /*---------------------------E-Food FAQ Module------------------------------------------ */
        $backendVerified->resource('/efood-faq', 'EFoodFaqController');

        /*---------------------Update FAQ Status Update-----------------------*/
        $backendVerified->post('/update-faq-staus', [FaqController::class, 'updateFAQToggle'])->name('update-faq-status');

        /*---------------------------Help & Support Module------------------------------------------ */
        $backendVerified->get('/help-and-support', [HelpAndSupportController::class, 'index'])->name('help-and-support');

        /*---------------------------Business Offer Module------------------------------------------ */
        $backendVerified->get('/business/offer/{id}', [BusinessOfferController::class, 'index'])->name('business-offer-index');
        $backendVerified->get('/business/offer/create/{id}', [BusinessOfferController::class, 'create'])->name('business-offer-create');
        $backendVerified->post('/business/offer/store', [BusinessOfferController::class, 'store'])->name('business-offer-store');
        $backendVerified->get('/business/offer/edit/{id}', [BusinessOfferController::class, 'edit'])->name('business-offer-edit');
        $backendVerified->put('/business/offer/update/{id}', [BusinessOfferController::class, 'update'])->name('business-offer-update');
        $backendVerified->delete('/business/offer/delete/{id}', [BusinessOfferController::class, 'destroy'])->name('business-offer-delete');
        $backendVerified->get('/get-coupon-code', [BusinessOfferController::class, 'getCouponCode'])->name('coupon-code');

        /*---------------------Business Appointment List----------------------------------*/
        $backendVerified->get('/business-appointment', [BusinessAppointmentController::class, 'index'])->name('business-appointment');
        $backendVerified->get('/canceleappointmentlist', [BusinessAppointmentController::class, 'canceleAppointmentList'])->name('canceleappointmentlist');

        $backendVerified->get('/ordermanagement', [OrderManagementController::class, 'index'])->name('ordermanagement');
        $backendVerified->get('/order-details/{id}', [OrderManagementController::class, 'show'])->name('order-details');

        /*---------------------User Status Update-----------------------*/
        $backendVerified->post('/update-status', [BusinessOfferController::class, 'updateOfferToggle'])->name('offerStatus');

        /*---------------------Subscription master-----------------------*/
        $backendVerified->get('/admin-subcription-index/{id}', [AdminSubscriptionController::class, 'index'])->name('admin-subscription-index');
        $backendVerified->resource('/admin-subcription', 'AdminSubscriptionController');
        $backendVerified->get('/admin-subcription/create/{type}', [AdminSubscriptionController::class, 'create'])->name('admin-subscription-create');
        $backendVerified->get('/admin-subcription/edit/{id}/{type}', [AdminSubscriptionController::class, 'edit']);

        /*---------------------Video Master-----------------------*/
        $backendVerified->get('/admin-video-index/{id}', [AdminVideoController::class, 'index'])->name('admin-video-index');
        $backendVerified->resource('/admin-video', 'AdminVideoController');
        $backendVerified->get('/admin-video/create/{type}', [AdminVideoController::class, 'create'])->name('admin-video-create');
        $backendVerified->get('/admin-video/edit/{id}/{type}', [AdminVideoController::class, 'edit']);


        /*---------------------------Admin Business Owners-------------------------*/
        $backendVerified->resource('/admin-business-owners', 'BusinessOwnerController');

        /*---------------------------Cuisine master-------------------------*/
        $backendVerified->resource('/cuisine', 'EFoodCuisineController');

        /*---------------------------Admin Notifications---------------------*/
        $backendVerified->get('admin-notification', [AdminNotificationController::class, 'list'])->name('admin-notification');

        /*----------------------EFood----------------------------*/
        $backendVerified->resource('/food-users', 'EFoodUsersController');
        $backendVerified->resource('/food-owners', 'EFoodOwnersController');
        $backendVerified->resource('/food-category', 'EFoodCategoryController');
        $backendVerified->resource('/food-sub-category', '  ');
        $backendVerified->resource('/food-type', 'EFoodTypeController');

        /*-----------------------Payment Report-------------------------*/
        $backendVerified->get('/get-bookit-report', [AdminReportController::class, 'businessList'])->name('get-bookit-report');
        $backendVerified->get('/get-efood-report', [AdminReportController::class, 'foodList'])->name('get-efood-report');
        $backendVerified->post('/mark-as-read-notification-adminbyid', [AdminNotificationController::class, 'markAsAdminReadNotificationById'])->name('markAsAdminReadNotificationById');
    });
});

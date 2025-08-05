<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\SchoolController;
use App\Http\Controllers\ContentController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Auth::routes();
// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/', [HomeController::class, 'index'])->name('home');

// Login
Route::get('login', 'Auth\LoginController@showUserLoginForm')->name('login');
Route::get('logout', 'Auth\LoginController@logout')->name('logout');

// Register customer
Route::get('sign-up', 'Auth\RegisterController@register')->name('user.register');
Route::post('sign-up-save', 'Auth\RegisterController@registerSave')->name('user.register.save');

Route::post('user-email-check', 'Auth\RegisterController@userEmailCheck')->name('user.email.check');
Route::post('user-mobile-check', 'Auth\RegisterController@userMobileCheck')->name('user.mobile.check');
Route::get('user-verify-email/{vcode?}/{id?}', 'Auth\RegisterController@verifyEmail')->name('verify.user.email');

// Passwords
Route::get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('user.password.request');
Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('user.password.email');
Route::get('password/reset/{token?}', 'Auth\ResetPasswordController@showResetForm')->name('user.password.reset');
Route::post('password/reset', 'Auth\ResetPasswordController@reset')->name('user.password.update');

//Message Page
Route::get('success', 'Auth\RegisterController@success')->name('user.success.msg');
Route::get('error', 'Auth\RegisterController@error')->name('user.error.msg');

//------SOCIAL LOGIN ROUTE-------------//

Route::get('login/google', 'Auth\LoginController@redirectToProvider')->name('login.social');
Route::get('login/google/callback', 'Auth\LoginController@handleProviderCallback')->name('login.social.callback');
Route::post('social_login', 'Auth\LoginController@socialRegistation')->name('login.social.register');


Route::group(['namespace' => 'Modules'], function() {

    //for static page
    Route::get('about-us','Content\ContentController@aboutUs')->name('about.us');
    Route::get('about-us', [ContentController::class, 'aboutUs'])->name('about.us');
    Route::get('contact-us','Content\ContentController@contactUs')->name('contact.us');
    Route::get('contact-us',[ContentController::class, 'contactUs'])->name('contact.us');
    Route::post('contact-us-save','Content\ContentController@contactUsSave')->name('contact.us.save');
    Route::get('faq',[ContentController::class, 'faq'])->name('faq');
    Route::get('privacy-policy',[ContentController::class, 'privacyPolicy'])->name('privacy.policy');
    //Route::get('terms-conditions','Content\ContentController@termCondition')->name('term.condition');
    Route::get('disclaimer',[ContentController::class, 'disclaimer'])->name('disclaimer');
    Route::any('news','Content\ContentController@newsList')->name('news.list');
    Route::get('news-details/{slug?}','Content\ContentController@newsDetails')->name('news.details');

     //School Listing
     Route::get('add-school-step1/{id?}',[SchoolController::class, 'addSchoolStep1'])->name('add.school.step1');
     Route::post('add-school-step1-save',[SchoolController::class, 'addSchoolStep1Save'])->name('add.school.step1.save');

     Route::get('add-school-step2/{id?}',[SchoolController::class, 'addSchoolStep2'])->name('add.school.step2');
     Route::post('add-school-step2-save',[SchoolController::class, 'addSchoolStep2Save'])->name('add.school.step2.save');
     
     Route::get('add-school-step3/{id?}',[SchoolController::class, 'addSchoolStep3'])->name('add.school.step3');
     Route::post('add-school-step3-save',[SchoolController::class, 'addSchoolStep3Save'])->name('add.school.step3.save');
     Route::post('add-school-step3-uniform-save',[SchoolController::class, 'addSchoolStep3UniformSave'])->name('add.school.step3.uniform.save');
     Route::get('school-uniform-delete/{id?}',[SchoolController::class, 'schoolUniformDelete'])->name('school.uniform.delete');

     Route::get('add-school-step4/{id?}',[SchoolController::class, 'addSchoolStep4'])->name('add.school.step4');
     Route::post('add-school-step4-rules-save',[SchoolController::class, 'addSchoolStep4RulesSave'])->name('add.school.step4.rules.save');
     Route::post('add-school-step4-ratio-save',[SchoolController::class, 'addSchoolStep4RatioSave'])->name('add.school.step4.ratio.save');

     Route::get('add-school-step5/{id?}',[SchoolController::class, 'addSchoolStep5'])->name('add.school.step5');
     Route::post('add-school-step5-save',[SchoolController::class, 'addSchoolStep5Save'])->name('add.school.step5.save');

     Route::get('add-school-step6/{id?}/{sub_id?}',[SchoolController::class, 'addSchoolStep6'])->name('add.school.step6');
     Route::post('add-school-step6-subject-save',[SchoolController::class, 'addSchoolStep6SubjectSave'])->name('add.school.step6.subject.save');
     Route::get('school-brach-image-delete/{id?}',[SchoolController::class, 'schoolBranchImageDelete'])->name('school.branch.image.delete');
     Route::get('school-subject-delete/{id?}',[SchoolController::class, 'schoolSubjectDelete'])->name('school.subject.delete');

     Route::get('add-school-step7/{id?}/{result_id?}',[SchoolController::class, 'addSchoolStep7'])->name('add.school.step7');
     Route::post('add-school-step7-save',[SchoolController::class, 'addSchoolStep7Save'])->name('add.school.step7.save');
     Route::get('school-image-delete/{id?}',[SchoolController::class, 'schoolImageDelete'])->name('school.image.delete');

     Route::get('add-school-step8/{id?}/{branch_id?}',[SchoolController::class, 'addSchoolStep8'])->name('add.school.step8');
     Route::post('add-school-step8-save',[SchoolController::class, 'addSchoolStep8Save'])->name('add.school.step8.save');

     Route::get('add-school-step9/{id?}/{status?}',[SchoolController::class, 'addSchoolStep9'])->name('add.school.step9');
     Route::post('add-school-step9-fees-save',[SchoolController::class, 'addSchoolStep9FeesSave'])->name('add.school.step9.fees.save');
     Route::get('school-fees-delete/{id?}',[SchoolController::class, 'schoolFeesDelete'])->name('school.fees.delete');
     
     Route::post('get-class-level','School\SchoolController@getClassLevel')->name('get.class.level');
     Route::post('get-city','School\SchoolController@getCity')->name('get.city');
     Route::get('delete-contact/{id?}','School\SchoolController@deleteContact')->name('delete.contact');
    

     //for search school
     Route::any('search-school/{school_type?}',[SchoolController::class, 'schoolSearch'])->name('school.search');
     Route::any('search-school-map-view','School\SearchSchoolController@schoolSearchMap')->name('school.search.map');
     Route::get('school-details/{slug?}','School\SearchSchoolController@schoolDetails')->name('school.details');
     Route::post('post-review','School\SearchSchoolController@postReview')->name('post.review');
     Route::post('school-claim-save','School\SearchSchoolController@shoolClaimSave')->name('school.claim.save');
     Route::post('upload-photo-save','School\SearchSchoolController@uploadPhotoSave')->name('school.photo.save');
     Route::post('send-message-save','School\SearchSchoolController@sendMessage')->name('user.send.message');
     Route::post('add-favourite','School\SearchSchoolController@addFavourite')->name('user.add.favourite');
     Route::post('header-image-video-save','School\SearchSchoolController@addHeaderImageVideo')->name('user.add.header.image.video');
     

    Route::group(['namespace' => 'User','middleware' => 'auth'], function(){

        Route::get('dashboard', 'Dashboard\DashboardController@dashboard')->name('user.dashboard');
        Route::get('edit-profile', 'Profile\ProfileController@profile')->name('user.profile');
        Route::get('profile-image-delete', 'Profile\ProfileController@profileImageDelete')->name('user.profile.image.delete');
        Route::post('update-profile', 'Profile\ProfileController@update')->name('user.update.profile');
        Route::post('email-check', 'Profile\ProfileController@userEmailCheck')->name('email.check');
        Route::post('mobile-check', 'Profile\ProfileController@userMobileCheck')->name('mobile.check');
        Route::post('user-update-email', 'Profile\ProfileController@updateEmail')->name('user.update.email');
        Route::post('password-check', 'Profile\ProfileController@passwordCheck')->name('password.check');
        Route::get('user-email-update/{vcode?}/{id?}', 'Profile\ProfileController@verifyEmail')->name('user.email.update');

        //for my school
        Route::get('my-school', 'School\SchoolController@mySchool')->name('user.my.school');
        Route::get('edit-school-info/{id?}/{sub_id?}', 'School\SchoolController@editSchool')->name('user.edit.school');
        Route::post('update-school-info', 'School\SchoolController@schoolInfoUpdate')->name('user.school.info.update');
        Route::post('update-school-image', 'School\SchoolController@updateImage')->name('user.update.school.image');
        Route::get('school-image-status-update/{id?}', 'School\SchoolController@schoolImageStatusUpdate')->name('user.school.image.status.update');
        Route::post('update-school-facilities', 'School\SchoolController@updateFacility')->name('user.update.school.facility');
        Route::post('update-school-ratio', 'School\SchoolController@updateSchoolRatio')->name('user.update.school.ratio');
        Route::post('update-school-uniform', 'School\SchoolController@updateSchoolUniform')->name('user.update.school.uniform');
        Route::get('delete-school-uniform/{id?}', 'School\SchoolController@deleteSchoolUniform')->name('user.school.uniform.delete');
        Route::post('update-school-rules', 'School\SchoolController@updateSchoolRules')->name('user.update.school.rules');
        Route::post('update-school-subject', 'School\SchoolController@updateSchoolSubject')->name('user.update.school.subject');
        Route::get('user-delete-school-subject/{id?}', 'School\SchoolController@schoolSubjectDelete')->name('user.school.subject.delete');

        Route::get('edit-school-result/{id?}/{result_id?}', 'School\SchoolController@editSchoolResult')->name('user.edit.school.result');
        Route::post('update-school-result', 'School\SchoolController@updateSchoolResult')->name('user.update.school.result');

        Route::get('my-favourite', 'School\SchoolController@myFavourite')->name('user.my.favourite');
        Route::get('delete-favourite/{id?}', 'School\SchoolController@deleteFavourite')->name('user.favourite.delete');

        Route::get('create-news/{school_id?}/{news_id?}', 'School\SchoolController@createNews')->name('user.create.news');
        Route::post('create-news-save', 'School\SchoolController@createNewsSave')->name('user.create.news.save');
        Route::get('delete-news/{id?}', 'School\SchoolController@deleteNews')->name('user.news.delete');
        Route::get('add-news', 'School\SchoolController@addNews')->name('user.add.news');

        //for my reviews
        Route::get('my-reviews-for-by-me', 'Review\ReviewController@myReviewsByMe')->name('user.my.review.by.me');
        Route::get('my-reviews-for-by-school', 'Review\ReviewController@myReviewsBySchool')->name('user.my.review.by.school');
        Route::post('review-reply', 'Review\ReviewController@reviewReply')->name('user.review.reply');
        Route::get('featured-review/{id?}', 'Review\ReviewController@featuredReview')->name('user.featured.review');

        //messages
        Route::get('messages', 'Message\MessageController@messageList')->name('user.message.list');
        Route::get('message-details/{message_id?}', 'Message\MessageController@messageDetail')->name('user.message.detail');
        Route::post('send-message-reply','Message\MessageController@sendMessage')->name('user.send.message.reply');

        //for subscription
        Route::get('subscription', 'Subscription\SubscriptionController@subscription')->name('user.subscription');
        Route::post('purchase-subscription', 'Subscription\SubscriptionController@purchaseSubscription')->name('user.purchase.subscription');
        Route::any('payment-success','Subscription\SubscriptionController@payment_success')->name('payment.success');
        Route::any('payment-failed','Subscription\SubscriptionController@payment_failed')->name('payment.failed');
        Route::get('subscription-history', 'Subscription\SubscriptionController@subscriptionHistory')->name('user.subscription.history');

    });

    
        //payment related
        Route::get('checkout','Payment\PaymentController@checkout')->name('payment.checkout');
        Route::post('payment','Payment\PaymentController@payment')->name('payment.payment');
        Route::any('notification-url','User\Subscription\SubscriptionController@notification')->name('payment.notification');

});

//Clear configurations:
Route::get('/config-clear', function() {
    $status = Artisan::call('config:clear');
    return '<h1>Configurations cleared</h1>';
});

//Clear cache:
Route::get('/cache-clear', function() {
    $status = Artisan::call('cache:clear');
    return '<h1>Cache cleared</h1>';
});

//Clear configuration cache:
Route::get('/config-cache', function() {
    $status = Artisan::call('config:cache');
    return '<h1>Configurations cache cleared</h1>';
});

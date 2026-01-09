<?php

use App\Http\Controllers\Backend\Agreement\AgreementController;
use App\Http\Controllers\Backend\Agreement\AgreementSignatureController;
use App\Http\Controllers\Backend\AttributeController;
use App\Http\Controllers\Backend\BarcodeController;
use App\Http\Controllers\Backend\CorporateController;
use App\Http\Controllers\Backend\CorporatePackageController;
use App\Http\Controllers\Backend\CorporateWalletController;
use App\Http\Controllers\Backend\DashboardController;
use App\Http\Controllers\Backend\DoctorController;
use App\Http\Controllers\Backend\DoctorFaqController;
use App\Http\Controllers\Backend\FaqController;
use App\Http\Controllers\Backend\FacilityController;
use App\Http\Controllers\Backend\LabBookingController;
use App\Http\Controllers\Backend\LabController;
use App\Http\Controllers\Backend\LabGalleryController;
use App\Http\Controllers\Backend\LabReportController;
use App\Http\Controllers\Backend\LabSliderController;
use App\Http\Controllers\Backend\ModulePermissionController;
use App\Http\Controllers\Backend\NotificationController;
use App\Http\Controllers\Backend\NotificationMessageController;
use App\Http\Controllers\Backend\OrderController;
use App\Http\Controllers\Backend\PackageCategoryController;
use App\Http\Controllers\Backend\PackageController;
use App\Http\Controllers\Backend\TestController;
use App\Http\Controllers\Backend\ProductCategoryController;
use App\Http\Controllers\Backend\ProductController;
use App\Http\Controllers\Backend\ProductReviewController;
use App\Http\Controllers\Backend\ProductSubCategoryController;
use App\Http\Controllers\Backend\ProductTypeController;
use App\Http\Controllers\Backend\ReferingLabController;
use App\Http\Controllers\Backend\SampleCollectionController;
use App\Http\Controllers\Backend\SchedulingController;
use App\Http\Controllers\Backend\SpecialityController;
use App\Http\Controllers\Backend\TrackSampleController;
use App\Http\Controllers\Backend\UserController;
use App\Http\Controllers\Backend\PolicyController;
use App\Http\Controllers\Backend\VendorController;
use App\Http\Controllers\Backend\WebAboutController;
use App\Http\Controllers\Backend\WebTeamController;
use App\Http\Controllers\Frontend\AbdmController;
use App\Http\Controllers\Frontend\BannerController;
use App\Http\Controllers\Frontend\BlogController;
use App\Http\Controllers\Frontend\BookingController;
use App\Http\Controllers\Frontend\BrandController;
use App\Http\Controllers\Frontend\CartController;
use App\Http\Controllers\Frontend\CheckoutController;
use App\Http\Controllers\Frontend\CorporateAboutController;
use App\Http\Controllers\Frontend\CorporateBannerController;
use App\Http\Controllers\Frontend\CorporateController as FrontendCorporateController;
use App\Http\Controllers\Frontend\CorporateDoctorConsultController;
use App\Http\Controllers\Frontend\CorporateHospitalAssistanceController;
use App\Http\Controllers\Frontend\CorporateLabTestController;
use App\Http\Controllers\Frontend\CorporateWellnessProgramController;
use App\Http\Controllers\Frontend\DashboardController as FrontendDashboardController;
use App\Http\Controllers\Frontend\DoctorController as FrontendDoctorController;
use App\Http\Controllers\Frontend\VendorController as FrontendVendorController;
use App\Http\Controllers\Frontend\FeatureController;
use App\Http\Controllers\Frontend\HomeController;
use App\Http\Controllers\Frontend\LabController as FrontendLabController;
use App\Http\Controllers\Frontend\OfferController;
use App\Http\Controllers\Frontend\OrderController as FrontendOrderController;
use App\Http\Controllers\Frontend\PackageController as FrontendPackageController;
use App\Http\Controllers\Frontend\PaymentMethodController;
use App\Http\Controllers\Frontend\ProductCartController;
use App\Http\Controllers\Frontend\ProductController as FrontendProductController;
use App\Http\Controllers\Frontend\TestimonialController;
use App\Http\Controllers\Frontend\UserController as FrontendUserController;
use App\Http\Controllers\Frontend\VideoContoller;
use App\Http\Controllers\Frontend\WishlistController;
use App\Http\Controllers\Frontend\ContactController;
use App\Http\Controllers\LocationController;
use App\Http\Controllers\Payment\PaymentController;
use App\Http\Controllers\SendOtpController;
use Illuminate\Support\Facades\Route;
use App\Services\GoogleCalendarService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Helpers\AbdmHelper;
use App\Http\Controllers\Backend\CouponController;
use App\Http\Controllers\Frontend\CouponController as FrontendCouponController;
use App\Http\Controllers\Backend\RequisiteController;

Route::get('/abdm/test-token', function () {
    try {
        $token = AbdmHelper::getAccessToken();
        return response()->json(['access_token' => $token]);
    } catch (\Exception $e) {
        return response()->json(['error' => $e->getMessage()], 500);
    }
});
Route::get('/abdm/register-hip', [AbdmController::class, 'registerHip'])->name('abdm.registerHip');
Route::get('/abdm/get-services', [AbdmController::class, 'getServices']);
Route::get('/abdm/update-bridge-url', [AbdmController::class, 'updateBridgeUrl']);
Route::get('/abdm/add-service', [AbdmController::class, 'addService']);

Route::get('/oauth2/authorize', function (GoogleCalendarService $svc) {
    return redirect($svc->getAuthUrl());
})->name('google.authorize');

Route::get('/oauth2/callback', function (Request $request, GoogleCalendarService $svc) {
    if ($request->has('code')) {
        $svc->saveAuthCode($request->get('code'));
        return "Google Calendar authorized successfully! ✅";
    }
    return "Authorization failed ❌";
})->name('google.callback');

Route::get('/simulate-location', function () {
    $lat = 26.9716 + rand(-100, 100) / 10000;
    $lng = 80.5946 + rand(-100, 100) / 10000;
    event(new \App\Events\LocationUpdated(79, $lat, $lng));
    return "Simulated location sent: $lat,$lng";
});

Route::get('/dashboard', [DashboardController::class, 'index'])->middleware(['auth', 'verified'])->name('dashboard');

// Route::middleware('auth')->group(function () {
//     Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
//     Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
//     Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
// });

// Frontend Routes
Route::get('/', [HomeController::class, 'home'])->name('index');
Route::get('/shop', [FrontendProductController::class, 'shop'])->name('shop');
Route::get('/checkup', [HomeController::class, 'checkup'])->name('checkup');

Route::get('/backend/module/index', [ModulePermissionController::class, 'index'])->name('module.index');
Route::post('/backend/module/store', [ModulePermissionController::class, 'store'])->name('backend.roles.modules.store');

Route::get('/lab-test/{slug}', [HomeController::class, 'testDetails'])->name('test.details');
Route::get('/lab-test', [FrontendPackageController::class, 'labTest'])->name('lab.test');

Route::get('/contact', [HomeController::class, 'contact'])->name('contact');
Route::get('/about', [HomeController::class, 'about'])->name('about');

Route::get('/login', [HomeController::class, 'login'])->name('login');
Route::get('/register', [HomeController::class, 'register'])->name('register');
Route::get('/forgot', [HomeController::class, 'forgot'])->name('forgot');
Route::get('/faq', [HomeController::class, 'faq'])->name('faq');

// Front Blog
Route::get('/blog', [HomeController::class, 'blog'])->name('blog');
Route::get('/blog/{slug}', [HomeController::class, 'blogDetails'])->name('blog.details');
Route::post('/blog/comment/store', [BlogController::class, 'storeComment'])->name('blog.comment.store')->middleware('throttle:5,1');
Route::post('/blog/like', [BlogController::class, 'likeBlog'])->name('blog.like');

// Front Submit Package Review
Route::post('/website/package/review/store', [PackageController::class, 'storePackageReview'])->name('website.package.review.store')->middleware('throttle:5,1');

// Front Submit Product Review
Route::post('/website/product/review/store', [ProductReviewController::class, 'storeProductReview'])->name('website.product.review.store')->middleware('throttle:5,1');

// Front Cart
Route::post('/add-to-cart', [CartController::class, 'addToCart'])->name('cart.add');
Route::get('/lab-cart', [CartController::class, 'viewCart'])->name('cart.view');
Route::post('/cart/remove', [CartController::class, 'removeItem'])->name('cart.remove');
Route::get('/view-cart', [HomeController::class, 'viewcart'])->name('viewcart');
Route::get('/cart/count', [CartController::class, 'getCount'])->name('cart.count');
Route::get('/cart/combined-count', [CartController::class, 'getCombinedCartCount'])->name('cart.combined.count');
Route::post('/cart/update-qty', [CartController::class, 'updateQty'])->name('cart.updateQty');

Route::get('/wishlist/count', [WishlistController::class, 'getCount'])->name('wishlist.count');

Route::prefix('product-cart')->group(function () {
    Route::get('/', [ProductCartController::class, 'viewCart'])->name('product.cart');
    Route::post('/add', [ProductCartController::class, 'addToCart'])->name('product.cart.add');
    Route::get('/count', [ProductCartController::class, 'getCount'])->name('product.cart.count');
    Route::post('/remove', [ProductCartController::class, 'removeFromCart'])->name('product.cart.remove');
    Route::post('/update-quantity', [ProductCartController::class, 'updateQuantity'])->name('product.cart.updateQuantity');
});

Route::get('/cart-total', [CartController::class, 'getCartTotal'])->name('cart.total');
Route::get('/mobile-cart/fetch', [CartController::class, 'fetchMobileCartItems'])->name('mobile.cart.fetch');
Route::post('/mobile/cart/remove', [CartController::class, 'removeMobileCart'])->name('mobile.cart.remove');

Route::get('/coming', [HomeController::class, 'coming'])->name('coming');



Route::post('/booking-patient/store', [CheckoutController::class, 'storePatient'])
    ->name('booking.patient.store');
Route::delete('/booking-patient/delete/{id}', [CheckoutController::class, 'destroy'])
    ->name('booking-patient.destroy');
Route::post('/booking-patient/update/{id}', [CheckoutController::class, 'update'])->name('booking.patient.update');
Route::post('/cart/remove-package', [CheckoutController::class, 'removePackage']);


Route::get('/lab-checkout', [CheckoutController::class, 'checkout'])->name('checkout');
Route::get('/product-checkout', [CheckoutController::class, 'productCheckout'])->name('product.checkout');
Route::post('/calculate-shipping', [CheckoutController::class, 'calculateShipping'])->name('checkout.calculateShipping');
Route::get('/checkout/get-patient-test/{pid}', [CheckoutController::class, 'getPatientTest'])->name('checkout.getPatientTest');

// Coupon route for User
Route::get('/coupons/list', [FrontendCouponController::class, 'list'])->name('coupons.list');
Route::post('/coupon/apply', [FrontendCouponController::class, 'apply'])->name('coupon.apply');
Route::post('/coupon/remove', [FrontendCouponController::class, 'remove'])->name('coupon.remove');



Route::post('/product-checkout/store', [FrontendOrderController::class, 'store'])->name('product.checkout.store');
Route::get('/checkout_complete', [HomeController::class, 'checkoutcomplete'])->name('checkoutcomplete');
Route::post('/order/cancel', [FrontendOrderController::class, 'cancelOrder'])->name('order.cancel');

Route::get('/product/{slug}', [HomeController::class, 'product'])->name('product');
Route::get('/product/{id}/variants', [HomeController::class, 'getVariants'])->name('product.variants');

Route::get('/category/{type?}', [HomeController::class, 'category'])->name('category');
Route::get('/doctor-category', [HomeController::class, 'doctor_category'])->name('doctor_category');
Route::get('/compare', [HomeController::class, 'compare'])->name('compare');

Route::get('/payment', [HomeController::class, 'payment'])->name('payment');

Route::get('/doctor', [FrontendDoctorController::class, 'index'])->name('doctor');
Route::get('/doctor/{id}/details', [FrontendDoctorController::class, 'doctorDetails'])->name('doctor.details');
Route::post('/get-doctor-available-dates', [FrontendDoctorController::class, 'getAvailableDates'])->name('doctor.schedule.dates');
Route::post('/get-doctor-available-slots', [FrontendDoctorController::class, 'getAvailableSlots'])->name('doctor.schedule.slots');
Route::post('/doctor/review/store', [FrontendDoctorController::class, 'doctorReviewStore'])->name('doctor.review.store')->middleware('throttle:5,1');

Route::post('/doctor/checkout', [FrontendDoctorController::class, 'doctorCheckout'])->name('doctor.checkout');
Route::post('/doctor/booking', [FrontendDoctorController::class, 'doctorBooking'])->name('doctor.booking');
Route::post('/doctor/booking/cancel', [FrontendDoctorController::class, 'doctorBookingCancel'])->name('doctor.booking.cancel');
Route::post('/doctor/booking/free', [FrontendDoctorController::class, 'freeDoctorBooking'])->name('doctor.booking.free');
Route::post('/certified/doctor/booking/free', [FrontendDoctorController::class, 'certifiedFreeDoctorBooking'])->name('certified.doctor.booking.free');
Route::get('/lab-profile/{slug}/{id}', [FrontendLabController::class, 'labProfile'])->name('lab-profile');

// Frontend Doctor
Route::controller(FrontendDoctorController::class)->prefix('/')->name('doctor.')->group(function () {
    Route::get('doctor-registration', 'doctorRegistration')->name('registration');
    Route::post('doctor-store-registration', 'storeDoctor')->name('store.registration');
});

// Frontend Corporate
Route::controller(FrontendCorporateController::class)->prefix('/')->name('corporate.')->group(function () {
    Route::get('corporate', 'index')->name('index');
    Route::get('corporate/services', 'corporateServices')->name('services');
    Route::get('corporate/wellness-program/{slug}', 'corporateWellness')->name('wellness.description');
    Route::get('corporate/doctor-consultation', 'corporateDoctorConsult')->name('doctorConsult');
    Route::get('corporate/lab-test', 'corporateLabTest')->name('labTest');
    Route::get('corporate/hospital-assistance', 'corporateHospitalAssistance')->name('hospitalAssistance');
    Route::get('corporate-registration', 'corporateRegistration')->name('registration');
    Route::post('corporate-store-registration', 'storeCorporate')->name('store.registration');
});

// Frontend Vendor
Route::controller(FrontendVendorController::class)->prefix('/')->name('vendor.')->group(function () {
    Route::get('vendor-registration', 'vendorRegistration')->name('registration');
    Route::post('vendor-store-registration', 'storeVendor')->name('store.registration');
});

Route::get('/user_Registration', [HomeController::class, 'userRegistration'])->name('user_Registration');

Route::get('/lab-registration', [FrontendLabController::class, 'registration'])->name('lab.registration');
Route::post('/lab-registration-store', [FrontendLabController::class, 'storeRegistration'])->name('lab.store.registration');

Route::post('/lab-review/store', [FrontendLabController::class, 'labReviewStore'])->name('lab.review.store')->middleware('throttle:5,1');

Route::post('/set-welcome-shown', function () {
    session(['welcome_shown' => true]);
    return response()->json(['status' => 'ok']);
})->name('set.welcome.shown')->middleware('auth');

// Search Location
Route::get('/search-city', [LocationController::class, 'searchCity'])->name('search.city');

// Get Location
Route::post('/get-city', [LocationController::class, 'getCity'])->name('get.city');

// Set Location
Route::post('/set-city', [LocationController::class, 'setCity'])->name('set.city');

// Front End Auth User Routes
Route::middleware(['auth'])->group(function () {
    Route::get('/user/dashboard', [FrontendUserController::class, 'dashboard'])->name('user.dashboard');
    Route::get('/user/profile', [FrontendUserController::class, 'profile'])->name('user.profile');
    Route::post('/user/profile/update', [FrontendUserController::class, 'profileUpdate'])->name('user.profile.update');
    Route::post('/user/primary-address/update', [FrontendUserController::class, 'primaryAddressUpdate'])->name('user.primaryaddress.update');
    Route::post('/user/medical-information/update', [FrontendUserController::class, 'updateMedicalInformation'])->name('user.medicalinformation.update');
    Route::post('/user/change-password', [FrontendUserController::class, 'changePassword'])->name('user.password.change');
    Route::post('/user/profile-image', [FrontendUserController::class, 'uploadProfileImage'])->name('user.profile.image.upload');
    Route::get('/user/abha-card', [AbdmController::class, 'abhaIndex'])->name('abhaindex');
    Route::post('/abha/send-otp', [AbdmController::class, 'sendOtp'])->name('abha.sendOtp');
    Route::post('/abha/verify-otp', [AbdmController::class, 'verifyOtp'])->name('abha.verifyOtp');

    Route::post('/user/address/delete', [FrontendUserController::class, 'deleteAddress'])->name('user.address.delete');

    // User Addresses
    Route::get('/user/address/list', [FrontendUserController::class, 'userAddresses'])->name('user.addresses');
    Route::get('/user/address/show', [FrontendUserController::class, 'userAddressesShow'])->name('user.addresses.show');

    // Fetch Lab
    Route::get('/labs/fetch', [BookingController::class, 'fetchlabs'])->name('labs.fetch');
    Route::post('/get-lab-available-dates', [BookingController::class, 'getAvailableDates'])->name('lab.schedule.dates');
    Route::post('/get-lab-available-slots', [BookingController::class, 'getAvailableSlots'])->name('lab.schedule.slots');

    // Frontend Test Booking
    Route::get('/booking-form', [BookingController::class, 'bookingForm'])->name('booking.form');
    Route::get('/get-tests-by-lab/{lab_id}', [BookingController::class, 'getTestsByLab']);
    Route::get('/get-test-price-by-package/{package_id}', [BookingController::class, 'getTestPriceByPackage']);

    Route::post('/user/addresses', [BookingController::class, 'storeUserAddress'])->name('addresses.store');
    Route::post('/user/addresses/{id}/update', [BookingController::class, 'updateUserAddress'])->name('addresses.update');
    Route::get('/user/addresses', [BookingController::class, 'getUserAddresses'])->name('addresses.fetch');
    Route::get('/get-schedules-by-lab/{labId}/{sampleCollection}', [BookingController::class, 'getSchedulesByLab']);
    Route::get('/get-patient-info/{id}', [BookingController::class, 'getPatientInfo'])->name('patient.info');
    Route::post('/get-tests-prices', [BookingController::class, 'getTestsPrices'])->name('get.tests.prices');
    Route::post('/lab-booking-store', [LabBookingController::class, 'labBookingStore'])->name('lab.booking.store');

    Route::post('/book-store', [BookingController::class, 'bookingStore'])->name('booking.store');
    Route::post('/booking/cancel', [BookingController::class, 'cancelBooking'])->name('booking.cancel');

    // Booking List
    Route::get('/user/booking-list', [FrontendUserController::class, 'booking_list'])->name('booking_list');
    Route::get('/user/booking-details/{id}', [FrontendUserController::class, 'booking_details'])->name('booking_detail');

    //Prescription


    // Order List
    Route::get('/user/order-list', [FrontendUserController::class, 'order_list'])->name('order_list');
    Route::get('/user/order-details/{id}', [FrontendUserController::class, 'order_details'])->name('order_detail');


    Route::get('/user/support', [FrontendUserController::class, 'userSuppport'])->name('user.support');

    // User All reports
    Route::get('/user/all-reports', [FrontendUserController::class, 'allReports'])->name('user.all.report');

    // User All reports
    Route::get('/user/all-consultation', [FrontendUserController::class, 'allConsultations'])->name('user.all.consultation');
    Route::get('/user/consultation/{id}/details', [FrontendUserController::class, 'consultationDetails'])->name('user.consultation.details');
    Route::get('/prescription/{id}/download-text', [FrontendUserController::class, 'downloadTextPrescription'])->name('prescription.download.text');
    Route::get('/user/free-consultations/tests', [FrontendUserController::class, 'freeConsultationTests'])->name('user.free.consultations.tests');
    Route::get('/user/free-consultation/doctors/{test}', [FrontendUserController::class, 'freeConsultationDoctors'])->name('user.free.consultation.doctors');

    Route::get('/user/track-order', [FrontendUserController::class, 'track_order'])->name('track_order');
    Route::get('/track-order/{tracking_id}', [FrontendUserController::class, 'trackOrderView'])->name('track.order.view');
    Route::get('/track-booking-status', [FrontendUserController::class, 'trackBookingStatus'])->name('track.booking.status');
    Route::get('/download-report/{tracking_id}', [FrontendUserController::class, 'downloadReport'])->name('download.report');

    Route::get('/user/live-tracking', [FrontendUserController::class, 'live_tracking'])->name('live.tracking');


    Route::get('/user/payment-methods', [PaymentMethodController::class, 'paymentMethod'])->name('payment_method');
    Route::get('/user/payment-methods/show', [PaymentMethodController::class, 'paymentMethodShow'])->name('user.payment_method.show');
    Route::post('/user/payment-methods/store', [PaymentMethodController::class, 'paymentMethodStore'])->name('user.payment_method.store');
    Route::post('/user/payment-methods/update', [PaymentMethodController::class, 'paymentMethodUpdate'])->name('user.payment_method.update');
});

Route::get('/wishlist', [WishlistController::class, 'index'])->name('wishlist');
Route::post('/wishlist/toggle', [WishlistController::class, 'toggle'])->name('wishlist.toggle');
Route::post('/wishlist/remove', [WishlistController::class, 'remove'])->name('wishlist.remove');

Route::get('/user_setting', [FrontendDashboardController::class, 'user_setting'])->name('user_setting');
Route::get('/add_address', [FrontendDashboardController::class, 'add_address'])->name('add_address');
Route::get('/ticket_detail', [FrontendDashboardController::class, 'ticket_detail'])->name('ticket_detail');
Route::get('/add_payment', [FrontendDashboardController::class, 'add_payment'])->name('add_payment');
Route::get('/user-notification', [FrontendDashboardController::class, 'user_notification'])->name('user_notification');

Route::get('/product_viewcart', [HomeController::class, 'productViewcart'])->name('product_viewcart');



// OTP Verification
Route::post('/send-otp', [SendOtpController::class, 'sendOtp'])->name('send.otp');
Route::post('/verify-otp', [SendOtpController::class, 'verifyOtp'])->name('verify.otp');

Route::post('/send-login-otp', [SendOtpController::class, 'sendLoginOtp'])->name('send.login.otp');
Route::post('/verify-login-otp', [SendOtpController::class, 'verifyLoginOtp'])->name('verify.login.otp');

// Contact  Emquiry Submit
Route::post('/website/contact-submit', [ContactController::class, 'store'])->name('website.contact.submit');
Route::post('/website/newsletter-submit', [ContactController::class, 'storeNewsletter'])->name('website.newsletter.submit');
Route::get('/policy/{slug}', [PolicyController::class, 'show'])->name('policy.show');

Route::middleware('auth')->group(function () {

    // Website Teams
    Route::get('/website/teams', [WebTeamController::class, 'index'])->name('website.team.index');
    Route::get('/website/teams/list', [WebTeamController::class, 'list'])->name('website.team.list');
    Route::post('/website/team/store', [WebTeamController::class, 'store'])->name('website.team.store');
    Route::get('/website/team/{id}/edit', [WebTeamController::class, 'edit'])->name('website.team.edit');
    Route::post('/website/team/{id}', [WebTeamController::class, 'update'])->name('website.team.update');
    Route::post('/website/team-toggle/status', [WebTeamController::class, 'status'])->name('website.team.status');
    Route::delete('/website/team/{id}', [WebTeamController::class, 'destroy'])->name('website.team.destroy');

    // Website About
    Route::get('/website/about/index', [WebAboutController::class, 'index'])->name('website.about.index');
    Route::put('/website/about-update/{id}', [WebAboutController::class, 'update'])->name('website.about.update');

    // Policy Pages
    Route::get('/website/policy-pages', [PolicyController::class, 'index'])->name('website.policy.index');
    Route::get('/website/policy-pages/list', [PolicyController::class, 'list'])->name('website.policy.list');
    Route::post('/website/policy-page/store', [PolicyController::class, 'store'])->name('website.policy.store');
    Route::get('/website/policy-page/{id}/edit', [PolicyController::class, 'edit'])->name('website.policy.edit');
    Route::post('/website/policy-page/{id}', [PolicyController::class, 'update'])->name('website.policy.update');
    Route::post('/website/policy-toggle/status', [PolicyController::class, 'status'])->name('website.policy.status');
    Route::delete('/website/policy-page/{id}', [PolicyController::class, 'destroy'])->name('website.policy.destroy');

    // Website Contact Us
    Route::get('/website/contact-us', [ContactController::class, 'index'])->name('website.contact.index');
    Route::put('/website/contact-us/{id}', [ContactController::class, 'update'])->name('website.contact.update');
    Route::get('/website/contact/enquiries', [ContactController::class, 'enquiries'])->name('website.contact.enquiry.index');
    Route::delete('/website/contact-us/enquiries/delete/{id}', [ContactController::class, 'enquiryDelete'])->name('website.contact.enquiry.delete');

    // Newsletter
    Route::get('/website/newsletters', [ContactController::class, 'newsletters'])->name('website.newsletter.index');
    Route::delete('/website/newsletter/delete/{id}', [ContactController::class, 'newsletterDelete'])->name('website.newsletter.delete');

    // Website Faq
    Route::get('/website/faq', [FaqController::class, 'index'])->name('website.faq.index');
    Route::get('/website/faq-list', [FaqController::class, 'list'])->name('website.faq.list');
    Route::post('/website/faq-store', [FaqController::class, 'store'])->name('website.faq.store');


    Route::get('/website/coupons', [CouponController::class, 'index'])->name('website.coupon.index');
    Route::get('/website/coupons/list', [CouponController::class, 'list'])->name('website.coupon.list');
    Route::post('/website/coupons/store', [CouponController::class, 'store'])->name('website.coupon.store');
    Route::get('/website/coupons/{id}/edit', [CouponController::class, 'edit'])->name('website.coupon.edit');
    Route::put('/website/coupons/{id}', [CouponController::class, 'update'])->name('website.coupon.update');
    Route::delete('/website/coupons/{id}', [CouponController::class, 'destroy'])->name('website.coupon.destroy');
    Route::post('/website/coupon/status', [CouponController::class, 'status'])->name('website.coupon.status');

    // Agreements
    Route::get('/agreements', [AgreementController::class, 'index'])->name('agreements.index');
    Route::post('/agreement/store', [AgreementController::class, 'store'])->name('agreements.store');
    Route::get('/agreement/{id}/edit', [AgreementController::class, 'edit'])->name('agreement.edit');
    Route::put('/agreement/{id}', [AgreementController::class, 'update'])->name('agreement.update');
    Route::get('/get-users/{type}', [AgreementController::class, 'getUsers'])->name('agreements.getUsers');
    Route::get('/agreements/list', [AgreementController::class, 'list'])->name('agreements.list');
    Route::delete('/agreement/{id}', [AgreementController::class, 'destroy'])->name('agreement.destroy');
    Route::get('/agreement/{id}', [AgreementController::class, 'show'])->name('agreement.show');

    // Sign Agreement
    Route::get('/sign-agreements', [AgreementSignatureController::class, 'index'])->name('sign.agreements.index');
    Route::get('/sign-agreements/list', [AgreementSignatureController::class, 'list'])->name('sign.agreements.list');
    Route::get('/sign-agreement/{id}', [AgreementSignatureController::class, 'show'])->name('sign.agreement.show');
    Route::post('/sign-agreement/{id}/sign', [AgreementSignatureController::class, 'signAgreement'])->name('sign-agreement.sign');


    // Front-End Pages
    Route::get('/website/banner', [BannerController::class, 'index'])->name('website.banner');
    Route::get('/website/banner/list', [BannerController::class, 'list'])->name('website.banner.list');
    Route::post('/website/banner/store', [BannerController::class, 'store'])->name('website.banner.store');
    Route::get('/website/banner/{id}/edit', [BannerController::class, 'edit'])->name('website.banner.edit');
    Route::put('/website/banner/{id}', [BannerController::class, 'update'])->name('website.banner.update');
    Route::delete('/website/banner/{id}', [BannerController::class, 'destroy'])->name('website.banner.destroy');
    Route::post('/website/banner/status', [BannerController::class, 'toggleStatus'])->name('website.banner.status');
    Route::post('/website/banner/product/status', [BannerController::class, 'toggleProductStatus'])->name('website.banner.product.status');

    // Home Offers
    Route::get('/website/home/offers', [OfferController::class, 'index'])->name('website.home.offer');
    Route::get('/website/home/offers/list/{page}', [OfferController::class, 'list'])->name('website.home.offer.list');
    Route::post('/website/home/offers/store', [OfferController::class, 'store'])->name('website.home.offer.store');
    Route::get('/website/home/offer/{id}/edit', [OfferController::class, 'edit'])->name('website.home.offer.edit');
    Route::put('/website/home/offer/{id}', [OfferController::class, 'update'])->name('website.home.offer.update');
    Route::post('/website/home/offer/status', [OfferController::class, 'toggleStatus'])->name('website.home.offer.status');
    Route::delete('/website/home/offer/{id}', [OfferController::class, 'destroy'])->name('website.home.offer.destroy');

    // Home Features
    Route::get('/website/home/feature', [FeatureController::class, 'index'])->name('website.home.feature');
    Route::put('/website/home/feature/{id}', [FeatureController::class, 'update'])->name('website.home.feature.update');

    // Home Brands
    Route::get('/website/home/brands', [BrandController::class, 'index'])->name('website.home.brands');
    Route::post('/website/home/brand/store', [BrandController::class, 'store'])->name('website.home.brand.store');
    Route::get('/website/home/brand/list', [BrandController::class, 'list'])->name('website.home.brand.list');
    Route::get('/website/home/brand/{id}/edit', [BrandController::class, 'edit'])->name('website.home.brand.edit');
    Route::put('/website/home/brand/{id}', [BrandController::class, 'update'])->name('website.home.brand.update');
    Route::post('/website/home/brand/status', [BrandController::class, 'toggleStatus'])->name('website.home.brand.status');
    Route::delete('/website/home/brand/{id}', [BrandController::class, 'destroy'])->name('website.home.brand.destroy');

    // Home Videos
    Route::get('/website/home/videos', [VideoContoller::class, 'index'])->name('website.home.videos');
    Route::post('/website/home/video/store', [VideoContoller::class, 'store'])->name('website.home.video.store');
    Route::get('/website/home/video/list', [VideoContoller::class, 'list'])->name('website.home.video.list');
    Route::get('/website/home/video/{id}/edit', [VideoContoller::class, 'edit'])->name('website.home.video.edit');
    Route::put('/website/home/video/{id}', [VideoContoller::class, 'update'])->name('website.home.video.update');
    Route::post('/website/home/video/status', [VideoContoller::class, 'toggleStatus'])->name('website.home.video.status');
    Route::delete('/website/home/video/{id}', [VideoContoller::class, 'destroy'])->name('website.home.video.destroy');

    // Home Testimonials
    Route::get('/website/home/testimonials', [TestimonialController::class, 'index'])->name('website.home.testimonials');
    Route::post('/website/home/testimonial/store', [TestimonialController::class, 'store'])->name('website.home.testimonial.store');
    Route::get('/website/home/testimonial/list', [TestimonialController::class, 'list'])->name('website.home.testimonial.list');
    Route::get('/website/home/testimonial/{id}/edit', [TestimonialController::class, 'edit'])->name('website.home.testimonial.edit');
    Route::put('/website/home/testimonial/{id}', [TestimonialController::class, 'update'])->name('website.home.testimonial.update');
    Route::post('/website/home/testimonial/status', [TestimonialController::class, 'toggleStatus'])->name('website.home.testimonial.status');
    Route::delete('/website/home/testimonial/{id}', [TestimonialController::class, 'destroy'])->name('website.home.testimonial.destroy');

    // Website Blogs
    Route::get('/website/blogs', [BlogController::class, 'index'])->name('website.blogs');
    Route::post('/website/blog/store', [BlogController::class, 'store'])->name('website.blog.store');
    Route::get('/website/blog/list', [BlogController::class, 'list'])->name('website.blog.list');
    Route::get('/website/blog/{id}/edit', [BlogController::class, 'edit'])->name('website.blog.edit');
    Route::put('/website/blog/{id}', [BlogController::class, 'update'])->name('website.blog.update');
    Route::post('/website/blog/status', [BlogController::class, 'toggleCommentStatus'])->name('website.blog.status');
    Route::delete('/website/blog/{id}', [BlogController::class, 'commentDestroy'])->name('website.blog.destroy');

    // Website Blog Comments
    Route::get('/website/blog/comments', [BlogController::class, 'blogComments'])->name('website.blog.comments');
    Route::get('/website/blog/comment/list', [BlogController::class, 'commentList'])->name('website.blog.comment.list');
    Route::post('/website/blog/comment/status', [BlogController::class, 'toggleCommentStatus'])->name('website.blog.comment.status');
    Route::delete('/website/blog/comment/{id}', [BlogController::class, 'commentDestroy'])->name('website.blog.comment.destroy');

    // Docotr Reviews
    Route::get('/doctor-reviews', [DoctorController::class, 'doctorReviews'])->name('doctor.reviews');
    Route::get('/doctor-review/list', [DoctorController::class, 'doctorReviewList'])->name('doctor.review.list');
    Route::post('/doctor-review/status', [DoctorController::class, 'toggleDoctorReviewStatus'])->name('doctor.review.status');
    Route::delete('/doctor-review/{id}', [DoctorController::class, 'doctorReviewDestroy'])->name('doctor.review.destroy');

    // Website Package Reviews
    Route::get('/website/package/reviews', [PackageController::class, 'packageReviews'])->name('website.package.review');
    Route::get('/website/package/review/list', [PackageController::class, 'packageReviewList'])->name('website.package.review.list');
    Route::post('/website/package/review/status', [PackageController::class, 'togglePackageReviewStatus'])->name('website.package.review.status');
    Route::delete('/website/package/review/{id}', [PackageController::class, 'packageReviewDestroy'])->name('website.package.review.destroy');

    // Lab Test Packages
    Route::get('/packages', [PackageController::class, 'index'])->name('packages');
    Route::get('/packages-list', [PackageController::class, 'list'])->name('packages.list');
    Route::post('/packages-store', [PackageController::class, 'store'])->name('package.store');
    Route::get('/package/{id}/edit', [PackageController::class, 'edit'])->name('package.edit');
    Route::post('/package/{id}/update-step', [PackageController::class, 'update'])->name('package.update');
    Route::delete('/package/{id}', [PackageController::class, 'destroy'])->name('package.destroy');

    Route::get('/tests', [TestController::class, 'index'])->name('tests');
    Route::get('/tests-list', [TestController::class, 'list'])->name('tests.list');
    Route::post('/tests-store', [TestController::class, 'store'])->name('test.store');
    Route::get('/test/{id}/edit', [TestController::class, 'edit'])->name('test.edit');
    Route::put('/test/{id}', [TestController::class, 'update'])->name('test.update');
    Route::delete('/test/{id}', [TestController::class, 'destroy'])->name('test.destroy');

    // Search Package Test
    Route::get('/search-packages', [PackageController::class, 'search'])->name('packages.search');
    Route::get('/get-package-parameters', [PackageController::class, 'getPackageParameters'])->name('packages.parameters');
    Route::get('/search-tests', [TestController::class, 'search'])->name('tests.search');
    Route::get('/get-tests-parameters', [testController::class, 'getPackageParameters'])->name('tests.parameters');

    Route::post('/save-requisites', [RequisiteController::class, 'storeRequisites'])->name('requisites.store');

    Route::get('/requisites', [RequisiteController::class, 'Requisites'])->name('requisites');
    Route::get('/requisites/list', [RequisiteController::class, 'getRequisites'])->name('requisites.list');
    Route::post('/requisites/store', [RequisiteController::class, 'store'])->name('requisites.store');
    Route::delete('/requisites/{id}', [RequisiteController::class, 'destroy'])->name('requisites.delete');
    Route::get('/requisites/{id}/edit', [RequisiteController::class, 'edit'])->name('requisites.edit');
    Route::post('/requisites/update/{id}', [RequisiteController::class, 'update'])->name('requisites.update');



    // Labs
    Route::get('/labs', [LabController::class, 'index'])->name('labs');
    Route::get('/lab-list', [LabController::class, 'list'])->name('lab.list');
    Route::post('/lab-store', [LabController::class, 'store'])->name('lab.store');
    Route::get('/lab/{id}/edit', [LabController::class, 'edit'])->name('lab.edit');
    Route::put('/lab/{id}', [LabController::class, 'update'])->name('lab.update');
    Route::delete('/lab/{id}', [LabController::class, 'destroy'])->name('lab.destroy');
    Route::get('/lab/{labid}/profile', [LabController::class, 'profile'])->name('lab.profile');
    Route::post('/change-lab-status', [LabController::class, 'changeStatus'])->name('change.lab.status');


    // Lab Reviews
    Route::get('/lab-reviews', [LabController::class, 'labReviews'])->name('lab.reviews');
    Route::get('/lab-review/list', [LabController::class, 'labReviewList'])->name('lab.review.list');
    Route::post('/lab-review/status', [LabController::class, 'togglelabReviewStatus'])->name('lab.review.status');
    Route::delete('/lab-review/{id}', [LabController::class, 'labReviewDestroy'])->name('lab.review.destroy');

    // Lab Sliders
    Route::get('/lab-slider', [LabSliderController::class, 'index'])->name('lab.sliders');
    Route::post('/lab-slider/store', [LabSliderController::class, 'store'])->name('lab.slider.store');
    Route::get('/lab-slider/list', [LabSliderController::class, 'list'])->name('lab.slider.list');
    Route::get('/lab-slider/{id}/edit', [LabSliderController::class, 'edit'])->name('lab.slider.edit');
    Route::put('/lab-slider/{id}', [LabSliderController::class, 'update'])->name('lab.slider.update');
    Route::post('/lab-slider/status', [LabSliderController::class, 'toggleStatus'])->name('lab.slider.status');
    Route::delete('/lab-slider/{id}', [LabSliderController::class, 'destroy'])->name('lab.slider.destroy');

    // Lab Gallery
    Route::get('/lab-gallery', [LabGalleryController::class, 'index'])->name('lab.gallery');
    Route::post('/lab-gallery/store', [LabGalleryController::class, 'store'])->name('lab.gallery.store');
    Route::get('/lab-gallery/list', [LabGalleryController::class, 'list'])->name('lab.gallery.list');
    Route::get('/lab-gallery/{id}/edit', [LabGalleryController::class, 'edit'])->name('lab.gallery.edit');
    Route::put('/lab-gallery/{id}', [LabGalleryController::class, 'update'])->name('lab.gallery.update');
    Route::post('/lab-gallery/status', [LabGalleryController::class, 'toggleStatus'])->name('lab.gallery.status');
    Route::delete('/lab-gallery/{id}', [LabGalleryController::class, 'destroy'])->name('lab.gallery.destroy');

    // Refering Labs
    Route::get('/refering-labs', [ReferingLabController::class, 'index'])->name('refering-labs');
    Route::get('/refering-labs-list', [ReferingLabController::class, 'list'])->name('refering_lab.list');
    Route::post('/refering-lab-store', [ReferingLabController::class, 'store'])->name('refering_lab.store');
    Route::post('/assign-refering-lab-test', [ReferingLabController::class, 'assignReferedTest'])->name('assign.refering_lab.test');

    Route::get('/refering-tests', [ReferingLabController::class, 'referedTests'])->name('refering-tests');
    Route::get('/refering-tests-list', [ReferingLabController::class, 'referedTestList'])->name('refering-tests-list');
    Route::post('/refering-tests/change-status', [ReferingLabController::class, 'changeStatus'])->name('refering-tests.changeStatus');
    Route::delete('/refering-tests/delete/{id}', [ReferingLabController::class, 'destroy'])->name('refering-tests.delete');

    // Lab Users
    Route::get('/lab/user/profile/{userid}', [LabController::class, 'labUserProfile'])->name('lab.user.profile');
    Route::get('/lab/user/{id}/edit', [LabController::class, 'labUserEdit'])->name('lab.user.edit');
    Route::post('/lab-user-store', [LabController::class, 'labUserStore'])->name('lab.user.store');
    Route::post('/tests/export', [LabController::class, 'exportTestExcel'])->name('tests.export');

    Route::get('/manage/staff', [LabController::class, 'manageStaff'])->name('manage.staff');
    Route::get('/manage/staff/list', [LabController::class, 'manageStaffList'])->name('manage.staff.list');
    Route::post('/manage/staff/status', [LabController::class, 'updateStatus'])->name('manage.staff.status');


    // Patient Bookings
    Route::get('/patient-bookings', [LabBookingController::class, 'index'])->name('patient.bookings');
    Route::get('/booking-list', [LabBookingController::class, 'list'])->name('patient.booking.list');
    Route::get('/patient-bookings/completed', [LabBookingController::class, 'completedIndex'])->name('patient.bookings.completed');
    Route::get('/booking-list/completed', [LabBookingController::class, 'completedList'])->name('patient.booking.list.completed');
    Route::get('/booking/{id}/details', [LabBookingController::class, 'profile'])->name('patient.booking.details');
    Route::delete('/bookings/{id}', [LabBookingController::class, 'destroy']);

    // Generate Test Barcode
    Route::post('/generate-barcode', [BarcodeController::class, 'generate'])->name('barcode.generate');
    Route::post('/barcode-scan', [BarcodeController::class, 'scan'])->name('barcode.scan');

    Route::post('/reports/forward', [LabBookingController::class, 'forward'])->name('backend.reports.forward');

    // Upload Report
    Route::post('/upload-manual-report', [LabBookingController::class, 'uploadManualReport'])->name('upload.manual.report');
    Route::post('/upload-auto-report', [LabBookingController::class, 'uploadAutoReport'])->name('upload.auto.report');
    Route::delete('/booking-test/{id}/delete-report', [LabBookingController::class, 'deleteReport'])->name('booking-test.delete-report');
    Route::post('/booking/report/verify', [LabBookingController::class, 'verifyReport'])->name('booking.report.verify');
    Route::post('/booking/report/certify', [LabBookingController::class, 'certifyReport'])->name('booking.report.certify');


    // Sample Tracking
    Route::post('/store-sample-tracking', [TrackSampleController::class, 'store'])->name('sample-tracking.store');
    Route::get('/get-phlebotomist-info/{booking_id}', [TrackSampleController::class, 'getPhlebotomistInfo'])->name('sample-tracking.info');
    Route::post('/sample-tracking/upload-sample', [TrackSampleController::class, 'uploadSample'])->name('sample-tracking.upload');
    Route::get('/sample-tracking/delete-sample/{id}', [TrackSampleController::class, 'deleteSample']);
    Route::post('/sample-tracking/final-submit/{id}', [TrackSampleController::class, 'finalSubmit'])->name('final.submit');
    Route::post('/sample/update-status', [TrackSampleController::class, 'updateStatus'])->name('sample.update-status');

    // Sample Collection
    Route::get('/sample-collection', [SampleCollectionController::class, 'index'])->name('samplecollection.index');
    Route::get('/sample-collection/list', [SampleCollectionController::class, 'sampleCollectionList'])->name('samplecollection.list');
    Route::get('/sample-collection/completed', [SampleCollectionController::class, 'sampleCollectionCompleted'])->name('samplecollection.completed');
    Route::get('/sample-collection/completed/list', [SampleCollectionController::class, 'sampleCollectionCompletedList'])->name('samplecollection.completed.list');
    Route::get('/sample-collection/{id}/details', [SampleCollectionController::class, 'sampleCollectionProfile']);
    Route::post('/verify-collection-otp', [SampleCollectionController::class, 'verifyCollectionOtp'])->name('verify.collection.otp');



    // Users
    Route::get('/patients', [UserController::class, 'index'])->name('patients');
    Route::get('/user-list', [UserController::class, 'list'])->name('user.list');
    Route::post('/user-store', [UserController::class, 'store'])->name('user.store');
    Route::get('/user/{id}/edit', [UserController::class, 'edit'])->name('user.edit');
    Route::put('/user/{id}', [UserController::class, 'update'])->name('user.update');
    Route::delete('/user/{id}', [UserController::class, 'destroy'])->name('user.destroy');
    Route::get('/patient/{userid}/profile', [UserController::class, 'profile'])->name('patient.profile');


    // Doctors
    Route::get('/doctors', [DoctorController::class, 'index'])->name('doctors');
    Route::get('/doctor-list', [DoctorController::class, 'list'])->name('doctor.list');
    Route::post('/doctor-store', [DoctorController::class, 'store'])->name('doctor.store');
    Route::get('/doctor/{id}/edit', [DoctorController::class, 'edit'])->name('doctor.edit');
    Route::put('/doctor/{id}', [DoctorController::class, 'update'])->name('doctor.update');
    Route::delete('/doctor/{id}', [DoctorController::class, 'destroy'])->name('doctor.destroy');
    Route::get('/doctor/{doctorid}/profile', [DoctorController::class, 'profile'])->name('doctor.profile');
    Route::get('/doctor-bookings', [DoctorController::class, 'viewBooking'])->name('doctor.bookings.view');
    Route::get('/doctor-bookings/completed', [DoctorController::class, 'viewCompletedBooking'])->name('doctor.bookings.completed');
    Route::get('/doctor-bookings-get', [DoctorController::class, 'getBooking'])->name('doctor.bookings.get');
    Route::get('/doctor-bookings-completed-get', [DoctorController::class, 'getCompletedBooking'])->name('doctor.bookings.completed.get');
    Route::get('/booking/{bookingId}/profile', [DoctorController::class, 'bookingProfile'])->name('doctor.bookings.profile');
    Route::post('/doctor/consultation/{id}/prescription', [DoctorController::class, 'submitPrescription'])->name('doctor.prescription.submit');
    Route::get('/doctor/referring-doctor', [DoctorController::class, 'refList'])->name('doctor.referring_docotor.list');
    Route::post('/doctor-referring-doctor-store', [DoctorController::class, 'referingDoctorStore'])->name('doctor.referring_doctor.store');
    Route::get('/doctor-refering-doctor-list', [DoctorController::class, 'referingListView'])->name('doctor.refering_doctor.list');
    Route::post('/booking/refer', [DoctorController::class, 'refer'])->name('doctor.booking.refer');
    Route::post('/booking/{id}/toggle-status', [DoctorController::class, 'toggleStatus']);
    Route::post('/change-doctor-status', [DoctorController::class, 'changeStatus'])->name('change.doctor.status');
    Route::post('/doctor-self-booking', [DoctorController::class, 'doctorSelfBooking'])->name('doctor.self.booking');



    // Doctor Free Consultation Bookings
    Route::get('/free-consultation/bookings/pending', [DoctorController::class, 'viewFreeConsultBooking'])->name('free-conult.booking');
    Route::get('/free-consultation/bookings/list', [DoctorController::class, 'viewFreeConsultBookingList'])->name('free-conult.booking.list');
    Route::get('/free-consultation/bookings/completed', [DoctorController::class, 'viewFreeConsultBookingCompleted'])->name('free-conult.booking.completed');
    Route::get('/free-consultation/bookings/completed/list', [DoctorController::class, 'viewFreeConsultBookingCompletedList'])->name('free-conult.booking.completed.list');
    Route::post('/update/free-consultation/schedule', [DoctorController::class, 'updateFreeConsultSchedule'])->name('update.free-conult.schedule');
    Route::get('/free-consultation/booking/{bookingId}/profile', [DoctorController::class, 'freeConslutBookingProfile'])->name('free-conult.bookings.profile');

    // Doctor FAQ's
    Route::get('/doctor-faqs', [DoctorFaqController::class, 'index'])->name('doctor.faq');
    Route::get('/doctor-faq-list', [DoctorFaqController::class, 'list'])->name('doctor.faq.list');
    Route::post('/doctor-faq-store', [DoctorFaqController::class, 'store'])->name('doctor.faq.store');
    Route::get('/doctor-faq/{id}/edit', [DoctorFaqController::class, 'edit'])->name('doctor.faq.edit');
    Route::put('/doctor-faq/{id}', [DoctorFaqController::class, 'update'])->name('doctor.faq.update');
    Route::delete('/doctor-faq/{id}', [DoctorFaqController::class, 'destroy'])->name('doctor.faq.destroy');
    Route::post('/doctor-faq/status-update', [DoctorFaqController::class, 'updateStatus'])->name('doctor.faq.status.update');


    // corporates
    Route::get('/corporates', [CorporateController::class, 'index'])->name('corporates');
    Route::get('/corporate-list', [CorporateController::class, 'list'])->name('corporate.list');
    Route::post('/corporate-store', [CorporateController::class, 'store'])->name('corporate.store');
    Route::get('/corporate/{id}/edit', [CorporateController::class, 'edit'])->name('corporate.edit');
    Route::put('/corporate/{id}', [CorporateController::class, 'update'])->name('corporate.update');
    Route::delete('/corporate/{id}', [CorporateController::class, 'destroy'])->name('corporate.destroy');
    Route::get('/corporate/{corporateid}/profile', [CorporateController::class, 'profile'])->name('corporate.profile');
    Route::get('/corporate/employee-list', [CorporateController::class, 'empList'])->name('corporate.employee.list');
    Route::get('/corporate/get-employee-list', [CorporateController::class, 'getEmpList'])->name('corporate.get.employeeList');
    Route::post('/corporate/employee-store', [CorporateController::class, 'empStore'])->name('corporate.employee.store');
    Route::post('/corporate/employee-edit', [CorporateController::class, 'empEdit'])->name('corporate.employee.edit');
    Route::get('/corporate/{corporateid}/list', [CorporateController::class, 'corpEmpList'])->name('corporate.empList');
    Route::get('/corporate/get-list', [CorporateController::class, 'getCorpEmpList'])->name('corporate.get.empList');
    Route::get('/employee/{userid}/profile', [CorporateController::class, 'corpEmpProfile'])->name('corporate.employee.profile');
    Route::post('/corporate/import-employees', [CorporateController::class, 'importEmployees']);
    Route::post('/change-corporate-status', [CorporateController::class, 'changeStatus'])->name('change.corporate.status');
    Route::get('/corporate-payments', [CorporateController::class, 'payments'])->name('corporate.payments');
    Route::get('/corporate-payments/list', [CorporateController::class, 'paymentsList'])->name('corporate.payments.list');

    //Corporate Wallet
    Route::get('/corporate/wallet', [CorporateWalletController::class, 'getCorporateWallet']);
    Route::post('/corporate/wallet/add', [CorporateWalletController::class, 'addToWallet']);
    Route::post('/corporate/employee/wallet/add', [CorporateWalletController::class, 'addToEmployeeWallet']);
    Route::get('/corporate/employee/wallet/history', [CorporateWalletController::class, 'history']);
    Route::get('/corporate/wallet/view', [CorporateWalletController::class, 'index'])->name('corporate.wallet.index');
    Route::get('/corporate/wallet/history', [CorporateWalletController::class, 'getWalletHistory']);

    //Corporate Package Admin ENd
    Route::get('/corporate/packages', [CorporatePackageController::class, 'index'])->name('corporate.packages');
    Route::post('/corporate/packages/store', [CorporatePackageController::class, 'store'])->name('corporate.package.store');
    Route::delete('/corporate/packages/destroy/{id}', [CorporatePackageController::class, 'destroy'])->name('corporate.package.destroy');
    Route::get('/corp/packages-list', [CorporatePackageController::class, 'list'])->name('corporate.packages.list');
    Route::post('/corp/packages-assign', [CorporatePackageController::class, 'assignPackageToCorporate'])->name('corporate.packages.assign');
    Route::post('/corp/package/status-toggle/{id}', [CorporatePackageController::class, 'toggleStatus'])->name('corporate.packages.toggle-status');
    Route::get('/corp/{id}/edit', [CorporatePackageController::class, 'edit'])->name('corporate.package.edit');
    Route::post('/corp/update', [CorporatePackageController::class, 'update']);

    //Corporate Package
    Route::get('/corporate/packages/index', [CorporatePackageController::class, 'corpIndex'])->name('corporate.index.package');
    Route::post('/corporate/packages/apply-coupon', [CorporatePackageController::class, 'applyCoupon']);
    Route::post('/corporate/package/purchase', [CorporatePackageController::class, 'purchase'])->name('corporate.package.purchase');

    // Notifications Messages
    Route::get('/notification/messages', [NotificationMessageController::class, 'index'])->name('notification.messages');
    Route::get('/notification/messages-list', [NotificationMessageController::class, 'list'])->name('notification.messages.list');
    Route::post('/notification/messages-store', [NotificationMessageController::class, 'store'])->name('notification.messages.store');
    Route::get('/notification/messages/{id}/edit', [NotificationMessageController::class, 'edit'])->name('notification.messages.edit');
    Route::put('/notification/messages/{id}', [NotificationMessageController::class, 'update'])->name('notification.messages.update');
    Route::delete('/notification/messages/{id}', [NotificationMessageController::class, 'destroy'])->name('notification.messages.destroy');

    // Notifications
    Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications');
    Route::get('/notifications-list', [NotificationController::class, 'list'])->name('notifications.list');
    Route::post('/notifications/mark-read', [NotificationController::class, 'markAsRead'])->name('notifications.markRead');
    Route::post('/notifications/delete', [NotificationController::class, 'deleteNotification'])->name('notifications.delete');
    Route::post('/notifications/mark-all-read', [NotificationController::class, 'markAllRead'])->name('notifications.markAllRead');
    Route::post('/notifications/delete-all', [NotificationController::class, 'deleteAll'])->name('notifications.deleteAll');

    // Package Category
    Route::get('/package-category', [PackageCategoryController::class, 'index'])->name('package.category');
    Route::get('/package-category-list', [PackageCategoryController::class, 'list'])->name('package.category.list');
    Route::post('/package-category-store', [PackageCategoryController::class, 'store'])->name('package.category.store');
    Route::get('/package-category/{id}/edit', [PackageCategoryController::class, 'edit'])->name('package.category.edit');
    Route::put('/package-category/{id}', [PackageCategoryController::class, 'update'])->name('package.category.update');
    Route::delete('/package-category/{id}', [PackageCategoryController::class, 'destroy'])->name('package.category.destroy');
    Route::post('/package/category/status-update', [PackageCategoryController::class, 'updateStatus'])->name('package.category.status.update');

    // Product type
    Route::get('/product-type', [ProductTypeController::class, 'index'])->name('product.type');
    Route::get('/product-type-list', [ProductTypeController::class, 'list'])->name('product.type.list');
    Route::post('/product-type-store', [ProductTypeController::class, 'store'])->name('product.type.store');
    Route::get('/product-type/{id}/edit', [ProductTypeController::class, 'edit'])->name('product.type.edit');
    Route::put('/product-type/{id}', [ProductTypeController::class, 'update'])->name('product.type.update');
    Route::delete('/product-type/{id}', [ProductTypeController::class, 'destroy'])->name('product.type.destroy');

    // Product category
    Route::get('/product-category', [ProductCategoryController::class, 'index'])->name('product.category');
    Route::get('/product-category-list', [ProductCategoryController::class, 'list'])->name('product.category.list');
    Route::post('/product-category-store', [ProductCategoryController::class, 'store'])->name('product.category.store');
    Route::get('/product-category/{id}/edit', [ProductCategoryController::class, 'edit'])->name('product.category.edit');
    Route::put('/product-category/{id}', [ProductCategoryController::class, 'update'])->name('product.category.update');
    Route::delete('/product-category/{id}', [ProductCategoryController::class, 'destroy'])->name('product.category.destroy');

    // Product sub-category
    Route::get('/product-sub_category', [ProductSubCategoryController::class, 'index'])->name('product.sub_category');
    Route::get('/product-sub_category-list', [ProductSubCategoryController::class, 'list'])->name('product.sub_category.list');
    Route::post('/product-sub_category-store', [ProductSubCategoryController::class, 'store'])->name('product.sub_category.store');
    Route::get('/product-sub_category/{id}/edit', [ProductSubCategoryController::class, 'edit'])->name('product.sub_category.edit');
    Route::put('/product-sub_category/{id}', [ProductSubCategoryController::class, 'update'])->name('product.sub_category.update');
    Route::delete('/product-sub_category/{id}', [ProductSubCategoryController::class, 'destroy'])->name('product.sub_category.destroy');

    // Speciality Category
    Route::get('/speciality', [SpecialityController::class, 'index'])->name('speciality');
    Route::get('/speciality-list', [SpecialityController::class, 'list'])->name('speciality.list');
    Route::post('/speciality-store', [SpecialityController::class, 'store'])->name('speciality.store');
    Route::get('/speciality/{id}/edit', [SpecialityController::class, 'edit'])->name('speciality.edit');
    Route::put('/speciality/{id}', [SpecialityController::class, 'update'])->name('speciality.update');
    Route::delete('/speciality/{id}', [SpecialityController::class, 'destroy'])->name('speciality.destroy');
    Route::post('/speciality/status-update', [SpecialityController::class, 'updateStatus'])->name('speciality.status.update');

    // Lab Facility
    Route::get('/lab-facility', [FacilityController::class, 'index'])->name('lab.facility');
    Route::get('/lab-facility-list', [FacilityController::class, 'list'])->name('lab.facility.list');
    Route::post('/lab-facility-store', [FacilityController::class, 'store'])->name('lab.facility.store');
    Route::get('/lab-facility/{id}/edit', [FacilityController::class, 'edit'])->name('lab.facility.edit');
    Route::put('/lab-facility/{id}', [FacilityController::class, 'update'])->name('lab.facility.update');
    Route::delete('/lab-facility/{id}', [FacilityController::class, 'destroy'])->name('lab.facility.destroy');
    Route::post('/lab-facility/status-update', [FacilityController::class, 'updateStatus'])->name('lab.facility.status.update');

    // Scheduling
    Route::get('/scheduling', [SchedulingController::class, 'index'])->name('scheduling');
    Route::post('/schedules', [SchedulingController::class, 'store'])->name('schedules.store');
    Route::get('/schedules/{id}/edit', [SchedulingController::class, 'edit']);
    Route::put('/schedules/{id}', [SchedulingController::class, 'update']);
    Route::get('/schedules/filter', [SchedulingController::class, 'filter']);
    Route::delete('/schedules/{id}', [SchedulingController::class, 'destroy'])->name('schedules.destroy');
    Route::post('/schedules/delete-by-date', [SchedulingController::class, 'deleteByDate'])->name('schedules.deleteByDate');
    Route::post('/schedules/update-slots-by-date', [SchedulingController::class, 'updateSlotsByDate']);

    // Reports
    Route::get('/report-layout', [LabReportController::class, 'index'])->name('report.layout');
    Route::post('/report/layout/upload', [LabReportController::class, 'store'])->name('report.layout.upload');
    Route::get('/report-layout/preview', [LabReportController::class, 'preview'])->name('report.layout.preview');
    Route::get('/lab/all-reports', [LabReportController::class, 'allReport'])->name('lab.all.report');
    Route::get('/lab/all-reports/list', [LabReportController::class, 'allReportList'])->name('lab.all.report.list');

    // Reports verify-certify Pending
    Route::get('/reports/verify-certify', [LabReportController::class, 'verifyCertify'])->name('report.verify_certify');
    Route::get('/reports/verify-certify/list', [LabReportController::class, 'verifyCertifyList'])->name('report.verify_certify.list');

    // Reports verify-certify Completed
    Route::get('/reports/verify-certify/completed', [LabReportController::class, 'verifyCertifyCompleted'])->name('report.verify_certify_completed');
    Route::get('/reports/verify-certify/completed/list', [LabReportController::class, 'verifyCertifyCompletedList'])->name('report.verify_certify_completed.list');

    Route::get('/report/doctor-signature', [DoctorController::class, 'reportSignatureIndex'])->name('report.signature.layout');
    Route::post('/doctor/signature/upload', [DoctorController::class, 'upload'])->name('backend.doctor.signature.upload');

    // Vendor Routes
    Route::get('/vendors', [VendorController::class, 'index'])->name('vendors');
    Route::get('/vendor-list', [VendorController::class, 'list'])->name('vendor.list');
    Route::post('/vendor-store', [VendorController::class, 'store'])->name('vendor.store');
    Route::get('/vendor/{id}/edit', [VendorController::class, 'edit'])->name('vendor.edit');
    Route::put('/vendor/{id}', [VendorController::class, 'update'])->name('vendor.update');
    Route::delete('/vendor/{id}', [VendorController::class, 'destroy'])->name('vendor.destroy');
    Route::get('/vendor/{vendorid}/profile', [VendorController::class, 'profile'])->name('vendor.profile');
    Route::post('/change-vendor-status', [VendorController::class, 'changeStatus'])->name('change.vendor.status');

    // Orders
    Route::get('/vendor/orders', [OrderController::class, 'list'])->name('vendor.orders');
    Route::get('/vendor/orders/fetch', [OrderController::class, 'fetchOrders'])->name('vendor.orders.fetch');
    Route::get('/vendor/order/{id}/details', [OrderController::class, 'details'])->name('vendor.order.details');
    Route::post('/vendor/order/change-status', [OrderController::class, 'changeStatus'])->name('order.changeStatus');


    // Vendor Products
    Route::get('/vendor-products', [ProductController::class, 'index'])->name('products');
    Route::get('/add-product', [ProductController::class, 'addProduct'])->name('product.add');
    Route::get('/list-product', [ProductController::class, 'productList'])->name('product.list');
    Route::get('/vendor-product/{id}/edit', [ProductController::class, 'editProduct'])->name('product.edit');
    Route::post('/vendor-product/{id}/update', [ProductController::class, 'updateProduct'])->name('product.update');
    Route::post('/store-product', [ProductController::class, 'storeProduct'])->name('product.store');
    Route::get('/get-categories', [ProductController::class, 'getCategories'])->name('get.categories');
    Route::get('/get-subcategories', [ProductController::class, 'getSubcategories'])->name('get.subcategories');
    Route::get('/products/rejection-reason/{id}', [ProductController::class, 'getRejectionReason']);
    Route::post('/products/change-status/{id}', [ProductController::class, 'changeStatus']);
    Route::delete('/product/image/{id}/delete', [ProductController::class, 'deleteImage'])->name('product.image.delete');
    Route::delete('/product/{id}/destroy', [ProductController::class, 'destroy'])->name('product.destroy');

    Route::get('/vendor/product/reviews', [ProductReviewController::class, 'productReviews'])->name('product.reviews');
    Route::get('/vendor/product/reviews/list', [ProductReviewController::class, 'productReviewList'])->name('product.reviews.list');
    Route::post('/vendor/product/review/status', [ProductReviewController::class, 'toggleProductReviewStatus'])->name('product.review.status');
    Route::delete('/vendor/product/review/{id}', [ProductReviewController::class, 'productReviewDestroy'])->name('product.review.destroy');

    // Vendor Product Attributes
    Route::get('/product-attributes', [AttributeController::class, 'index'])->name('product.attribute');
    Route::get('/product-attribute-list', [AttributeController::class, 'list'])->name('product.attribute.list');
    Route::post('/product-attribute-store', [AttributeController::class, 'store'])->name('product.attribute.store');
    Route::get('/product-attribute/{id}/edit', [AttributeController::class, 'edit'])->name('product.attribute.edit');
    Route::put('/product-attribute/{id}', [AttributeController::class, 'update'])->name('product.attribute.update');
    Route::delete('/product-attribute/{id}', [AttributeController::class, 'destroy'])->name('product.attribute.destroy');
    Route::get('/product-attribute/{id}/values', [AttributeController::class, 'getValues']);

    // Vendor Products Varient
    Route::get('/vendor-product/{id}/varients', [ProductController::class, 'varientProduct'])->name('product.varient');
    Route::get('/vendor-product/varient/{id}/list', [ProductController::class, 'varientProductList'])->name('product.varient.list');
    Route::get('/vendor-product/{id}/varient/add', [ProductController::class, 'varientProductAdd'])->name('product.varient.add');
    Route::post('/vendor-product/varient/store', [ProductController::class, 'varientProductStore'])->name('product.varient.store');
    Route::get('/vendor-product/varient/{id}/edit', [ProductController::class, 'editVarientProduct'])->name('product.varient.edit');
    Route::post('/vendor-product/varient/update/{id}', [ProductController::class, 'updateVarientProduct'])->name('product.varient.update');
    Route::get('/product-varient/rejection-reason/{id}', [ProductController::class, 'getVarientRejectionReason']);
    Route::post('/product-varient/change-status/{id}', [ProductController::class, 'changeVarientStatus']);
    Route::delete('/product-varient/{id}', [ProductController::class, 'destroyVarient']);

    // Front-End Corporate Pages
    // Corporate Banner
    Route::get('/corporate-banners', [CorporateBannerController::class, 'index'])->name('corporate.banner');
    Route::get('/corporate-banner/list', [CorporateBannerController::class, 'list'])->name('corporate.banner.list');
    Route::post('/corporate-banner/store', [CorporateBannerController::class, 'store'])->name('corporate.banner.store');
    Route::get('/corporate-banner/{id}/edit', [CorporateBannerController::class, 'edit'])->name('corporate.banner.edit');
    Route::put('/corporate-banner/{id}', [CorporateBannerController::class, 'update'])->name('corporate.banner.update');
    Route::delete('/corporate-banner/{id}', [CorporateBannerController::class, 'destroy'])->name('corporate.banner.destroy');
    Route::post('/corporate-banner/status', [CorporateBannerController::class, 'toggleStatus'])->name('corporate.banner.status');

    // Corporate About
    Route::get('/corporate-about', [CorporateAboutController::class, 'index'])->name('corporate.about');
    Route::put('/corporate/about/{id}', [CorporateAboutController::class, 'update'])->name('corporate.about.update');

    // Corporate About
    Route::get('/corporate-services', [CorporateAboutController::class, 'serviceIndex'])->name('backend.corporate.services');
    Route::put('/corporate-service/{id}', [CorporateAboutController::class, 'serviceUpdate'])->name('backend.corporate.services.update');

    // Corporate Wellness Program
    Route::get('/corporate-wellness-programs', [CorporateWellnessProgramController::class, 'index'])->name('corporate.wellness');
    Route::get('/corporate-wellness/list', [CorporateWellnessProgramController::class, 'list'])->name('corporate.wellness.list');
    Route::post('/corporate-wellness/store', [CorporateWellnessProgramController::class, 'store'])->name('corporate.wellness.store');
    Route::get('/corporate-wellness/{id}/edit', [CorporateWellnessProgramController::class, 'edit'])->name('corporate.wellness.edit');
    Route::put('/corporate-wellness/{id}', [CorporateWellnessProgramController::class, 'update'])->name('corporate.wellness.update');
    Route::delete('/corporate-wellness/{id}', [CorporateWellnessProgramController::class, 'destroy'])->name('corporate.wellness.destroy');
    Route::post('/corporate-wellness/status', [CorporateWellnessProgramController::class, 'toggleStatus'])->name('corporate.wellness.status');
    Route::get('/corporate-wellness/{id}/details', [CorporateWellnessProgramController::class, 'wellnessDetails'])->name('corporate.wellness.details');

    // Corporate Doctor Consult
    Route::get('/corporate/docotor-consultation', [CorporateDoctorConsultController::class, 'doctorIndex'])->name('corporate.doctor_consult');
    Route::put('/corporate/docotor-consultation/{id}', [CorporateDoctorConsultController::class, 'doctorUpdate'])->name('corporate.doctor_consult.update');

    // Corporate Lab Test
    Route::get('/corporate-lab-test', [CorporateLabTestController::class, 'labTestIndex'])->name('corporate.lab_test');
    Route::put('/corporate-lab-test/{id}', [CorporateLabTestController::class, 'labTestUpdate'])->name('corporate.lab_test.update');

    // Corporate Hospital Assistance
    Route::get('/corporate-hospital-assistance', [CorporateHospitalAssistanceController::class, 'hospitalAssistanceIndex'])->name('corporate.hospital_assistance');
    Route::put('/corporate-hospital-assistance/{id}', [CorporateHospitalAssistanceController::class, 'hospitalAssistanceUpdate'])->name('corporate.hospital_assistance.update');

    Route::post('/package/save-draft', [PackageController::class, 'saveDraft']);
    Route::post('/package/submit', [PackageController::class, 'submit']);
});

Route::post('/check-slot-availability', [CheckoutController::class, 'checkSlotAvailability'])->name('check.slot');
Route::prefix('razorpay')->group(function () {
    Route::post('checkout', [PaymentController::class, 'checkout']);
    Route::post('success', [PaymentController::class, 'paymentSuccess']);
});
Route::get('/search', [HomeController::class, 'smartSearch'])->name('search');


require __DIR__ . '/auth.php';

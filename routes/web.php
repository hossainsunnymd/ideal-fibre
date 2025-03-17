<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HistoryController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\ModeratorController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use App\Http\Middleware\AdminMiddleware;
use App\Http\Middleware\SessionAuthenticateMiddleware;
use App\Http\Middleware\SuperAdminMiddleware;
use Illuminate\Support\Facades\Route;

//HomePage

Route::get('/',[DashboardController::class,'home'])->name('home');


// ================== User Routes ==================

Route::post('user-registration', [UserController::class, 'userRegistration'])->name('userRegistration');
Route::post('user-login', [UserController::class, 'userLogin'])->name('userLogin');
Route::get('user-logout', [UserController::class, 'userLogout'])->name('userLogout');
Route::post('send-otp', [UserController::class, 'sendOtp'])->name('sendOtp');
Route::post('verify-otp', [UserController::class, 'verifyOtp'])->name('verifyOtp');
Route::post('reset-pass', [UserController::class, 'resetPassword'])->name('resetPassword')->middleware(SessionAuthenticateMiddleware::class);
Route::post('reset-pass', [UserController::class, 'resetPassword'])->name('resetPassword')->middleware(SessionAuthenticateMiddleware::class);

// User Page Routes
Route::get('/registration-page', [UserController::class, 'registrationPage'])->name('registrationPage');
Route::get('/login-page', [UserController::class, 'loginPage'])->name('loginPage');
Route::get('/send-otp-page', [UserController::class, 'sendOtpPage'])->name('sendOtpPage');
Route::get('/verify-otp-page', [UserController::class, 'verifyOtpPage'])->name('verifyOtpPage');
Route::get('/moderator-dashboard', [ModeratorController::class, 'moderatorDashboard'])->name('modaratorDashboard')->middleware(SessionAuthenticateMiddleware::class);

//work order
Route::get('/delivered-work-order', [ModeratorController::class, 'deliviredWorkOrder'])->name('deliviredWorkOrder')->middleware(SessionAuthenticateMiddleware::class);


// ================== Middleware Protected Routes ==================
Route::middleware([SessionAuthenticateMiddleware::class,AdminMiddleware::class])->group(function () {

    //user


    // Dashboard Routes
    Route::get('/dashboard-page', [DashboardController::class, 'dashboardPage'])->name('dashboardPage');
    Route::get('/sale-page', [DashboardController::class, 'salePage'])->name('salePage');
    Route::get('/invoice-page', [InvoiceController::class, 'listInvoice'])->name('listInvoice');


    Route::get('/profile-page', [ProfileController::class, 'profilePage'])->name('profilePage');
    Route::post('/update-profile', [ProfileController::class, 'updateProfile'])->name('updateProfile');

    // Customer Routes
    Route::post('/create-customer', [CustomerController::class, 'createCustomer'])->name('createCustomer');
    Route::post('/update-customer', [CustomerController::class, 'updateCustomer'])->name('updateCustomer');
    Route::get('/delete-customer', [CustomerController::class, 'deleteCustomer'])->name('deleteCustomer');

    // Product Routes
    Route::post('/create-product', [ProductController::class, 'createProduct'])->name('createProduct');
    Route::post('/update-product', [ProductController::class, 'updateProduct'])->name('updateProduct');
    Route::get('/delete-product', [ProductController::class, 'deleteProduct'])->name('deleteProduct');

    // Invoice Routes
    Route::post('/create-invoice', [InvoiceController::class, 'createInvoice'])->name('createInvoice');
    Route::get('/delete-invoice', [InvoiceController::class, 'deleteInvoice'])->name('deleteInvoice');

    //update work order
    Route::post('/update-work-order', [InvoiceController::class, 'updateWorkOrder'])->name('updateWorkOrder');

;
});

// ================== Page Routes ==================
Route::middleware([SessionAuthenticateMiddleware::class,AdminMiddleware::class])->group(function () {
    // Customer Pages
    Route::get('/customer-page', [CustomerController::class, 'customerPage'])->name('customerPage');
    Route::get('/customer-save-page', [CustomerController::class, 'customerSavePage'])->name('customerSavePage');

    // Product Pages
    Route::get('/product-page', [ProductController::class, 'productPage'])->name('productPage');
    Route::get('/product-save-page', [ProductController::class, 'productSavePage'])->name('productSavePage');

    //report Pages
    Route::get('/report-page', [DashboardController::class, 'reportPage'])->name('reportPage');
    Route::get('/sales-report', [DashboardController::class, 'salesReport'])->name('salesReport');

    //delivery history page
    Route::get('/delivery-history-page', [HistoryController::class, 'deliveryHistory'])->name('deliveryHistory');

    //order history page
    Route::get('/order-history-page', [HistoryController::class, 'orderHistory'])->name('orderHistory');

    //order save page
    Route::get('/order-save-page', [HistoryController::class, 'orderSavePage'])->name('orderSavePage');




});

Route::middleware([SessionAuthenticateMiddleware::class,SuperAdminMiddleware::class])->group(function () {

  //users
    Route::get('/user-page', [UserController::class, 'userPage'])->name('userPage');
    Route::get('/user-save-page', [UserController::class, 'userSavePage'])->name('userSavePage');
    Route::post('/create-user', [UserController::class, 'createUser'])->name('createUser');
    Route::post('/update-user', [UserController::class, 'updateUser'])->name('updateUser');
    Route::get('/delete-user', [UserController::class, 'deleteUser'])->name('deleteUser');

    });


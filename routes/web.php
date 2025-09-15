<?php
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\Guest\HomeController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\UserManageController;
use App\Http\Controllers\Admin\RoomManageController;
use App\Http\Controllers\Admin\PromotionManageController;
use App\Http\Controllers\Admin\InstrumentManageController;
use App\Http\Controllers\Admin\LogManageController;
use App\Http\Controllers\Admin\ProfileManageController;

use App\Http\Controllers\User\UserController;
use App\Http\Controllers\User\BookingController;


// ----------------------------- Guest Section ----------------------------- //
Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/login', [AuthController::class, 'loginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/register', [AuthController::class, 'registerForm'])->name('register');
Route::post('/register', [AuthController::class, 'register']);

Route::get('/forgot-password', [AuthController::class, 'forgotPasswordForm'])->name('password.request');
Route::post('/forgot-password', [AuthController::class, 'sendResetLink']);
Route::get('/reset-password/{token}', [AuthController::class, 'resetPasswordForm'])->name('password.reset');
Route::post('/reset-password', [AuthController::class, 'resetPassword']);

Route::middleware(['auth'])->group(function() {

    // ------------------------------------------------------------------------- //
    // ----------------------------- Admin Section ----------------------------- //
    // ------------------------------------------------------------------------- //

    // ----------------------------- Dashboard ----------------------------- //
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');

    // ----------------------------- User Management ----------------------------- //
    Route::get('/users', [UserManageController::class, 'userManagement'])->name('admin.userManagement');
    Route::get('/users/{id}/edit', [UserManageController::class, 'editUser'])->name('admin.editUser');
    Route::post('/users/{id}/update', [UserManageController::class, 'updateUser'])->name('admin.users.update');
    Route::post('/users/{id}/reset-password', [UserManageController::class, 'resetPassword'])->name('admin.users.resetPassword');

    // ----------------------------- Room Management ----------------------------- //
    Route::get('/rooms', [RoomManageController::class, 'rooms'])->name('admin.rooms');
    Route::post('/rooms', [RoomManageController::class, 'storeRoom'])->name('admin.rooms.store');
    Route::get('/rooms/{id}/edit', [RoomManageController::class, 'editRoom'])->name('admin.rooms.edit');
    Route::put('/rooms/{id}', [RoomManageController::class, 'updateRoom'])->name('admin.rooms.update');
    Route::delete('/rooms/{id}', [RoomManageController::class, 'deleteRoom'])->name('admin.rooms.delete');
    
    Route::get('/rooms/{room}/instruments', [RoomManageController::class, 'showRoomInstruments'])->name('admin.rooms.instruments');
    Route::post('/rooms/{room}/add-instrument', [RoomManageController::class, 'addInstrumentToRoom'])->name('admin.rooms.addInstrument');
    Route::post('/rooms/{room}/instruments/{instrument}/update', [RoomManageController::class, 'updateRoomInstrument'])->name('admin.rooms.updateInstrument');
    Route::delete('/rooms/{room}/instruments/{instrument}/detach', [RoomManageController::class, 'detachInstrumentFromRoom'])->name('admin.rooms.detachInstrument');

    // ----------------------------- Promotion Management ----------------------------- //
    Route::get('/promotions', [PromotionManageController::class, 'promotions'])->name('admin.promotions');
    Route::get('/promotions/create', [PromotionManageController::class, 'createPromotion'])->name('admin.promotions.create');
    Route::get('/promotions/{id}/edit', [PromotionManageController::class, 'editPromotion'])->name('admin.promotions.edit');
    Route::post('/promotions/store', [PromotionManageController::class, 'storePromotion'])->name('admin.promotions.store');
    Route::post('/promotions/{id}/update', [PromotionManageController::class, 'updatePromotion'])->name('admin.promotions.update');
    Route::post('/promotions/{id}/delete', [PromotionManageController::class, 'deletePromotion'])->name('admin.promotions.delete');
    Route::post('/promotions/{id}/toggle', [PromotionManageController::class, 'togglePromotion'])->name('admin.promotions.toggle');

    // ----------------------------- Instrument Management ----------------------------- //
    Route::get('/instrument-categories', [InstrumentManageController::class, 'instrumentCategories'])->name('admin.instrumentCategories');
    Route::post('/instrument-categories', [InstrumentManageController::class, 'storeInstrumentCategory'])->name('admin.instrumentCategories.store');
    Route::post('/instrument-categories/delete-selected', [InstrumentManageController::class, 'deleteSelectedInstrumentCategories'])->name('admin.instrumentCategories.deleteSelected');
    Route::get('/instruments/{category_id}', [InstrumentManageController::class, 'instrumentsByCategory'])->name('admin.instruments.byCategory');
    Route::post('/instruments', [InstrumentManageController::class, 'storeInstrument'])->name('admin.instruments.store');
    Route::post('/instruments/{id}/update', [InstrumentManageController::class, 'updateInstrument'])->name('admin.instruments.update');
    Route::delete('/instruments/{id}', [InstrumentManageController::class, 'deleteInstrument'])->name('admin.instruments.delete');
    Route::get('/instruments/{id}/show', [InstrumentManageController::class, 'showInstrument'])->name('admin.instruments.show');
    Route::get('/instruments/{id}/add-room', [InstrumentManageController::class, 'addRoomToInstrument'])->name('admin.instruments.addRoom');
    Route::post('/instruments/{id}/store-room', [InstrumentManageController::class, 'storeInstrumentRoom'])->name('admin.instruments.storeRoom');
    Route::post('/instruments/{instrument}/rooms/{room}/update', [InstrumentManageController::class, 'updateInstrumentRoom'])->name('admin.instruments.updateRoom');
    Route::delete('/instruments/{instrument}/rooms/{room}/detach', [InstrumentManageController::class, 'detachRoom'])->name('admin.instruments.detachRoom');

    // ----------------------------- Admmin Profile ----------------------------- //
    Route::get('/profile', [ProfileManageController::class, 'editProfile'])->name('admin.profile.edit');
    Route::post('/profile', [ProfileManageController::class, 'updateProfile'])->name('admin.profile.update');

    // ----------------------------- Log ----------------------------- //
    Route::get('/log', [LogManageController::class, 'log'])->name('admin.log');

    
    // ------------------------------------------------------------------------ //
    // ----------------------------- User Section ----------------------------- //
    // ------------------------------------------------------------------------ //

    // ----------------------------- User Home ----------------------------- //
    Route::get('/user/home', [UserController::class, 'home'])->name('user.home');

    // ----------------------------- User Profile ----------------------------- //
    Route::get('/user/profile', [UserController::class, 'editProfile'])->name('user.profile.edit');
    Route::post('/user/profile', [UserController::class, 'updateProfile'])->name('user.profile.update');

    // ----------------------------- ฺBooking History ----------------------------- //
    Route::get('/user/my-bookings', [BookingController::class, 'index'])->name('user.bookings');
    Route::get('/user/my-bookings/{booking}/edit', [BookingController::class, 'edit'])->name('user.bookings.edit');
    Route::put('/bookings/{booking}', [BookingController::class, 'update'])->name('user.bookings.update');
    Route::post('/user/my-bookings/{booking}/cancel', [BookingController::class, 'cancel'])->name('user.bookings.cancel');
    Route::delete('/bookings/{booking}', [BookingController::class, 'destroy'])->name('user.bookings.destroy');

    // ----------------------------- ฺRoom Info ----------------------------- //
    Route::get('/user/room/{room}', [BookingController::class, 'roomInfo'])->name('user.roominfo');
    Route::post('/user/room/{room}/check-availability', [BookingController::class, 'checkAvailability'])->name('user.room.checkAvailability');

    // ----------------------------- ฺRoom AddOn ----------------------------- //
    Route::get('/user/room/{room}/addons', [BookingController::class, 'roomAddon'])->name('user.room.addons');
    Route::post('/user/room/{room}/addons/calculate', [BookingController::class, 'calculateAddon'])->name('user.room.addons.calculate');

    // ----------------------------- ฺPayment ----------------------------- //
    Route::get('/room/{room}/payment', [BookingController::class, 'payment'])->name('user.room.payment');
    Route::post('/user/room/{room}/qrcode', [BookingController::class, 'showQRCode'])->name('user.room.qrcode');

    // ----------------------------- ฺConfirm Payment ----------------------------- //
    Route::post('/user/room/{room}/confirm-payment', [BookingController::class, 'confirmPayment'])->name('user.room.confirmPayment');

    // ----------------------------- ฺReceipt ----------------------------- //
    Route::get('/user/room/{booking}/receipt', [BookingController::class, 'showReceipt'])->name('user.room.receipt');
    Route::get('/user/room/{booking}/receipt/pdf', [BookingController::class, 'exportReceiptPDF'])->name('user.room.receipt.pdf');

});

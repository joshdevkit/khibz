<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ReportController;

// Home page route
Route::get('/', function () {
    return view('home');
})->name('home');

// Order routes
Route::get('/order/{id}', [OrderController::class, 'show'])->name('order.show');
Route::get('/order/create', [OrderController::class, 'create'])->name('order.create');
Route::post('/order', [OrderController::class, 'store'])->name('order.store');

// Reservation routes
Route::get('/reservation', [ReservationController::class, 'index'])->name('reservation.index');
Route::get('/reservation/details', [ReservationController::class, 'details'])->name('reservation.details');
Route::get('/reservation/form', [ReservationController::class, 'form'])->name('reservation.form');
Route::post('/reservation/submit', [ReservationController::class, 'submit'])->name('reservation.submit');

// Menu page route
Route::get('/menu', function () {
    return view('menu');
})->name('menu');

// About Us page route
Route::get('/about', function () {
    return view('about');
})->name('about');

// Admin routes with middleware protection
Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/admin', [AdminController::class, 'index'])->name('admin.dashboard');
    Route::get('/admin/reservations', [AdminController::class, 'manageReservation'])->name('admin.reservations');
    Route::get('/admin/menu', [AdminController::class, 'manageMenu'])->name('admin.menu');
    Route::get('/admin/users', [AdminController::class, 'manageUsers'])->name('admin.users');
    Route::post('/admin/reservations/update-status', [ReservationController::class, 'updateStatus'])->name('reservation.update.status');
    Route::get('/admin/reports', [ReportController::class, 'index'])->name('admin.reports');
    Route::delete('/admin/reservations/{id}', [ReservationController::class, 'delete'])->name('reservation.delete');
});

// Authentication routes
Route::get('/login', [App\Http\Controllers\Auth\LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [App\Http\Controllers\Auth\LoginController::class, 'login']);
Route::post('/logout', [App\Http\Controllers\Auth\LoginController::class, 'logout'])->name('logout');

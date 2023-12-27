<?php

use App\Http\Controllers\Auth\LoginRegisterController;
use App\Http\Controllers\AuthenticationController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\PaymentController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RegistrationController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ApiConsumerController;




/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// In routes/web.php


// API routes
Route::get('/', [ProductController::class, 'homeIndexAPI'])->name('homeIndex');


Route::get('/product/{id}', [ProductController::class, 'showProductAPI'])->name('showProduct');


Route::get('/productsCatalog', [ProductController::class, 'catalogIndexAPI'])->name('productsCatalog');


//Route::post('/addToCart/{userId}/{productId}', [CartController::class, 'addProductToCartAPI'])->name('addProductToCart');

Route::post('/addToCart', [CartController::class, 'addProductToCartAPI'])->name('addProductToCart');

Route::post('/minusQuantity', [CartController::class, 'minusQuantityAPI'])->name('minusQuantity');

Route::get('/cartPage' , [CartController::class, 'cartProductsAPI'])->name('cartPage');

Route::get('/checkoutPage' , [PaymentController::class, 'cartProductsCheckoutPageAPI'])->name('checkoutPage');

Route::post('/checkoutPagePost' , [PaymentController::class, 'checkoutPagePostAPI'])->name('checkoutPagePost');


// User routes
// User reg routes
Route::get('/userReg' , [RegistrationController::class, 'userReg'])->name('userReg');
Route::post('/userReg', [RegistrationController::class, 'userRegPostAPI'])->name('userRegPost');


// Login routes
Route::get("/login", [AuthenticationController::class, 'login'])->name('login');

Route::post('/login', [AuthenticationController::class, 'loginPostAPI'])->name('loginPost');
Route::post('/logout', [AuthenticationController::class, 'logoutPost'])->name('logoutPost');


// Profile
// Using old method to show profile
Route::get('/profile', [ProfileController::class, 'showProfile'])->name('profile');


// Change password
Route::post('/changePassword', [ProfileController::class, 'changePasswordAPI'])->name('changePassword');


// Admin page routes
// Using old
Route::get('/productPageAdmin', [productController::class, 'productPageAdmin'])->name('productPageAdmin');


// Add products
Route::post('/addProductDB', [ProductController::class, 'addProductDBAPI'])->name('addProductDB');


// Delete product routes
Route::post('/deleteProduct/{id}', [ProductController::class, 'deleteProductAPI'])->name('deleteProduct');




Route::get('/paymentComplete', function () {
    return view('paymentcomplete');
})->name('paymentComplete');









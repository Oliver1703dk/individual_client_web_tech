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


//Route::get('/products', [ApiConsumerController::class, 'getProducts'])->name('getProducts');
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



//// User reg routes
//Route::get('/userReg' , [RegistrationController::class, 'userReg'])->name('userReg');
//Route::post('/userReg', [RegistrationController::class, 'userRegPost'])->name('userRegPost');



// Login and logout routes
//Route::get("/login", [AuthenticationController::class, 'login'])->name('login');
//Route::post('/login', [AuthenticationController::class, 'loginPost'])->name('loginPost');
//Route::post('/logout', [AuthenticationController::class, 'logoutPost'])->name('logoutPost');


// Checkout page routes
//Route::get('/checkoutPage' , [PaymentController::class, 'indexCheckoutPage'])->name('checkoutPage');
//Route::post('/checkoutPagePost', [PaymentController::class, 'checkoutPagePost'])->name('checkoutPagePost');

// ProductPage routes
//Route::get('/productPage' , [ProductController::class, 'productPage'])->name('productPage');

//Route::post('/addItem', [CartController::class, 'addItem'])->name('addItem');


// Front page route
//Route::get('/', [ProductController::class, 'index'])->name('index');

// Cart routes
//Route::get('/cart', [CartController::class, 'index'])->name('cart');

//Route::post('/cartMinus', [CartController::class, 'minusQuantity'])->name('minusQuantity');



// Profile routes
//Route::get('/profile', [ProfileController::class, 'showProfile'])->name('profile');


// Product catelog routes
//Route::get('/productsCatalog', [ProductController::class, 'indexProducts'])->name('productsCatalog');


// Change password route
//Route::post('/changePassword', [ProfileController::class, 'changePassword'])->name('changePassword');



//// Admin page routes
//Route::get('/productPageAdmin', [productController::class, 'productPageAdmin'])->name('productPageAdmin');
//
//Route::post('/addProductDB', [ProductController::class, 'addProductDB'])->name('addProductDB');
//
//// Delete product routes
//Route::post('/deleteProduct', [ProductController::class, 'deleteProduct'])->name('deleteProduct');






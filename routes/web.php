<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ContactsController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\FileController;
use App\Http\Controllers\NicotineLevelsController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\OrdersController;
use App\Http\Controllers\ProductsController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProductsFormatsController;
use App\Http\Controllers\ProductTypesController;
use App\Http\Controllers\RangesController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\VolumesController;

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

Route::get('/', function () {
    return view('welcome');
})->name('welcome');

Route::controller(ContactController::class)->group(function () {
    Route::get('/contact', 'render')->name('contact');
    Route::post('/contact/add', 'add')->name('contact-add');
    Route::delete('/contact/delete/{id}', 'delete')->name('contact-delete');
});

Route::controller(ContactsController::class)->group(function () {
    Route::get('/contacts', 'render')->name('contacts');
    Route::post('/contacts/download', 'download')->name('contacts-download');
    Route::delete('/contacts/delete', 'delete')->name('contacts-delete');
});

Route::controller(FileController::class)->group(function () {
    Route::get('/file/download/{file}/{path}/{filename}', 'download')->name('file-download');
});

Route::controller(OrderController::class)->group(function () {
    Route::get('/commande', 'render')->name('order');
    Route::post('/commande/add', 'add')->name('order-add');
});
Route::controller(OrdersController::class)->group(function () {
    Route::get('/commandes', 'display')->name('orders');
    Route::post('/commandes/download', 'download')->name('orders-download');
    Route::delete('/commandes/delete/{id?}', 'delete')->name('orders-delete');
});

//------ FORM RESPONSES -------//

Route::get('form/validation', function () {
    return view('shared.form-validation');
})->name('form-validation');

Route::get('form/error', function () {
    return view('shared.form-error');
})->name('form-error');

//------ ERRORS -------//

Route::get('/404', function () {
    return view('404');
})->name('404');


//-------------------------//
//------ DASHBOARD -------//
//-----------------------//
// Route::get('/dashboard', function () {
//     return view('dashboard.dashboard');
// })->name('dashboard');

Route::controller(DashboardController::class)->group(function () {
    Route::get('/dashboard', 'render')->name('dashboard');
});

Route::controller(RangesController::class)->group(function () {
    Route::get('/dashboard/ranges', 'render')->name('ranges');
    Route::post('/dashboard/ranges/add', 'add')->name('ranges-add');
    Route::post('/dashboard/ranges/update', 'update')->name('ranges-update');
    Route::post('/dashboard/ranges/updateStatus/{id}/{currentStatus}', 'updateStatus')->name('ranges-updateStatus');
    Route::delete('/dashboard/ranges/delete/{id}', 'delete')->name('ranges-delete');
    Route::post('/dashboard/ranges/ajaxrequest/{id}', 'ajaxrequest')->name('ranges-ajaxrequest');
});

Route::controller(ProductController::class)->group(function () {
    Route::get('/dashboard/product/form/{id?}', 'render')->name('product-form');
    Route::post('/dashboard/product/add', 'add')->name('product-add');
    Route::post('/dashboard/product/update/{id?}', 'update')->name('product-update');
    Route::post('/dashboard/product/updateStatus/{id}/{currentStatus}', 'updateStatus')->name('product-updateStatus');
    Route::delete('/dashboard/product/delete/{id}', 'delete')->name('product-delete');
    Route::post('/dashboard/product/ajaxrequest/{id?}', 'ajaxrequest')->name('product-ajaxrequest');
});
Route::controller(ProductsController::class)->group(function () {
    Route::get('/dashboard/products', 'render')->name('products');
    Route::post('/dashboard/products/upload', 'upload')->name('products-upload');
    Route::delete('/dashboard/products/delete', 'delete')->name('products-delete');
});

Route::controller(SettingsController::class)->group(function () {
    Route::get('/dashboard/parametres', 'render')->name('settings');
    Route::post('/dashboard/parametres/currency/update', 'updateCurrency')->name('settings-currency-update');
});

Route::controller(VolumesController::class)->group(function () {
    Route::post('/dashboard/volumes/add', 'add')->name('volumes-add');
    Route::post('/dashboard/volumes/update', 'update')->name('volumes-update');
    Route::delete('/dashboard/volumes/delete/{id}', 'delete')->name('volumes-delete');
    Route::post('/dashboard/volumes/ajaxrequest/{id}', 'ajaxrequest')->name('volumes-ajaxrequest');
});

Route::controller(NicotineLevelsController::class)->group(function () {
    Route::post('/dashboard/nicotine-levels/add', 'add')->name('nicotineLevels-add');
    Route::post('/dashboard/nicotine-levels/update', 'update')->name('nicotineLevels-update');
    Route::delete('/dashboard/nicotine-levels/delete/{id}', 'delete')->name('nicotineLevels-delete');
    Route::post('/dashboard/nicotine-levels/ajaxrequest/{id}', 'ajaxrequest')->name('nicotineLevels-ajaxrequest');
});

Route::controller(ProductTypesController::class)->group(function () {
    Route::post('/dashboard/product-types/add', 'add')->name('productTypes-add');
    Route::post('/dashboard/product-types/update', 'update')->name('productTypes-update');
    Route::delete('/dashboard/product-types/delete/{id}', 'delete')->name('productTypes-delete');
    Route::post('/dashboard/product-types/ajaxrequest/{id}', 'ajaxrequest')->name('productTypes-ajaxrequest');
});

Route::controller(ProductsFormatsController::class)->group(function () {
    Route::get('/dashboard/products-formats', 'render')->name('productsFormats');
    Route::post('/dashboard/products-formats/add', 'add')->name('productsFormats-add');
    Route::post('/dashboard/productd-formats/update', 'update')->name('productsFormats-update');
    Route::post('/dashboard/productd-formats/updateStatus/{id}/{currentStatus}', 'updateStatus')->name('productsFormats-updateStatus');
    Route::delete('/dashboard/products-formats/delete/{id}', 'delete')->name('productsFormats-delete');
    Route::post('/dashboard/products-formats/ajaxrequest/{id}', 'ajaxrequest')->name('productsFormats-ajaxrequest');
});
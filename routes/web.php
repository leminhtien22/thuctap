<?php

use App\Http\Controllers\BookingTicketController;
use App\Http\Controllers\CollectionController;
use App\Http\Controllers\ExhibitionController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\Admin\SiteSettingController;
use App\Http\Middleware\IsAdmin;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;



use App\Http\Controllers\ImageController;
use App\Http\Controllers\Client\CollectionController as ClientCollectionController;
use App\Http\Controllers\Client\ExhibitionController as ClientExhibitionController;
use App\Http\Controllers\Client\PostController as ClientPostController;
use App\Http\Controllers\Client\CartController as ClientCartController;
use App\Http\Controllers\Client\OrderController as ClientOrderController;
use App\Http\Controllers\Client\UserController as ClientUserController;
use App\Http\Controllers\Client\ShopController as ClientShopController;
use App\Http\Controllers\Client\TourBookingController;
Auth::routes();

Route::get('/', [HomeController::class, 'index'])->name('home');


//GIAODIEN
Route::prefix('collection')->group(function () {
  Route::get('/', [ClientCollectionController::class, 'index'])->name('client.collection');
  Route::get('/{id}', [ClientCollectionController::class, 'details'])->name('client.collection.details');
});

Route::prefix('shop')->group(function () {
  Route::get('/', [ClientShopController::class, 'index'])->name('client.shop');
  Route::get('/{id}', [ClientShopController::class, 'details'])->name('client.shop.details');
}); 
Route::prefix('post')->group(function () {
  Route::get('/', [ClientPostController::class, 'index'])->name('client.post');
  Route::get('/{id}', [ClientPostController::class, 'details'])->name('client.post.details');
  Route::get('/history/view', [ClientPostController::class, 'history'])->name('client.post.history')->middleware('auth');
  Route::post('/{id}/view', [ClientPostController::class, 'increaseView'])->name('post.increase.view');
});
Route::prefix('exhibition')->group(function () {
  Route::get('/', [ClientExhibitionController::class, 'index'])->name('client.exhibition');
  Route::get('/{id}', [ClientExhibitionController::class, 'details'])->name('client.exhibition.details');

  Route::get('/booking/{id}', [ClientExhibitionController::class, 'showBooking'])->name('client.exhibition.booking')->middleware('auth');
  Route::post('/booking/{id}', [ClientExhibitionController::class, 'booking'])->name('client.exhibition.booking')->middleware('auth');
  Route::get('/ticket/history', [ClientExhibitionController::class, 'ticketHistory'])->name('client.exhibition.ticket.history')->middleware('auth');
});
Route::prefix('cart')->group(function () {
  Route::get('/', [ClientCartController::class, 'index'])->name('cart');
  Route::get('/add/{id}', [ClientCartController::class, 'addToCart'])->name('cart.add');
  Route::get('/remove/{id}', [ClientCartController::class, 'removeFromCart'])->name('cart.remove');
});
Route::middleware('auth')->prefix('order')->group(function () {
  Route::get('/history', [ClientOrderController::class, 'history'])->name('order.history');
  Route::get('/create', [ClientOrderController::class, 'showBooking'])->name('order.create');
  Route::post('/create', [ClientOrderController::class, 'create'])->name('order.create');
  Route::get('/{id}', [ClientOrderController::class, 'details'])->name('order.details');
});
// Route cho đặt tour
Route::middleware('auth')->group(function () {
  Route::get('/tour/book', [TourBookingController::class, 'create'])->name('tour.create');
  Route::post('/tour/book', [TourBookingController::class, 'store'])->name('tour.store');
});
//ADMIN
Route::middleware(['auth', IsAdmin::class])->prefix('admin')->group(function () {
  Route::prefix('post')->group(function () {
    Route::get('/', [PostController::class, 'index'])->name('admin.post');

    Route::get('/trash', [PostController::class, 'showTrash'])->name('admin.post.trash');

    Route::get('/create', [PostController::class, 'showCreate'])->name('admin.post.create');
    Route::post('/create', [PostController::class, 'store'])->name('admin.post.create');

    Route::get('/edit/{id}', [PostController::class, 'showEdit'])->name('admin.post.edit');
    Route::post('/edit/{id}', [PostController::class, 'update'])->name('admin.post.edit');

    Route::get('/delete/{id}', [PostController::class, 'showDelete'])->name('admin.post.delete');
    Route::post('/delete/{id}', [PostController::class, 'delete'])->name('admin.post.delete');

    Route::get('/restore/{id}', [PostController::class, 'showRestore'])->name('admin.post.restore');
    Route::post('/restore/{id}', [PostController::class, 'restore'])->name('admin.post.restore');
  });
  

  Route::prefix('/')->name('admin.')->group(function () {
    Route::get('/settings', [SiteSettingController::class, 'index'])->name('settings');
    Route::post('/settings', [SiteSettingController::class, 'update'])->name('settings.update');
});


  Route::prefix('order')->group(function () {
    Route::get('/', [OrderController::class, 'index'])->name('admin.order');

    Route::get('/create', [OrderController::class, 'showCreate'])->name('admin.order.create');
    Route::post('/create', [OrderController::class, 'create'])->name('admin.order.create');

    Route::get('/edit/{id}', [OrderController::class, 'showEdit'])->name('admin.order.edit');
    Route::post('/edit/{id}', [OrderController::class, 'edit'])->name('admin.order.edit');

    Route::get('/delete/{id}', [OrderController::class, 'showDelete'])->name('admin.order.delete');
    Route::post('/delete/{id}', [OrderController::class, 'delete'])->name('admin.order.delete');
  });

  Route::prefix('user')->group(function () {
    Route::get('/', [UserController::class, 'index'])->name('admin.user');
    Route::get('/create', [UserController::class, 'create'])->name('admin.user.create');
    Route::post('/create', [UserController::class, 'createUser'])->name('admin.user.create');

    Route::get('/edit/{id}', [UserController::class, 'edit'])->name('admin.user.edit');
    Route::post('/edit/{id}', [UserController::class, 'editUser'])->name('admin.user.edit');

    Route::get('/ban/{id}', [UserController::class, 'ban'])->name('admin.user.ban');
    Route::post('/ban/{id}', [UserController::class, 'banUser'])->name('admin.user.ban');

    Route::get('/unlock/{id}', [UserController::class, 'unBan'])->name('admin.user.unBan');
    Route::post('/unlock/{id}', [UserController::class, 'unBanUser'])->name('admin.user.unBan');
  });

  Route::prefix('exhibition')->group(function () {
    Route::get('/', [ExhibitionController::class, 'index'])->name('admin.exhibition');

    Route::get('/create', [ExhibitionController::class, 'showCreate'])->name('admin.exhibition.create');
    Route::post('/create', [ExhibitionController::class, 'create'])->name('admin.exhibition.create');

    Route::get('/edit/{id}', [ExhibitionController::class, 'showEdit'])->name('admin.exhibition.edit');
    Route::post('/edit/{id}', [ExhibitionController::class, 'update'])->name('admin.exhibition.edit');

    Route::get('/delete/{id}', [ExhibitionController::class, 'showDelete'])->name('admin.exhibition.delete');
    Route::post('/delete/{id}', [ExhibitionController::class, 'delete'])->name('admin.exhibition.delete');

    Route::get('/trash', [ExhibitionController::class, 'showTrash'])->name('admin.exhibition.trash');

    Route::post('/restore/{id}', [ExhibitionController::class, 'restore'])->name('admin.exhibition.restore');
  });

  Route::prefix('ticket')->group(function () {
    Route::get('/', [BookingTicketController::class, 'index'])->name('admin.ticket');

    Route::get('/create', [BookingTicketController::class, 'showCreate'])->name('admin.ticket.create');
    Route::post('/create', [BookingTicketController::class, 'create'])->name('admin.ticket.create');

    Route::get('/edit/{id}', [BookingTicketController::class, 'showEdit'])->name('admin.ticket.edit');
    Route::post('/edit/{id}', [BookingTicketController::class, 'update'])->name('admin.ticket.edit');

    Route::get('/delete/{id}', [BookingTicketController::class, 'showDelete'])->name('admin.ticket.delete');
    Route::post('/delete/{id}', [BookingTicketController::class, 'delete'])->name('admin.ticket.delete');
  });


  Route::prefix('collection')->group(function () {
    Route::get('/', [CollectionController::class, 'index'])->name('admin.collection');

    Route::get('/create', [CollectionController::class, 'showCreate'])->name('admin.collection.create');
    Route::post('/create', [CollectionController::class, 'create'])->name('admin.collection.create');

    Route::get('/edit/{id}', [CollectionController::class, 'showEdit'])->name('admin.collection.edit');
    Route::post('/edit/{id}', [CollectionController::class, 'update'])->name('admin.collection.edit');

    Route::get('/delete/{id}', [CollectionController::class, 'showDelete'])->name('admin.collection.delete');
    Route::post('/delete/{id}', [CollectionController::class, 'delete'])->name('admin.collection.delete');
  });
  
  Route::prefix('shop')->group(function () {
    Route::get('/', [ShopController::class, 'index'])->name('admin.shop');

    Route::get('/create', [ShopController::class, 'showCreate'])->name('admin.shop.create');
    Route::post('/create', [ShopController::class, 'create'])->name('admin.shop.create');

    Route::get('/edit/{id}', [ShopController::class, 'showEdit'])->name('admin.shop.edit');
    Route::post('/edit/{id}', [ShopController::class, 'update'])->name('admin.shop.edit');

    Route::get('/delete/{id}', [ShopController::class, 'showDelete'])->name('admin.shop.delete');
    Route::post('/delete/{id}', [ShopController::class, 'delete'])->name('admin.shop.delete');
});


  Route::get('/photo', [ImageController::class, 'index'])->name('admin.photo');
  Route::get('/photo/create', [ImageController::class, 'create'])->name('admin.photo.create');
  Route::post('/photo', [ImageController::class, 'store'])->name('admin.photo.store');
  Route::get('/photo/{id}/edit', [ImageController::class, 'edit'])->name('admin.photo.edit');
  Route::put('/photo/{id}', [ImageController::class, 'update'])->name('admin.photo.update');
  Route::delete('/photo/{id}', [ImageController::class, 'destroy'])->name('admin.photo.delete');




  

 



//   Route::middleware('auth')->group(function () {
//     Route::get('/setting', [ClientUserController::class, 'setting'])->name('client.user.setting');
//     Route::post('/setting', [ClientUserController::class, 'updateSetting'])->name('client.user.setting');
// });

});
Route::middleware('auth')->prefix('admin')->group(function () {
  Route::get('/setting', [ClientUserController::class, 'setting'])->name('client.user.setting');
  Route::post('/setting', [ClientUserController::class, 'updateSetting'])->name('client.user.setting');
});

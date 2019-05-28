<?php

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

Auth::routes();

Route::get('/', function () {
    return view('welcome');
});

Route::get('/client/login','ClientController@show_client_login');
// Route::post('/client/login','ClientController@client_login');

//Authentication
Route::get('/', 'Auth\LoginController@login');

Route::group(['middleware' => ['auth']], function () {
//    Route::get('/home', 'MainController@home');
    Route::get('/logout', '\App\Http\Controllers\Auth\LoginController@logout');

});


//Only Admin
Route::group(['middleware' => ['role:admin']], function () {

    Route::get('/home', 'MainController@home')->name('dashboard');

    //Privileges
    Route::get('/privileges', 'PrivilegesController@createPrivileges');
    Route::get('/assign_privileges', 'PrivilegesController@assignPrivileges');
    Route::get('/order/list','OrderController@get_all_orders')->name('order.list');
});

//Admin & Distributor
Route::group(['middleware' => ['role:admin|distributor']], function () {

    //Account
    Route::get('/account', 'AccountController@index')->name('account');
    Route::put('/account/{id}/update', 'AccountController@update')->name('account.update');
    Route::get('/order/list','OrderController@get_all_orders')->name('order.list');
    Route::get('/order/detail/{id}','OrderController@get_order')->name('order.detail');

    //User
    Route::get('/users', 'UsersController@index')->name('users.list');
    Route::get('/user/add', 'UsersController@add')->name('user.add');
    Route::post('/user/create', 'UsersController@create')->name('user.create');
    Route::delete('/user/{id}/delete', 'UsersController@delete')->name('user.delete');
    Route::get('/user/{id}/edit', 'UsersController@edit')->name('user.edit');
    Route::put('/user/{id}/update', 'UsersController@update')->name('user.update');

    //Category
    Route::get('/category/add', 'CategoryController@add')->name('category.add');
    Route::post('/category/create', 'CategoryController@create')->name('category.create');
    Route::get('/category/{id}/edit', 'CategoryController@edit')->name('category.edit');
    Route::put('/category/{id}/update', 'CategoryController@update')->name('category.update');
    Route::delete('/category/{id}/delete', 'CategoryController@delete')->name('category.delete');

//    Color
    Route::get('/color/add', 'ColorController@add')->name('color.add');
    Route::post('/color/create', 'ColorController@create')->name('color.create');
    Route::get('/color/{id}/edit', 'ColorController@edit')->name('color.edit');
    Route::put('/color/{id}/update', 'ColorController@update')->name('color.update');
    Route::delete('/color/{id}/delete', 'ColorController@delete')->name('color.delete');

    //Item Types
    Route::get('/item_type/add', 'ItemTypeController@add')->name('item.add');
    Route::post('/item_type/create', 'ItemTypeController@create')->name('item.create');
    Route::delete('/item_type/{id}/delete', 'ItemTypeController@delete')->name('item.delete');
    Route::get('/item_type/{id}/edit', 'ItemTypeController@edit')->name('item.edit');
    Route::put('/item_type/{id}/update', 'ItemTypeController@update')->name('item.update');

    //Products
    Route::get('/product/add', 'ProductController@add')->name('product.add');
    Route::post('/product/create', 'ProductController@create')->name('product.create');
    Route::delete('/product/{id}/delete', 'ProductController@delete')->name('product.delete');
    Route::get('/product/{id}/edit', 'ProductController@edit')->name('product.edit');
    Route::put('/product/{id}/update', 'ProductController@update')->name('product.update');
});
Route::group(['middleware' => ['role:client']], function () {
    //Clients
    Route::get('/clients', 'ClientController@index')->name('clients');
    Route::get('/client/product/{id}', 'ClientController@productdetails')->name('productdetails');
    Route::post('/order/add','OrderController@add')->name('order.add');
    Route::post('/order/create','OrderController@create')->name('order.create');

    Route::post('/client/create', 'ClientController@create')->name('client.create');
    Route::delete('/client/{id}/delete', 'ClientController@delete')->name('client.delete');
    Route::get('/client/{id}/edit', 'ClientController@edit')->name('client.edit');
    Route::put('/client/{id}/update', 'ClientController@update')->name('client.update');

});

//Admin, Distributor & Warehouse Manager
Route::group(['middleware' => ['role:warehouse_manager|distributor|admin']], function () {

    //Account
    Route::get('/account', 'AccountController@index')->name('account');

    //Category
    Route::get('/categories', 'CategoryController@index')->name('category.list');

    //Colors
    Route::get('/colors', 'ColorController@index')->name('color.list');

    //Item Types
    Route::get('/item_types', 'ItemTypeController@index')->name('items.list');

    //Products
    Route::get('/products', 'ProductController@index')->name('products.list');

    Route::get('/order/list','OrderController@get_all_orders')->name('order.list');
    Route::put('/order/edit/{id}','OrderController@update')->name('order.edit');
});
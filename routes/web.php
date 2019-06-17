<?php

Route::resource('/dashboard', 'DashboardController');
Route::resource('/', 'DashboardController');
Route::resource('stock', 'StockController');
Route::resource('sale', 'SaleController');

// Datatables
Route::get('derive/datatables', 'DeriveController@datatables')->name('derives.datatables');
Route::get('product/datatables', 'ProductController@datatables')->name('products.datatables');
Route::get('product/multiple/create', 'ProductController@createMultiple')->name('product.multiple.create');
Route::get('derive/low-stock', 'DeriveController@lowStock')->name('derive.low-stock');
Route::get('filter/show-all','FilterController@show_all')->name('filter.show-all');
Route::get('category/show-all','CategoryController@show_all')->name('category.show-all');
Route::get('movement', 'MovementController@index')->name('movement.index');
//Route::get('derive', ['as' => 'derive.create', 'uses' => 'DeriveController@create']);

// post route
Route::post('product/multiple', 'ProductController@storeMultiple')->name('product.multiple.store');
Route::put('movement/{movement}', 'MovementController@update')->name('movement.update');
Route::resource('product' , 'ProductController');
Route::resource('filter' , 'FilterController');
Route::resource('category' , 'CategoryController');
Route::resource('brand', 'BrandController');
Route::resource('derive', 'DeriveController');
Route::resource('log', 'LogController');

// fallback
Route::fallback(function () {
    return redirect()->route('dashboard.index');
});


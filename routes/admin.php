<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
|
| 
| 
| 
|
*/

Route::get('/accounts/reports/balance-sheet', 'AccountReportController@balanceSheet')->name('accounts.reports.balance-sheet');
Route::get('/accounts/reports/profit-loss', 'AccountReportController@profitLoss')->name('accounts.reports.profit-loss');

Route::resource('/accounts', 'AccountController');

Route::get('/journals/entries', 'JournalController@entries')->name('journals.entries');

Route::resource('/journals', 'JournalController');

Route::resource('/items', 'ItemController');

Route::prefix('purchases')->name('purchases.')->group(function () {

    Route::resource('/vendors', 'VendorController');
    Route::resource('/orders', 'PurchaseOrderController');
    
    Route::prefix('vendors/{vendor}')->name('vendors.')->group(function () {
        
        Route::resource('/payments', 'VendorPaymentController');
    });

    Route::resource('/orders', 'PurchaseOrderController');
    Route::resource('/invoices', 'PurchaseInvoiceController');
    Route::resource('/payments', 'PurchasePaymentController');
});

Route::prefix('sales')->name('sales.')->group(function () {

    Route::resource('/customers', 'CustomerController');

    Route::prefix('customers/{customer}')->name('customers.')->group(function () {
        
        Route::resource('/payments', 'CustomerPaymentController');
    });


    Route::resource('/quotations', 'SalesQuotationController');

    Route::prefix('quotations/{quotation}')->name('quotations.')->group(function () {
        
        Route::get('/orders/create', 'SalesOrderController@createFromQuotation');
    });


    Route::resource('/orders', 'SalesOrderController');
    Route::resource('/invoices', 'SalesInvoiceController');

    Route::prefix('orders/{order}')->name('orders.')->group(function () {
        
        Route::resource('/deliveries', 'SalesOrderDeliveryController');
    });
});

Route::get('/', 'HomeController@index')->name('dashboard');

Route::resource('/users', 'UserController');

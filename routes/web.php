<?php

use Illuminate\Support\Facades\Route;

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


Route::get('/', function () {
	
    return redirect('/products');
});
Route::post('products/fetch', 'productsController@fetch')->name('products.fetch');
Route::post('products/updatetable', 'productsController@updatetable')->name('products.updatetable');
Route::post('suppliers/updatetable', 'suppliersController@updatetable')->name('suppliers.updatetable');
Route::post('category/updatetable', 'categoryController@updatetable')->name('category.updatetable');
Route::post('clients/fetch', 'clientsController@fetch')->name('clients.fetch');
Route::get('clients/setCurrentClient', 'clientsController@setCurrentClient')->name('clients.setCurrentClient');
Route::post('clients/updatetable', 'clientsController@updatetable')->name('clients.updatetable');
Route::post('cotation/processcotation/{cotation}', 'cotationController@processcotation')->name('cotation.processcotation');
Route::get('report/getstattable/{reportpurpose}/{reportfrom}/{reportto}/{moremonth}/{idprod}', 'reportController@getstattable')->name('report.getstattable');
Route::get('report/getstats/{reportpurpose}', 'reportController@getstats')->name('report.getstats');
Route::get('report/printreport', 'reportController@printreport')->name('report.printreport');
Route::get('cotation/generatepdf', 'cotationController@generatepdf')->name('cotation.generatepdf');
Route::get('cotation/processsell', 'cotationController@processsell')->name('cotation.processsell');
Route::get('loan/showlogs/{loan}','loanController@showlogs')->name('loan.showlogs');
Route::get('loan/generatepdf', 'loanController@generatepdf')->name('loan.generatepdf');
Route::get('loan/pay/{loan}/{second}','loanController@pay')->name('loan.pay');
Route::get('devolution/getdevolutiontable', 'devolutionController@getdevolutiontable')->name('devolution.getdevolutiontable');
Route::get('devolution/generatepdf', 'devolutionController@generatepdf')->name('devolution.generatepdf');
Route::get('devolution/findcart/{reference}/{state}','devolutionController@findcart')->name('devolution.findcart');
Route::get('devolution/takeback/{idsells}/{idproduct}/{unitprice}/{qty}','devolutionController@takeback')->name('devolution.takeback');
Route::get('devolution/takebackall/{idsells}/{idproduct}/{unitprice}','devolutionController@takebackall')->name('devolution.takebackall');
Route::resource('devolution','devolutionController');
Route::resource('loan','loanController');
Route::resource('products','productsController');
Route::resource('clients','clientsController');
Route::resource('cotation','cotationController');
Route::resource('suppliers','suppliersController');
Route::resource('category','categoryController');
Route::resource('report','reportController');
Route::get('users/useraccess','usersController@useraccess')->name('users.useraccess');
Route::post('users/updatetable', 'usersController@updatetable')->name('users.updatetable');
Route::get('users/changelan/{newlang}','usersController@changelan')->name('users.changelan');
Route::get('users/login','usersController@login')->name('users.login');
Route::get('users/logout','usersController@logout')->name('users.logout');
Route::resource('users','usersController');
Route::get('notification/getnotification','notificationController@getnotification')->name('notification.getnotification');
Route::resource('notification','notificationController');
Route::post('entries/updatetable', 'entriesController@updatetable')->name('entries.updatetable');
Route::resource('entries','entriesController');
Route::post('sells/updatetable', 'sellsController@updatetable')->name('sells.updatetable');
Route::get('sells/updatetotal', 'sellsController@updatetotal')->name('sells.updatetotal');
Route::get('sells/addrow/{sell}', 'sellsController@addrow')->name('sells.addrow');
Route::get('sells/computechanges/{sell}', 'sellsController@computechanges')->name('sells.computechanges');
Route::get('sells/removerow/{sell}', 'sellsController@removerow')->name('sells.removerow');
Route::get('sells/updatequantity/{sell}/{seli}', 'sellsController@updatequantity')->name('sells.updaterow');
Route::get('sells/generatepdf/{sells}', 'sellsController@generatepdf')->name('sells.generatepdf');
Route::get('sells/processsell', 'sellsController@processsell')->name('sells.processsell');
Route::resource('sells','sellsController');
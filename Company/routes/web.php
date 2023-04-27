<?php

use App\Http\Controllers\CompanyController;
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
    return view('auth.login');
});
Route::get('refresh-csrf', function(){
    return csrf_token();
});
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

Route::group(['middleware' => 'auth'], function (){
    Route::group(['middleware' => ['can:company']], function () {
        //顧客管理
        Route::get('client-manage', [CompanyController::class, 'manageClient'])->name('company.client-manage');
        Route::get('client-add', [CompanyController::class, 'addClient'])->name('company.client-add');
        Route::get('client-edit/{id}', [CompanyController::class, 'editClient'])->name('company.client-edit');
        Route::post('client-save', [CompanyController::class, 'saveClient'])->name('company.client-save');
        Route::post('client-change-status', [CompanyController::class, 'changeStatusClient'])->name('company.client-change-status');
        Route::post('client-delete', [CompanyController::class, 'deleteClient'])->name('company.client-delete');
        Route::post('client-table', [CompanyController::class, 'tableClient'])->name('company.client-table');
        //顧客別経費一覧機能
        Route::get('client-cost/{id}', [CompanyController::class, 'costClient'])->name('company.client-cost');
        Route::post('client-cost-table', [CompanyController::class, 'tableClientCost'])->name('company.client-cost-table');
        Route::get('client-cost-edit/{id}', [CompanyController::class, 'editClientCost'])->name('company.client-cost-edit');
        Route::post('client-cost-save', [CompanyController::class, 'saveClientCost'])->name('company.client-cost-save');
        Route::post('client-cost-delete', [CompanyController::class, 'deleteClientCost'])->name('company.client-cost-delete');
        Route::post('client-cost-export-excel', [CompanyController::class, 'clientCostExportExcel'])->name('company.client-cost-export-excel');
        Route::post('cost-export-csv', [CompanyController::class, 'costExportCSV'])->name('company.cost-export-csv');
        Route::get('client-cost-export-pdf/{id}', [CompanyController::class, 'clientCostExportPDF'])->name('company.client-cost-export-pdf');

        //勘定項目管理
        Route::get('account-manage', [CompanyController::class, 'manageAccount'])->name('company.account-manage');
        Route::get('account-add', [CompanyController::class, 'addAccount'])->name('company.account-add');
        Route::get('account-edit/{id}', [CompanyController::class, 'editAccount'])->name('company.account-edit');
        Route::post('account-save', [CompanyController::class, 'saveAccount'])->name('company.account-save');
        Route::post('account-delete', [CompanyController::class, 'deleteAccount'])->name('company.account-delete');
        Route::post('account-table', [CompanyController::class, 'tableAccount'])->name('company.account-table');

        Route::post('change-account-type', [CompanyController::class, 'changeAccountType'])->name('company.change-account-type');

        //マイページ
        Route::get('my-page', [CompanyController::class, 'myPage'])->name('company.my-page');
        Route::post('edit-info', [CompanyController::class, 'editInfo'])->name('company.edit-info');
    });
});
require __DIR__.'/auth.php';

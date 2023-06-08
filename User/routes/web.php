<?php

use App\Http\Controllers\UserController;
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
    Route::group(['middleware' => ['can:client']], function () {
        //顧客別経費一覧機能
        Route::get('cost-manage', [UserController::class, 'costManage'])->name('client.cost-manage');
        Route::post('cost-table', [UserController::class, 'tableCost'])->name('client.cost-table');
        Route::get('cost-edit/{id}', [UserController::class, 'editCost'])->name('client.cost-edit');
        Route::post('cost-save', [UserController::class, 'saveCost'])->name('client.cost-save');
        Route::post('cost-delete', [UserController::class, 'deleteCost'])->name('client.cost-delete');
        Route::post('cost-export-excel', [UserController::class, 'costExportExcel'])->name('client.cost-export-excel');
        Route::post('cost-export-csv', [UserController::class, 'costExportCSV'])->name('client.cost-export-csv');
        Route::get('cost-export-pdf/{id}', [UserController::class, 'costExportPDF'])->name('client.cost-export-pdf');

        //会計ソフト
        Route::get('software-add', [UserController::class, 'addSoftware'])->name('client.software-add');
        Route::post('cost-export-csv-software', [UserController::class, 'costExportCSVSoftware'])->name('client.cost-export-csv-software');
        Route::get('software-history', [UserController::class, 'historySoftware'])->name('client.software-history');
        Route::post('software-history-table', [UserController::class, 'historySoftwareTable'])->name('client.software-history-table');
        Route::post('software-history-delete', [UserController::class, 'historySoftwareDelete'])->name('client.software-history-delete');

        //勘定項目管理
        Route::get('account-manage', [UserController::class, 'manageAccount'])->name('client.account-manage');
        Route::get('account-add', [UserController::class, 'addAccount'])->name('client.account-add');
        Route::get('account-edit/{id}', [UserController::class, 'editAccount'])->name('client.account-edit');
        Route::post('account-save', [UserController::class, 'saveAccount'])->name('client.account-save');
        Route::post('account-delete', [UserController::class, 'deleteAccount'])->name('client.account-delete');
        Route::post('account-table', [UserController::class, 'tableAccount'])->name('client.account-table');

        Route::post('change-account-type', [UserController::class, 'changeAccountType'])->name('client.change-account-type');

        //マイページ
        Route::get('my-page', [UserController::class, 'myPage'])->name('client.my-page');
        Route::post('edit-info', [UserController::class, 'editInfo'])->name('client.edit-info');
    });
});
require __DIR__.'/auth.php';

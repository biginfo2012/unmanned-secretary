<?php

use App\Http\Controllers\ManagerController;
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
    Route::group(['middleware' => ['can:super']], function () {
        //ユーザ管理
        Route::get('company-manage', [ManagerController::class, 'manageCompany'])->name('manager.company-manage');
        Route::get('company-add', [ManagerController::class, 'addCompany'])->name('manager.company-add');
        Route::get('company-edit/{id}', [ManagerController::class, 'editCompany'])->name('manager.company-edit');
        Route::post('company-save', [ManagerController::class, 'saveCompany'])->name('manager.company-save');
        Route::post('company-change-status', [ManagerController::class, 'changeStatusCompany'])->name('manager.company-change-status');
        Route::post('company-delete', [ManagerController::class, 'deleteCompany'])->name('manager.company-delete');
        Route::post('company-table', [ManagerController::class, 'tableCompany'])->name('manager.company-table');

        //勘定項目管理
        Route::get('account-manage', [ManagerController::class, 'manageAccount'])->name('manager.account-manage');
        Route::get('account-add', [ManagerController::class, 'addAccount'])->name('manager.account-add');
        Route::get('account-edit/{id}', [ManagerController::class, 'editAccount'])->name('manager.account-edit');
        Route::post('account-save', [ManagerController::class, 'saveAccount'])->name('manager.account-save');
        Route::post('account-delete', [ManagerController::class, 'deleteAccount'])->name('manager.account-delete');
        Route::post('account-table', [ManagerController::class, 'tableAccount'])->name('manager.account-table');

        Route::post('change-account-type', [ManagerController::class, 'changeAccountType'])->name('manager.change-account-type');
    });
});
require __DIR__.'/auth.php';

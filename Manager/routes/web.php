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
        Route::post('company-delete', [ManagerController::class, 'deleteCompany'])->name('manager.company-delete');
        Route::post('company-table', [ManagerController::class, 'tableCompany'])->name('manager.company-table');

        //勘定項目管理
        Route::get('client-manage', [ManagerController::class, 'manageClient'])->name('manager.client-manage');
        Route::get('client-add', [ManagerController::class, 'addClient'])->name('manager.client-add');
        Route::get('client-edit/{id}', [ManagerController::class, 'editClient'])->name('manager.client-edit');
        Route::post('client-save', [ManagerController::class, 'saveClient'])->name('manager.client-save');
        Route::post('client-delete', [ManagerController::class, 'deleteClient'])->name('manager.client-delete');
        Route::post('client-table', [ManagerController::class, 'tableClient'])->name('manager.client-table');
    });
});
require __DIR__.'/auth.php';

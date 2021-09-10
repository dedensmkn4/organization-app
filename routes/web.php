<?php

use App\Http\Controllers\ManagerController;
use App\Http\Controllers\OrganizationController;
use App\Http\Controllers\PersonController;
use Illuminate\Support\Facades\Route;
use App\Constant\ApiPath;
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
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

Route::group(['prefix' => ApiPath::ORGANIZATION_PATH,'middleware' => ['auth']], function(){
    Route::get(ApiPath::INDEX, [OrganizationController::class, 'index'])->name('org.index');
    Route::get(ApiPath::CREATE, [OrganizationController::class, 'create'])->name('org.create')->middleware(['admin']);
    Route::post(ApiPath::CREATE, [OrganizationController::class, 'store'])->name('org.store')->middleware(['admin']);
    Route::get(ApiPath::DETAIL, [OrganizationController::class, 'detail'])->name('org.detail');
    Route::post(ApiPath::DETAIL,[OrganizationController::class, 'update'])->name('org.update');
    Route::get(ApiPath::DELETE,[OrganizationController::class, 'delete'])->name('org.delete');
    Route::get(ApiPath::ASSIGN_MANAGER,[OrganizationController::class, 'getManager'])->middleware(['admin'])->name('org.add-manager');
    Route::post(ApiPath::ASSIGN_MANAGER,[OrganizationController::class, 'storeManager'])->middleware(['admin'])->name('org.assign-manager');
});


Route::group(['prefix' => ApiPath::MANAGER_PATH,'middleware' => ['auth','admin']], function(){
    Route::get(ApiPath::INDEX,[ManagerController::class, 'index'])->name('manager.index');
    Route::get(ApiPath::CREATE,[ManagerController::class, 'create'])->name('manager.create');
    Route::post(ApiPath::CREATE, [ManagerController::class, 'store'])->name('manager.store');
    Route::get(ApiPath::DETAIL,[ManagerController::class, 'detail'])->name('manager.detail');
    Route::post(ApiPath::DETAIL,[ManagerController::class, 'update'])->name('manager.update');
});

Route::group(['prefix' => ApiPath::PERSON_PATH,'middleware' => ['auth','manager']], function(){
    Route::get(ApiPath::ORG_ID.ApiPath::CREATE,[PersonController::class, 'create'])->name('pic.create');
    Route::post(ApiPath::ORG_ID.ApiPath::CREATE, [PersonController::class, 'store'])->name('pic.store');
    Route::get(ApiPath::ORG_ID.ApiPath::DETAIL,[PersonController::class, 'detail'])->name('pic.detail');
    Route::post(ApiPath::ORG_ID.ApiPath::DETAIL,[PersonController::class, 'update'])->name('pic.update');
    Route::get(ApiPath::ORG_ID.ApiPath::DELETE,[PersonController::class, 'delete'])->name('pic.delete');
});
require __DIR__.'/auth.php';

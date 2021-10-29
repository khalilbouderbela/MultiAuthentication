<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ManagerController;
use App\Http\Controllers\ProjectController;
use Illuminate\Support\Facades\Auth;
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

Route::middleware(['middleware'=>'PreventBackHistory'])->group(function () {
    Auth::routes();
});

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::group(['prefix'=>'admin', 'middleware'=>['isAdmin','auth','PreventBackHistory']], function(){
    Route::get('dashboard',[AdminController::class,'index'])->name('admin.dashboard');
    Route::get('profile',[AdminController::class,'profile'])->name('admin.profile');
    Route::get('settings',[AdminController::class,'settings'])->name('admin.settings');

    Route::post('change-password',[AdminController::class,'changePassword'])->name('adminChangePassword');
    Route::get('edit-user/{id}',[UserController::class,'edit'])->name('adminEditUser');;
    Route::put('update-user/{id}',[UserController::class,'update'])->name('update-user');
    Route::get('delete/{id}',[UserController::class,'delete'])->name('delete-user');
    Route::get('deleteProject/{id}',[ProjectController::class,'deleteByAdmin'])->name('delete-project-admin');
    Route::post('update-project/{project_id}',[ProjectController::class,'update'])->name('userUpdateProjectAdmin');

    
    Route::get('update-project-view/{project_id}',[ProjectController::class,'viewUpdateAdmin'])->name('project.ViewUpdateAdmin');
});

Route::group(['prefix'=>'user', 'middleware'=>['isUser','auth','PreventBackHistory']], function(){
    Route::get('dashboard',[UserController::class,'index'])->name('user.dashboard');
    Route::get('profile',[UserController::class,'profile'])->name('user.profile');
    Route::get('update-project/{project_id}',[ProjectController::class,'viewUpdateUser'])->name('project.ViewUpdate');
    Route::post('update-project/{project_id}',[ProjectController::class,'update'])->name('userUpdateProject');
    Route::get('settings',[UserController::class,'settings'])->name('user.settings');

    Route::post('change-password',[UserController::class,'changePassword'])->name('userChangePassword');
    Route::post('add-project',[ProjectController::class,'createProject'])->name('userCreateProject');
    
});

Route::group(['prefix'=>'manager', 'middleware'=>['isManager','auth','PreventBackHistory']], function(){
    Route::get('dashboard',[ManagerController::class,'index'])->name('manager.dashboard');
    Route::get('profile',[ManagerController::class,'profile'])->name('manager.profile');
    Route::get('settings',[ManagerController::class,'settings'])->name('manager.settings');

    Route::post('change-password',[ManagerController::class,'changePassword'])->name('managerChangePassword');;
});

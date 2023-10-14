<?php

use App\Http\Controllers\Dashbord\PermissionController;
use App\Http\Controllers\Dashbord\RoleController;
use App\Http\Controllers\Dashbord\UserController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\StudentController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    // return view('dashboard');
    return view('dashbord.maniDashbord');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

/**
 * -------------------------------------------------
 * ---------------------Dashbord Controller-------------->
 * -------------------------------------------------
 */
Route::middleware(['auth'])->group(function () {
    /**
     * Role Controller
     */
    Route::resource('/roles', RoleController::class);
    Route::post('/attach/{role}', [RoleController::class, 'attachPermissions'])->name('permissions.attach');
    Route::DELETE('/role/{role}/permission/{permission}', [RoleController::class, 'revokPermissions'])->name('permissions.revok');

    /**
     * Permission Controller
     */
    Route::resource('/permissions', PermissionController::class);
    Route::post('/attach/role/{permission}', [PermissionController::class, 'attachRole'])->name('role.attach');
    Route::DELETE('/permission/{permission}/role/{role}/', [PermissionController::class, 'revokRole'])->name('role.revok');

    /**
     * User Controller
     */
    Route::resource('/users', UserController::class);
    Route::post('/user/role/update/{user}', [UserController::class, 'userUpdateRole'])->name('userUpdate.role');

    /**
     * Student Controller
     */
    Route::resource('/students', StudentController::class);

});

require __DIR__.'/auth.php';
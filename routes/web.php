<?php

use App\Http\Controllers\User\ListUserController;
use App\Models\User;
use Inertia\Inertia;
use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Application;

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
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->name('dashboard');


Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard/task', function () {
    return Inertia::render('Task/Index',[
        'users' => User::all()
    ]);
})->name('task.index');


// Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard/userList', function () {
//     return Inertia::render('UserList/Index',[
//         'users' => User::all()
//     ]);
// })->name('userList.index');


// Route::middleware(['auth:sanctum', 'verified'])
//      ->resource('/dashboard/userList', ListUserController::class)
//      ->parameters(['userList' => 'customers']);

     Route::middleware(['auth:sanctum', 'verified'])->prefix('dashboard')->group(function () {

        Route::delete('userList/avatar/delete/{customers}', [ListUserController::class, 'deleteAvatar'])->name('userList.delete');

        Route::resource('userList', ListUserController::class)
        ->parameters(['userList' => 'customers']);

    });

<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\VulnerabilitiesController;
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
    return redirect('/login');
});

Route::get('/dashboard', DashboardController::class)
    ->middleware(['auth'])
    ->name('dashboard');

Route::resource('vulnerabilities', VulnerabilitiesController::class)
    ->middleware(['auth']);

require __DIR__.'/auth.php';

<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AdminLanguageController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TranslateController;
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
	return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
	Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
	Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
	Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// DTLR Custom Routes
Route::get('/translate', [TranslateController::class, 'index'])->name('translate');
Route::get('/languages', [AdminLanguageController::class, 'index'])->name('languages.index');

Route::middleware('auth')->group(function () {
	Route::post('/translate/save', [TranslateController::class, 'save'])->name('translate.save');
	Route::delete('/translate/saved/{savedSentence}', [TranslateController::class, 'destroy'])->name('translate.saved.destroy');
	Route::get('/admin/export', [AdminController::class, 'export'])->name('admin.export');

	Route::prefix('/languages')->name('languages.')->controller(AdminLanguageController::class)->group(function () {
		Route::get('/create', 'create')->name('create');
		Route::post('/', 'store')->name('store');
		Route::get('/{language}/edit', 'edit')->name('edit');
		Route::put('/{language}', 'update')->name('update');
		Route::get('/{language}/clone', 'clone')->name('clone');
		Route::delete('/{language}', 'destroy')->name('destroy');
	});
});

require __DIR__.'/auth.php';

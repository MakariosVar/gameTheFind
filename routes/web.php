<?php

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
Route::get('/tool/migrate', function () {
	Artisan::call('migrate');
});


Route::get('/register', function () {
    return redirect('/');
});
Auth::routes(['register' => false]);

Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

// TAG ROUTES
Route::get('/tags', [App\Http\Controllers\TagsController::class, 'index']);
Route::post('/tags/store', [App\Http\Controllers\TagsController::class, 'store']);
Route::delete('/tags/delete/{id}', [App\Http\Controllers\TagsController::class, 'destroy']);
Route::post('/tags/edit/{id}', [App\Http\Controllers\TagsController::class, 'update']);
Route::post('/tags/search', [App\Http\Controllers\TagsController::class, 'search']);

// CATEGORY ROUTES
Route::get('/categories', [App\Http\Controllers\CategoriesController::class, 'index']);
Route::post('/categories/store', [App\Http\Controllers\CategoriesController::class, 'store']);
Route::delete('/categories/delete/{id}', [App\Http\Controllers\CategoriesController::class, 'destroy']);
Route::post('/categories/search', [App\Http\Controllers\CategoriesController::class, 'search']);
Route::post('/categories/edit/{id}', [App\Http\Controllers\CategoriesController::class, 'update']);

// COMPANY ROUTES
Route::get('/companies', [App\Http\Controllers\CompaniesController::class, 'index']);
Route::get('/companies/view/{id}', [App\Http\Controllers\CompaniesController::class, 'show']);
Route::get('/companies/create', [App\Http\Controllers\CompaniesController::class, 'create']);
Route::post('/companies/store', [App\Http\Controllers\CompaniesController::class, 'store']);
Route::delete('/companies/delete/{id}', [App\Http\Controllers\CompaniesController::class, 'destroy']);
Route::post('/companies/search', [App\Http\Controllers\CompaniesController::class, 'search']);
Route::get('/companies/edit/{id}', [App\Http\Controllers\CompaniesController::class, 'edit']);
Route::post('/companies/update/{id}', [App\Http\Controllers\CompaniesController::class, 'update']);

// GAME ROUTES
Route::get('games', [App\Http\Controllers\GamesController::class, 'index']);
Route::get('games/view/{id}', [App\Http\Controllers\GamesController::class, 'show']);
Route::get('games/create', [App\Http\Controllers\GamesController::class, 'create']);
Route::post('games/store', [App\Http\Controllers\GamesController::class, 'store']);
Route::delete('games/delete/{id}', [App\Http\Controllers\GamesController::class, 'destroy']);
Route::post('games/search', [App\Http\Controllers\GamesController::class, 'search']);
Route::get('games/edit/{id}', [App\Http\Controllers\GamesController::class, 'edit']);
Route::post('games/update/{id}', [App\Http\Controllers\GamesController::class, 'update']);
Route::get('games/removeimages/{id}', [App\Http\Controllers\GamesController::class, 'removeimages']);
Route::get('games/imagesForm/{id}', [App\Http\Controllers\GamesController::class, 'imagesForm']);

// TEST APP
Route::get('testApp/start', [App\Http\Controllers\TestAppController::class, 'start']);
Route::get('testApp/lose', [App\Http\Controllers\TestAppController::class, 'lose']);
Route::get('testApp/random', [App\Http\Controllers\TestAppController::class, 'random']);

// API
Route::get('api/random', [App\Http\Controllers\ApiController::class, 'random']);
Route::get('api/companies', [App\Http\Controllers\ApiController::class, 'companyLogo']);
Route::get('api/categories', [App\Http\Controllers\ApiController::class, 'categories']);

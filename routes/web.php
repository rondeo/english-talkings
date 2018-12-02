<?php

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

use Illuminate\Support\Facades\App;

/*Route::get('/{locale}', function ($locale) {
    App::setLocale($locale);
    return view('welcome');
});*/

Route::get('/', 'CountriesController@geojson');

Route::post('/new-user', 'NewcomersController@add');
Route::get('/newcomers', 'NewcomersController@index');
Route::get('/countries', 'CountriesController@index');
Route::get('/geojson', 'CountriesController@geojson');
Route::get('/languages', 'LanguagesController@index');
Route::get('/fact', 'FactsController@index');
Route::get('/language-levels', 'LanguageLevelsController@index');
Route::delete('/delete-user/{userId}', 'NewcomersController@delete');

Route::get('login/{service}', 'Auth\LoginController@redirectToProvider');
Route::get('login/{service}/callback', 'Auth\LoginController@handleProviderCallback');
Route::get('logout', '\App\Http\Controllers\Auth\LoginController@logout');

Route::get('profile', '\App\Http\Controllers\UsersController@profile')->name('profile');


Auth::routes();
Route::group(['middleware' => ['auth']], function () {
    Route::get('/home', function () {
        return view('home');
    })->name('home');
});

Route::group(['prefix' => 'nadyapanel',  'middleware' => 'auth'], function()
{
    Route::get('/', 'Admin\BaseController@index');
    Route::get('/articles', 'Admin\ArticlesController@index');
    Route::get('/facts', 'Admin\FactsController@index');
});
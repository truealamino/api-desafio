<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::prefix('v1')->group(function () {
    Route::resource('countries', 'v1\CountryController');

    Route::get('get-borders', 'v1\CountryController@getBordersByCountry');
    Route::get('country-region', 'v1\CountryController@getCountriesByRegion');
});

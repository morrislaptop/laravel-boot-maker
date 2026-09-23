<?php

use App\Http\Requests\StoreThingRequest;
use Illuminate\Http\Request;
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
    return view('welcome');
});

Route::get('/me', fn (Request $request) => $request->user()?->name ?? 'guest')->name('me');

Route::post('/validate', fn (Request $request) => $request->validate(['name' => 'required']));

Route::post('/things', fn (StoreThingRequest $request) => $request->validated());

<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CrawlerController;
use App\Http\Controllers\TodoController;
use App\Http\Controllers\AssignerController;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::resource('crawler', CrawlerController::class);

Route::resource('todo', TodoController::class);

Route::resource('assigner', AssignerController::class);

Route::get('active_assigners', [AssignerController::class, 'activeAssigners']);

Route::get('min_workload_assigner', [AssignerController::class, 'getMinWorkloadAssigner']);

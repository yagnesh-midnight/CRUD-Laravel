<?php

use App\Http\Controllers\ProjectController;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::post('/getallprojects', [ProjectController::class, 'getallprojects']);
Route::post('/addproject', [ProjectController::class, 'addproject']);
Route::post('/updateproject', [ProjectController::class, 'updateproject']);
Route::post('/deleteproject', [ProjectController::class, 'deleteproject']);
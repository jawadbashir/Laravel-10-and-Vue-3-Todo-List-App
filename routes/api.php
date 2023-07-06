<?php

use App\Http\Controllers\TaskController;
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
Route::post('/storetask', [TaskController::class, 'storeTask']);
Route::get('/gettasks', [TaskController::class, 'getTask']);
Route::put('/updatetask/{id}', [TaskController::class, 'updateTask']);
Route::delete('/deletetask/{id}', [TaskController::class, 'deleteTask']);

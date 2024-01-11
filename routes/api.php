<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\AttendanceController;
use App\Http\Controllers\API\GroupByOwnersController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Route for listing attendance information
Route::get('/attendance', [AttendanceController::class, 'index']);

// Route for uploading Excel attendance
Route::post('/upload-attendance-excel', [AttendanceController::class, 'uploadAttendanceExcel']);

// Route for finding duplicates
Route::get('/find-duplicates', 'App\Http\Controllers\API\DuplicateController@findDuplicates');

// Route for finding files by group by owners
Route::get('/group-by-owners', [GroupByOwnersController::class, 'groupByOwners']);


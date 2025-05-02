<?php
// File: routes/api.php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ProjectApiController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
*/

Route::get('/projects', [ProjectApiController::class, 'index']);
Route::get('/projects/{project}', [ProjectApiController::class, 'show']);
Route::post('/projects', [ProjectApiController::class, 'store']);
Route::put('/projects/{project}', [ProjectApiController::class, 'update']);
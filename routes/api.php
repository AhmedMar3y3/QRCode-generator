<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FormController;

Route::post('/forms',     [FormController::class, 'createForm']);
Route::get('/forms/{id}', [FormController::class, 'getFormById']);

<?php

use App\Http\Controllers\ApplicantController;
use Illuminate\Support\Facades\Route;

Route::get('/', [ApplicantController::class, 'index'])->name('applicants.index');
Route::get('/details/{instrument}', [ApplicantController::class, 'show'])->name('applicants.details');

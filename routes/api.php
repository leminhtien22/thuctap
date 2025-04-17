<?php

use App\Http\Controllers\ExhibitionController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('/exhibition/details', [ExhibitionController::class, 'getExhibition'])->name('api.exhibition.details');
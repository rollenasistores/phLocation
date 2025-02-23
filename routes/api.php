<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LocationController;

Route::get('/region', [LocationController::class, 'getRegions']);
Route::get('/province', [LocationController::class, 'getProvinces']);
Route::get('/city', [LocationController::class, 'getCities']);
Route::get('/barangay', [LocationController::class, 'getBarangays']);

Route::get('/region/{psgc_code}', [LocationController::class, 'getRegionByCode']);
Route::get('/province/{province_code}', [LocationController::class, 'getProvinceByCode']);
Route::get('/city/{city_code}', [LocationController::class, 'getCityByCode']);
Route::get('/barangay/{brgy_code}', [LocationController::class, 'getBarangayByCode']);

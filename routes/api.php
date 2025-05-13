<?php

use App\Http\Controllers\Auth\ClientAuthController;
use Illuminate\Support\Facades\Route;


Route::middleware(['api.client'])->group(function () {
    Route::post('test', [\App\Http\Controllers\Api\Controller::class, 'getTestData']);
});
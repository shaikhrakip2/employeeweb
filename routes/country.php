<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DropdownController;

// state country city
Route::get('/dropdown', [DropdownController::class, 'index']);

Route::post('api/fetch-states', [DropdownController::class, 'fetchState']);

Route::post('api/fetch-cities', [DropdownController::class, 'fetchCity']);

?>
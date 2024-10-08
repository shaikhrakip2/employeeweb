<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MobileDevelopers;
use App\Models\MobileDeveloper;

route::get('mobiledeveloper', [MobileDevelopers::class, 'adddevelopers'])->name('mobiledeveloper');

route::get('developerViewTable', [MobileDevelopers::class,'developersviewtable'])->name('developersviewtable');

route::post('storedata', [MobileDevelopers::class,'storedata'])->name('data-store');









?>


<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EventController;
use App\Http\Controllers\WebDevelopers;

Route::get('/', function () {
    return view('welcome');
});

route::get('index', [UserController::class,'index']);

route::get('/addnewemployee',[UserController::class,'addnewemployee'])->name('addnewemployee');
route::get('/totalemployee', [UserController::class, 'totalemployee'])->name('totalemployee');

Route::get('/dashboard', function () {
    return view('index');
})->middleware(['auth', 'verified'])->name('dashboard');


route::post('/storenewemployee', [UserController::class,'storenewemployee'])->name('storenewemployee');





Route::get('users', [WebDevelopers::class, 'create'])->name('users');
Route::post('users/store', [WebDevelopers::class, 'store']);



Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});










//  edit employee
route::get('/edit/{id}', [UserController::class,'editemployee'])->name('edit-employee');

route::post('/updateemployee/{id}', [UserController::class,'updateemployee'])->name('updateemployee');

// delete employee
route::get('/delete/{id}', [UserController::class, 'deleteemployee'])->name('deleteemployee');

//read

route::get('/viewemployeedata/{id}', [UserController::class, 'viewemployeedata'])->name('viewemployeedata');







require __DIR__.'/auth.php';

require __DIR__.'/mobiledeveloper.php';

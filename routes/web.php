<?php

use App\Http\Controllers\ContactController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;



// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/',[UserController::class,'welcome']);

route::get('index', [UserController::class,'index']);

route::get('/addnewemployee',[UserController::class,'addnewemployee'])->name('addnewemployee');
route::get('/totalemployee', [UserController::class, 'totalemployee'])->name('totalemployee');

// Route::get('/dashboard', function () {   
//     return view('index');
// })->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/dashboard',[UserController::class,'index'])->middleware(['auth', 'verified'])->name('dashboard');

// dashboard delete
Route::get('/dashboard/delete/{id}', [UserController::class,'userdestroy'])->name('user-delete');


Route::get('/dashboard/edit/{id}', [UserController::class,'edituser'])->name('edit-user');

Route::post('/dashboard/edit-store/{id}', [UserController::class,'storeedituser'])->name('edit-store');


//end user

route::post('/storenewemployee', [UserController::class,'storenewemployee'])->name('storenewemployee');



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





// / contact home page
route::get('/contact',[ContactController::class,'contact']);










require __DIR__.'/auth.php';
require __DIR__.'/mobiledeveloper.php';
require __DIR__.'/Inputfield.php';  
require __DIR__.'/country.php';

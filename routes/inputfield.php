<?php

use App\Http\Controllers\InputController;
use Illuminate\Support\Facades\Route;



route::get('/inputfield',[InputController::class, 'Input']);





?>
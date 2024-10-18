<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class HomeCms extends Model
{
     use HasFactory;

     protected $fillable = [
        'name','cms_contant1','cms_contant2','image'
     ];
 
}

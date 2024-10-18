<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class NewsletterNotification extends Model
{
    use HasFactory,SoftDeletes;
  
    protected $guarded =  ['id', 'created_at', 'updated_at', 'deleted_at',];

     protected $dates = ['deleted_at']; 
}
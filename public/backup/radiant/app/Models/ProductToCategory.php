<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class ProductToCategory extends Model
{
    use HasFactory;

     protected $fillable = [
        'product_id',
        'category_id'
    ];
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Certification extends Model
{
    use HasFactory;

    protected $fillable = [
        'id', 'name', 'image', 'issue_date'
    ];

    protected $dates = ['deleted_at'];
}

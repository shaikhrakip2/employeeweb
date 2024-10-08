<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MobileDeveloper extends Model
{
    use HasFactory;

    protected $table = 'mobile_developers';
    protected $primaryKey = 'id';
}

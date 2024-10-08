<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WebDevelopers extends Model
{
    use HasFactory;

    protected $table = 'web_developers';

    protected $primaryKey = 'id';
}

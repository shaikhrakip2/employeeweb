<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GeneralInquiry extends Model
{
    use HasFactory;
    protected $guarded =  ['id', 'created_at', 'updated_at', 'deleted_at',];

    protected $table = 'general_inquiry';
}

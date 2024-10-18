<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContactInquiry extends Model
{
    use HasFactory;
    protected $fillable = [
        'name','offer_name','type','mobile','email','subject','message'
    ];
    protected $table = 'contact_inquery';
}

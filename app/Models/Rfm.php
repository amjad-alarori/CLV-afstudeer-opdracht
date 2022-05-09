<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rfm extends Model
{
    use HasFactory;
    protected $fillable = ['RFM' => 'json'];  
    
}

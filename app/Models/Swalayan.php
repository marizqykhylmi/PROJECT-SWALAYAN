<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class swalayan extends Model
{
    use HasFactory;

    protected $fillable = ['type', 'name', 'price', 'stock'];
}


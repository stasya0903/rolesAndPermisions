<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Fias_41_Street extends Model
{
    use HasFactory;

    protected $fillable = [
        'aoid',
        'offname',
        'shortname',
        'regioncode',
        'okato',
        'oktmo',
    ];
}

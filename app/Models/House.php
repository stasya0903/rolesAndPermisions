<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class House extends Model
{
    use HasFactory;
    /** @var bool */
    public $timestamps = false;

    /** @var bool */
    public $incrementing = false;

    /** @var string */
    protected $table = 'fias_laravel_house';

    /** @var string */
    protected $primaryKey = 'houseid';

    /** @var string */
    protected $keyType = 'string';

    /** @var string[] */
    protected $fillable = [
        'houseid',
        'houseguid',
        'aoguid',
        'housenum',
        'strstatus',
        'eststatus',
        'statstatus',
        'ifnsfl',
        'ifnsul',
        'okato',
        'oktmo',
        'postalcode',
        'regioncode',
        'terrifnsfl',
        'terrifnsul',
        'buildnum',
        'strucnum',
        'normdoc',
        'cadnum',
    ];

    /** @var array<string, string> */
    protected $casts = [
        'houseid' => 'string',
        'houseguid' => 'string',
        'aoguid' => 'string',
        'housenum' => 'string',
        'strstatus' => 'integer',
        'eststatus' => 'integer',
        'statstatus' => 'integer',
        'ifnsfl' => 'string',
        'ifnsul' => 'string',
        'okato' => 'string',
        'oktmo' => 'string',
        'postalcode' => 'string',
        'regioncode' => 'string',
        'terrifnsfl' => 'string',
        'terrifnsul' => 'string',
        'buildnum' => 'string',
        'strucnum' => 'string',
        'normdoc' => 'string',
        'cadnum' => 'string',
    ];
}

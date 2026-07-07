<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BehandelingPerVoorraad extends Model
{
    protected $table = 'BehandelingPerVoorraad';
    protected $primaryKey = 'Id';
    public $incrementing = false;

    protected $fillable = [
        'Id',
        'BehandelingId',
        'VoorraadId',
        'IsActief',
        'Opmerking',
    ];

    protected $casts = [
        'IsActief' => 'boolean',
    ];
}

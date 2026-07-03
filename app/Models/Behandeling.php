<?php

namespace App\Models;
use DB;
use Log;

use Illuminate\Database\Eloquent\Model;

class Behandeling extends Model
{
    // Geef aan dat de tabelnaam afwijkt als deze niet 'behandelings' is
    protected $table = 'Behandeling';

    // Geef aan dat de primaire sleutel 'Id' is (hoofdlettergevoelig afhankelijk van database)
    protected $primaryKey = 'Id';

    // Als Id geen auto-incrementing integer is, zet dit dan op false
    public $incrementing = false;

    // De velden die via mass-assignment ingevuld mogen worden
    protected $fillable = [
        'Id',
        'Naam',
        'Omschrijving',
        'Duurminuten',
        'Prijs',
        'IsActief',
    ];

    // Cast 'IsActief' van een bit (string/binary) naar een boolean voor makkelijker gebruik in PHP
    protected $casts = [
        'IsActief' => 'boolean',
        'Prijs' => 'decimal:2',
    ];

    public function behandelingPerVoorraad()
    {
        return $this->hasMany(BehandelingPerVoorraad::class, 'BehandelingId', 'Id');
    }

    public function getAllBehandelingen()
    {
        try {
            $behandelingen = DB::select('CALL GetBehandelingenOverzicht()' ?? []);
            return $behandelingen;
        } catch (\Exception $e) {
            // Log the error or handle it as needed
            Log::error('Error occurred while fetching behandelingen: ' . $e->getMessage());
        }
    }
}
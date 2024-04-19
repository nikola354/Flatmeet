<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BuildingsAddress extends Model
{
    use HasFactory;

    protected $primaryKey = 'building_code';
    protected $keyType = 'string';

    protected $fillable = [
        'short_address',
        'full_address'
    ];

    protected function setKeysForSaveQuery($query)
    {
        $query->where('building_code', $this->getAttribute('building_code'));
        return $query;
    }

}
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Apartment extends Model
{
    use HasFactory;

    public $incrementing = false;
    protected $keyType = 'string';
    protected $primaryKey = ['building_code', 'number'];

    protected $fillable = [
    	'number',
    	'floor',
    	'family_name'
    ];
}
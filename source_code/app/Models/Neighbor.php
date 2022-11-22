<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Neighbor extends Model
{
    use HasFactory;

    public $incrementing = false;
    protected $keyType = 'string';
    protected $primaryKey = ['email', 'building_code'];

    protected $fillable = [
        'email',
        'rights',
        'ap_num'
    ];

    const ADMIN_TYPE = 'admin';
    const TREASURER_TYPE = 'treasurer';
    const NEIGHBOR_TYPE = 'neighbor';

    public function getRights(){
        return $this->rights;
    }

    public function isAdmin(){
        return $this->rights === self::ADMIN_TYPE;
    }

    public function isTreasurer(){
        return $this->rights === self::TREASURER_TYPE;
    }
}
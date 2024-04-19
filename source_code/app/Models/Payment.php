<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'type',
        'ap_num',
        'month'
    ];

    protected $primaryKey = ['type', 'month', 'ap_num', 'building_code'];
    public $incrementing = false;
    protected $keyType = 'string';

    protected function setKeysForSaveQuery($query)
    {
        foreach ($this->primaryKey as $key) {
            $query->where($key, $this->getAttribute($key));
        }
        return $query;
    }
}
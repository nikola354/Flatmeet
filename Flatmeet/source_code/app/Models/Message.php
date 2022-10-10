<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    use HasFactory;

    protected $primaryKey = 'id';

    protected $fillable = [
    	'body',
    	'to'
    ];

    public function user() {
        return $this->belongsTo(User::class);
    }
}
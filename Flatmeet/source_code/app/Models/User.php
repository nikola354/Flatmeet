<?php

namespace App\Models;

use App\Models\Message;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Http\Request;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $primaryKey = 'id';
    
    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'password'
    ];

    protected $hidden = [
        'password',
        'remember_token'
    ];

    public function messages() {
        return $this->hasMany(Message::class, 'from');
    }

    public function getRights($code){
        $neighbor = Neighbor::where('building_code', $code)
            ->where('email', auth()->user()->email)
            ->first();

        return $neighbor->getRights();
    }

    public function isAdmin($code){
        $neighbor = Neighbor::where('building_code', $code)
            ->where('email', auth()->user()->email)
            ->first();

        return $neighbor->isAdmin();
    }

    public function isTreasurer($code){
        $neighbor = Neighbor::where('building_code', $code)
            ->where('email', auth()->user()->email)
            ->first();

        return $neighbor->isTreasurer();
    }
}
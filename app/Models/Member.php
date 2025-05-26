<?php

// app/Models/Member.php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Member extends Authenticatable
{
    use Notifiable;

    protected $fillable = [
        'email', 'nama', 'tanggal_lahir', 'no_hp', 'password', 'status'
    ];

    protected $hidden = [
        'password',
    ];

    protected $casts = [
        'tanggal_lahir' => 'date',
        'status' => 'boolean',
    ];
}


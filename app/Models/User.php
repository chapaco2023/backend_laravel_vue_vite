<?php

namespace App\Models;

use App\Notifications\ResetPasswordNotification;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasFactory, Notifiable, HasApiTokens;

    protected $table = 'users';

    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
    public function sendPasswordResetNotification($token)
    {
        $url_fronted = "http://localhost:5173/reset-password?token=" . $token;
        $this->notify(new ResetPasswordNotification($url_fronted));
    }

    public function persona()
    {
        // Persona es el modelo de la tabla persona
        return $this->hasOne(Persona::class);
    }

    public function roles()
    {
        // Roles es el modelo de la tabla roles
        return $this->belongsToMany(Role::class)->withTimestamps();
    }
}

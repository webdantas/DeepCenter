<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Storage;

class User extends Authenticatable
{
    use HasFactory, Notifiable, SoftDeletes;

    protected $fillable = [
        'name',
        'email',
        'password',
        'avatar',
        'is_admin'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'is_admin' => 'boolean'
    ];

    public function getAvatarUrlAttribute()
    {
        if ($this->avatar) {
            if (Storage::disk('public')->exists($this->avatar)) {
                return Storage::disk('public')->url($this->avatar);
            }
        }
        
        return sprintf(
            'https://ui-avatars.com/api/?name=%s&color=7F9CF5&background=EBF4FF&size=48',
            urlencode($this->name)
        );
    }

    public function deleteAvatar()
    {
        if ($this->avatar) {
            if (Storage::disk('public')->exists($this->avatar)) {
                Storage::disk('public')->delete($this->avatar);
            }
            $this->update(['avatar' => null]);
        }
    }
}
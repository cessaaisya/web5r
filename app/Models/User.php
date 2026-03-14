<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'nim',
        'no_reg',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function roles()
    {
        return $this->belongsToMany(Role::class, 'user_roles');
    }

    public function hasRole($role)
    {
        return $this->roles()->where('name', $role)->exists();
    }

    /**
     * Get the display fields for this user based on their role
     */
    public function getDisplayFields()
    {
        $fields = ['name' => $this->name];

        if ($this->hasRole('student')) {
            $fields['NIM'] = $this->nim;
        } elseif ($this->hasRole('management') || $this->hasRole('admin')) {
            $fields['Registration Number'] = $this->no_reg;
        }

        return $fields;
    }

    /**
     * Get user info as a formatted string based on role
     */
    public function getFormattedInfo()
    {
        if ($this->hasRole('student')) {
            return "{$this->name} ({$this->nim})";
        } elseif ($this->hasRole('management') || $this->hasRole('admin')) {
            return "{$this->name} ({$this->no_reg})";
        }

        return $this->name;
    }
}
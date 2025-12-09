<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use App\Enums\UserRole;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Storage;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */

    protected $fillable = [
        'username','email','full_name','avatar','role','password',
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
            'role' => UserRole::class,
        ];
    }
  protected function avatarUrl(): Attribute
    {
        return Attribute::get(function () {
           if (!$this->avatar) return null;
           return asset('storage/'.$this->avatar);
        });
    }

    public function isAdmin(): bool
    {
        return $this->role === UserRole::Admin;
    }

    public function isManager(): bool
    {
        return $this->role === UserRole::Manager;
    }

    public function isBasicUser(): bool
    {
        return $this->role === UserRole::User;
    }

    public function abilities(): array
    {
    $abilities = [
        'projects.view',
        'tasks.view',
    ];

    if ($this->role === UserRole::Manager || $this->role === UserRole::Admin) {
        $abilities[] = 'projects.manage';
        $abilities[] = 'tasks.manage';
        $abilities[] = 'tasks.update-status';
        $abilities[] = 'tasks.take';
    }

    if ($this->role === UserRole::User) {
        $abilities[] = 'tasks.update-status';
        $abilities[] = 'tasks.take';
    }

    if ($this->role === UserRole::Admin) {
        $abilities[] = 'users.manage';
    }

    return array_values(array_unique($abilities));
}
}

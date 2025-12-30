<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
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
        'login',
        'last_name',
        'first_name',
        'email',
        'phone_number',
    ];

    /**
     * Retourne la liste des rôles de l'utilisateur (table association)
     *
     * @return BelongsToMany // Liste des rôles de l'utilisateur
     */
    public function roles(): BelongsToMany
    {
        return $this->belongsToMany(Role::class, 'role_user');
    }
    // TODO
    // public function hasPermission(): bool {} // TODO si a la permission admin -> il a toutes les permissions
    // public function getRoles(): array {}
    // public function hasRole(): bool {}
}

<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
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

    // protected $roles =

    /**
     * Retourne le nom complet de l'utilisateur
     * en concaténant le prénom et le nom séparés par un espace.
     *
     * @return string le nom complet de l'utilisateur
     */
    public function getFullName(): string
    {
        return $this->first_name.' '.$this->last_name;
    }

    /**
     * Définit le prénom de l'utilisateur en covertissant la chaîne en miniscule
     * puis en mettant la première lettre en majuscule avant de l'assigner.
     *
     * @return bool true si l'enregistrement du fichier a fonctionné, false sinon
     */
    public function setFirstName(string $firstName): void
    {
        $lowerFirstName = mb_strtolower($firstName, 'UTF-8');
        $properFirstName = ucfirst($lowerFirstName);
        $this->first_name = $properFirstName;

    }

    public function setLastName(string $lastName): void
    {
        $lowerLastName = mb_strtolower($lastName, 'UTF-8');
        $properLastName = ucfirst($lowerLastName);
        $this->last_name = $properLastName;
    }

    /**
     * Retourne la liste des rôles de l'utilisateur (table association)
     *
     * @return BelongsToMany // Liste des rôles de l'utilisateur
     */
    public function roles(): BelongsToMany
    {
        return $this->belongsToMany(Role::class, 'role_user');
    }

    /**
     * Retourne la liste des commentaires de l'utilisateur
     *
     * @return HasMany // Liste des commentaires de l'utilisateur
     */
    public function comments(): HasMany
    {
        return $this->HasMany(Comment::class);
    }

    /**
     * Retourne la liste des actions de l'utilisateur
     *
     * @return HasMany // Liste des actions de l'utilisateur
     */
    public function logs(): HasMany
    {
        return $this->HasMany(Log::class);
    }

    /**
     * Vérifie si un utilisateur a la permission "$permission"
     *
     * @param   \Database\Seeders\Permission    $permission Permission à vérifier
     * @param   bool    $strict Si retourne toujours true avec la permission administrateur (à false par défaut)
     * @return  bool        // true si l'utilisateur a un rôle avec la permission "$permission", false sinon
     */
    public function hasPermission(\Database\Seeders\Permission $permission, $strict = false): bool
    {
        // TODO pour des questions de performances charger au préalable les permissions de l'utilisateur dans le "constructeur" (voir comment faire avec laravel)
        foreach ($this->roles()->allRelatedIds() as $role) {
            if ($role->hasPermission($permission, $strict)) {
                return true;
            }
        }
        return false;
    }
    // public function getRoles(): array {}
    // public function hasRole(): bool {}
}

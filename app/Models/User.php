<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Database\Seeders\PermissionValue;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Collection;
use Filament\Panel;
use Filament\Models\Contracts\FilamentUser;

class User extends Authenticatable implements FilamentUser
{
    /** @use HasFactory<UserFactory> */
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
     * Retourne le prénom de l'utilisateur
     *
     * @return string prénom de l'utilisateur
     */
    public function getFirstName(): string
    {
        return $this->attributes['first_name'];
    }

    /**
     * Retourne le nom de famille de l'utilisateur
     *
     * @return string nom de famille de l'utilisateur
     */
    public function getLastName(): string
    {
        return $this->attributes['last_name'];
    }

    /**
     * Retourne le nom complet de l'utilisateur
     * en concaténant le prénom et le nom séparés par un espace.
     *
     * @return string le nom complet de l'utilisateur
     */
    public function getFullName(): string
    {
        return $this->getFirstName().' '.$this->getLastName();
    }

    /**
     * Retourne la liste des rôles de l'utilisateur
     *
     * @return Collection // Collection (liste) des rôles de l'utilisateur
     */
    public function getRoles(): Collection
    {
        // TODO peut-être faire un cache ?
        return $this->roles()->getResults();
    }

    /**
     * Retourne true si l'utilisateur a un rôle en particulier, false sinon.
     *
     * @param  Role  $role  le rôle à vérifier
     * @return bool // Si l'utilisateur a le rôle $role
     */
    public function hasRole(Role $role): bool
    {
        // TODO peut-être faire un cache ?
        return $this->getRoles()->contains($role);
    }

    /**
     * Retourne la liste des départements auxquels appartient l'utilisateur
     *
     * @return Collection // Collection (liste) des départements de l'utilisateur
     */
    public function getDepartments(): Collection
    {
        // TODO peut-être faire un cache ?
        return $this->getRoles()->filter(fn (Role $role) => $role->isDepartment());
    }

    /**
     * Retourne un dictionnaire des permissions de l'utilisateur
     *
     * @return array // Dictionnaire des permissions de l'utilisateur
     */
    public function getPermissionsAsDict(): array
    {
        return Role::getPermissionsAsDict($this->getRoles());
    }

    /**
     * Définit le prénom de l'utilisateur en covertissant la chaîne en miniscule
     * puis en mettant la première lettre en majuscule avant de l'assigner.
     *
     * @return void true si l'enregistrement du fichier a fonctionné, false sinon
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
     * @param  PermissionValue  $permission  Permission à vérifier
     * @param  bool  $strict  Si ne retourne pas true avec la permission administrateur (à false par défaut)
     * @return bool // true si l'utilisateur a un rôle avec la permission "$permission", false sinon
     */
    public function hasPermission(PermissionValue $permission, bool $strict = false): bool
    {
        // TODO pour des questions de performances charger au préalable les permissions de l'utilisateur dans le "constructeur" (voir comment faire avec laravel)
        foreach ($this->roles()->getResults() as $role) {
            if ($role->hasPermission($permission, $strict)) {
                return true;
            }
        }

        return false;
    }
    // public function hasRole(): bool {}

    public function getFilamentName(): string
    {
        return $this->name;
    }

    public function canAccessPanel(Panel $panel): bool
    {
        return true;
        //return in_array($this->role, ['Administrateur BD']);
    }

    
    public function getNameAttribute(): string
    {
        return "{$this->first_name} {$this->last_name}";
    }
}

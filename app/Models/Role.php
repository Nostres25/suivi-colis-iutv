<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Collection;

class Role extends Model
{
    use \Illuminate\Database\Eloquent\Factories\HasFactory;

    /**
     * Retourne true si le rôle correspond à un département
     *
     * @return bool // Si le rôle correspond à un départment
     */
    public function isDepartment(): bool
    {
        return $this->attributes['is_department'];
    }

    /**
     * Retourne la liste des utilisateurs qui possèdent le rôle
     *
     * @return Collection // Collection (liste) des utilisateurs ayant le rôle
     */
    public function getUsers(): Collection
    {
        // TODO peut-être faire un cache ?
        return $this->users()->getResults();
    }

    /**
     * Retourne la liste des utilisateurs associés au rôle (table association)
     *
     * @return BelongsToMany // Liste des utilisateurs du rôle
     */
    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class);
    }

    /**
     * Retourne la liste des permissions du rôle (table association)
     *
     * @return BelongsToMany // Liste des permissions du rôle
     */
    public function permissions(): BelongsToMany
    {
        return $this->BelongsToMany(Permission::class);
    }

    // TODO à tester
    /**
     * Vérifie si un rôle a la permission "$permission"
     *
     * @param  \Database\Seeders\PermissionValue  $permission  Permission à vérifier
     * @param  bool  $strict  Si retourne toujours true avec la permission administrateur (à false par défaut)
     * @return bool // true si le rôle a la permission "$permission", false sinon
     */
    public function hasPermission(\Database\Seeders\PermissionValue $permission, $strict = false): bool
    {
        if (! $strict && $this->permissions()->where('id', \Database\Seeders\PermissionValue::ADMIN)->exists()) {
            return true;
        }

        return (bool) $this->permissions()->where('id', $permission)->exists();

    }

    /**
     * Retourne la liste des commandes associée au rôle (pour les départements)
     *
     * @return HasMany // Commandes du rôle (département)
     */
    public function orders(): HasMany
    {
        return $this->HasMany(Order::class);
    }
}

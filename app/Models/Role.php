<?php

namespace App\Models;

use \App\Models\Permission;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Role extends Model
{
    use \Illuminate\Database\Eloquent\Factories\HasFactory;

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
     * @param   \Database\Seeders\Permission    $permission Permission à vérifier
     * @param   bool    $strict Si retourne toujours true avec la permission administrateur (à false par défaut)
     * @return  bool        // true si le rôle a la permission "$permission", false sinon
     */
    public function hasPermission(\Database\Seeders\Permission $permission, $strict = false): bool
    {
        if (! $strict && $this->permissions()->where('id', \Database\Seeders\Permission::ADMIN)->exists()) {
            return true;
        }

        return (bool) $this->permissions()->where('id', $permission)->exists();

    }
}

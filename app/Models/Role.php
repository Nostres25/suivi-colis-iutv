<?php

namespace App\Models;

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
}

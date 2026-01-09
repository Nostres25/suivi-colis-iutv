<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Permission extends Model
{
    use \Illuminate\Database\Eloquent\Factories\HasFactory;

    /**
     * Retourne le nom de la permission
     *
     * @return string // nom de la permission
     */
    public function getName(): string
    {
        return $this->attributes['name'];
    }

    /**
     * Retourne la liste des rôles avec cette permission (table association)
     *
     * @return BelongsToMany // Liste de rôles avec la permission
     */
    public function roles(): BelongsToMany
    {
        return $this->BelongsToMany(Role::class);
    }
}

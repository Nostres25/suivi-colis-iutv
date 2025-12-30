<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Role extends Model
{
    use \Illuminate\Database\Eloquent\Factories\HasFactory;

    // Source - https://stackoverflow.com/a
    // Posted by Sameer Shaikh, modified by community. See post 'Timeline' for change history
    // Retrieved 2025-12-26, License - CC BY-SA 4.0

    public $timestamps = false;

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

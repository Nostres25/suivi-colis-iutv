<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Comment extends Model
{
    use \Illuminate\Database\Eloquent\Factories\HasFactory;

    // Source - https://stackoverflow.com/a
    // Posted by Sameer Shaikh, modified by community. See post 'Timeline' for change history
    // Retrieved 2025-12-26, License - CC BY-SA 4.0

    public $timestamps = false;

    /**
     * Retourne l'utilisateur, auteur de la commande
     *
     * @return BelongsTo // Utilisateur, auteur de la commande
     */
    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class, 'author_id');
    }

    /**
     * Retourne la commande concernée par le commentaire
     *
     * @return BelongsTo // Commande associée au commentaire
     */
    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }
}

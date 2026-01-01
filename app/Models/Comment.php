<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Comment extends Model
{
    use \Illuminate\Database\Eloquent\Factories\HasFactory;

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

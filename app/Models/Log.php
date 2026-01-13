<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Log extends Model
{
    use \Illuminate\Database\Eloquent\Factories\HasFactory;

    /**
     * Retourne l'auteur de l'action, l'utilisateur associé au log
     *
     * @return User // Utilisateur auteur de l'action / associé au log
     */
    public function getAuthor(): User
    {
        return $this->author()->getResults();
    }

    /**
     * Retourne la commande dont appartient le log
     *
     * @return BelongsTo // Commande du log
     */
    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    /**
     * Retourne l'auteur de l'action
     *
     * @return BelongsTo // Auteur de l'action
     */
    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class, 'author_id');
    }
}

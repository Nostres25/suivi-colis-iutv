<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Log extends Model
{
    use \Illuminate\Database\Eloquent\Factories\HasFactory;

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
     * @return HasOne // Auteur de l'action
     */
    public function user(): HasOne
    {
        return $this->hasOne(User::class);
    }
}

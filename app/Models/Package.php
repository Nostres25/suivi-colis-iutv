<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Package extends Model
{
    use \Illuminate\Database\Eloquent\Factories\HasFactory;

    protected $fillable = [
        'label',
        'cost',
        'date_expected_delivery',
        'shipping_date',
    ];

    /**
     * Retourne la commande dont appartient le colis
     *
     * @return BelongsTo // Commande associée au colis
     */
    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }
}

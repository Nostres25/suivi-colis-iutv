<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Supplier extends Model
{
    use HasFactory;

    // protected $fillable = [
    //     'company_name',
    //     'siret',
    //     'email',
    //     'phone_number',
    //     'contact_name',
    //     'is_valid',
    // ];

    // Pas remplissable
    protected $guarded = [

    ];

    /**
     * Retourne la liste des commandes du fournisseur
     *
     * @return HasMany // Liste des commandes du fournisseur
     */
    public function orders(): HasMany
    {
        return $this->hasMany(Order::class);
    }
}

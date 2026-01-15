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
     * Retourne le nom de l'entreprise du fournisseur.
     *
     * @return string // Nom d'entreprise du fournisseur
     */
    public function getCompanyName(): string
    {
        return $this->attributes['company_name'];
    }

    /**
     * Retourne true si le fournisseur est considéré comme valide, false sinon.
     * Un fournisseur valide est un fournisseur auprès duquel il est possible de commander.
     *
     * @return bool // Si le fournisseur est valide
     */
    public function isValid(): bool
    {
        return $this->attributes['is_valid'];
    }

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

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Collection;

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
     * Retourne l'identifiant du fournisseur
     *
     * @return string // identifiant du fournisseur
     */
    public function getId(): string
    {
        return $this->attributes['id'];
    }

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
     * Retourne le SIRET de l'entreprise du fournisseur.
     *
     * @return string // SIRET d'entreprise du fournisseur
     */
    public function getSiret(): string
    {
        return $this->attributes['siret'];
    }

    /**
     * Retourne l'email de contact du fournisseur.
     *
     * @return ?string // email de contact du fournisseur
     */
    public function getEmail(): ?string
    {
        return $this->attributes['email'];
    }

    /**
     * Retourne le numéro de téléphone de contact du fournisseur.
     *
     * @return ?string // numéro de téléphone de contact du fournisseur
     */
    public function getPhoneNumber(): ?string
    {
        return $this->attributes['phone_number'];
    }

    /**
     * Retourne le nom du contact dans l'entreprise fournisseur.
     *
     * @return ?string // nom du contact dans l'entreprise fournisseur
     */
    public function getContactName(): ?string
    {
        return $this->attributes['contact_name'];
    }

    /**
     * Retourne la description des spécialités de l'entreprise fournisseur.
     *
     * @return ?string // description des spécialités de l'entreprise fournisseur
     */
    public function getSpeciality(): ?string
    {
        return $this->attributes['speciality'];
    }

    /**
     * Retourne les notes sur le fournisseur.
     *
     * @return ?string // notes sur le fournisseur.
     */
    public function getNote(): ?string
    {
        return $this->attributes['note'];
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
     * Retourne la date de la dernière modification du fournisseur
     *
     * @return ?string // date
     */
    public function getLastUpdateDate(): ?string
    {
        return $this->attributes[$this->getUpdatedAtColumn()];
    }

    /**
     * Retourne la date de création du fournisseur
     *
     * @return string // date
     */
    public function getCreationDate(): string
    {
        return $this->attributes[$this->getCreatedAtColumn()];
    }

    /**
     * Retourne la liste des commandes du fournisseur
     *
     * @return Collection // Collection (liste) des commandes du fournisseur
     */
    public function getOrders(): Collection
    {
        return $this->getAttribute('orders');
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

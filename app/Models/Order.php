<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Ramsey\Collection\Collection;

// Projet abandonné car ça ne trouve pas l'enum ici
// enum OrderAttributes: string {
//    case TITLE = 'title';
//    case ORDER_NUM = 'order_num';
//    case DESCRIPTION = 'description';
//    case COST = 'cost';
//    case QUOTE_NUM = 'quote_num';
//    case PATH_QUOTE = 'path_quote';
//    case PATH_PURCHASE_ORDER = 'path_purchase_order';
//    case PATH_DELIVERY_NOTE = 'path_delivery_note';
//    case STATUS = 'status';
// }
class Order extends Model
{
    use \Illuminate\Database\Eloquent\Factories\HasFactory;

    protected $fillable = [
        'titre',
        'description',
        'cost',
        'quote_num',
        'path_quote',
        'path_purchase_order',
        'path_delivery_note',
        'status',
    ];

    /**
     * Retourne le titre/la désignation de la commande
     *
     * @return string // titre de la commande
     */
    public function getTitle(): string
    {
        return $this->attributes['title'];
    }

    /**
     * Retourne le numéro de la commande
     *
     * @return string // Numéro de la commande
     */
    public function getNumero(): string
    {
        return $this->attributes['quote_num'];
    }

    /**
     * Retourne le numéro de la commande
     *
     * @return string // numéro de la commande
     */
    public function getOrderNumber(): string
    {
        return $this->attributes['order_num'];
    }

    /**
     * Retourne la description de la commande
     *
     * @return string // description de la commande
     */
    public function getDescription(): string
    {
        return $this->attributes['description'];
    }

    /**
     * Retourne le coût en euros total de la commande
     *
     * @return string // coût en euros de la commande
     */
    public function getCost(): string
    {
        return $this->attributes['cost'];
    }

    /**
     * Retourne le coût formaté avec la devise en euro en chaîne de caractères.
     *
     * @return string le coût formaté en euro ou 'Non communiqué' si le coût n'est pas encore indiqué.
     */
    public function getCostFormatted(): string
    {
        if (is_null($this->getCost())) {
            return 'Non précisé';
        }

        return number_format($this->getCost(), 2, ',', ' ').' €';
    }

    /**
     * Retourne le numéro du devis associé à la commande
     *
     * @return string // Numero du devis de la commande
     */
    public function getQuoteNumber(): string
    {
        return $this->attributes['quote_num'];
    }

    /**
     * Retourne l'url du devis.html/css avec bootstrap)
     *
     * @return string|null l'url du devis ou null si le devis n'est pas encore enregistré.
     */
    public function getUrlQuote(): ?string
    {
        $path_quote = $this->getAttributeValue('path_quote');
        if (is_null($path_quote)) {
            return null;
        }

        return Storage::url($path_quote);
    }

    /**
     * Retourne l'url du bon de commande.
     *
     * @return string|null l'url du bon de commande ou null si le bon de commande n'est pas encore enregistré.
     */
    public function getUrlPurchaseOrder(): ?string
    {
        $path_purchase_order = $this->getAttributeValue('path_purchase_order');
        if (is_null($path_purchase_order)) {
            return null;
        }

        return Storage::url($path_purchase_order);
    }

    /**
     * Retourne l'url du bon de livraison.
     *
     * @return string|null l'url du bon de livraison ou null si le bon de livraison n'est pas encore enregistré.
     */
    public function getUrlDeliveryNote(): ?string
    {
        $path_delivery_note = $this->getAttributeValue('path_delivery_note');
        if (is_null($path_delivery_note)) {
            return null;
        }

        return Storage::url($path_delivery_note);
    }

    /**
     * Retourne le fournisseur de la commande
     *
     * @return Supplier // Fournisseur de la commande
     */
    public function getSupplier(): Supplier
    {
        return $this->supplier()->getResults();
    }

    /**
     * Retourne le rôle correspondant au département de la commande
     *
     * @return Role // Département (rôle) de la commande
     */
    public function getDepartment(): Role
    {
        return $this->department()->getResults();
    }

    /**
     * Définir le titre d'une commande. Cela va automatiquement passer la première lettre en majuscule
     *
     * @param  string  $title  Titre à définir qui doit décrire la commande de manière assez concise (taille max de 255)
     */
    public function setTitle(string $title): void
    {
        // TODO Vérifier si cette solution sauvegarde correctement. Sinon faire en sorte que ça sauvegarde
        $this->setAttribute('title', ucfirst($title));
    }

    /**
     * Définir le numéro d'une commande.
     *
     * @param  string  $order_num  Numéro de commande à définir
     */
    public function setOrderNumber(string $order_num): void
    {
        $this->setAttribute('order_num', $order_num);
    }

    /**
     * Définir la déscription longue de la commande.
     *
     * @param  string  $description  Description de commande à définir
     */
    public function setDescription(string $description): void
    {
        $this->setAttribute('description', $description);
    }

    /**
     * Définir le coût en euros total de la commande.
     *
     * @param  float  $cost  Coût de la commande à définir
     */
    public function setCost(float $cost): void
    {
        $this->setAttribute('cost', $cost);
    }

    /**
     * Définir le numéro du devis la commande.
     *
     * @param  string  $quote_num  Coût de la commande à définir
     */
    public function setQuoteNumber(string $quote_num): void
    {
        $this->setAttribute('quote_num', $quote_num);
    }

    // TODO peut-être un peut factoriser l'upload des fichiers mais... plus tard
    /**
     * Enregistrer le fichier du devis
     *
     * @param  Request  $request  : la requête HTTP issue du controlleur contenant le fichier à uploader
     * @return bool true si l'enregistrement du fichier a fonctionné, false sinon
     */
    public function uploadQuote(Request $request): bool
    {
        $request->validate([
            'file' => 'required|mimes:pdf,doc,docx|max:10240', // Max 10MB
        ]);

        if ($request->file()) {

            try {
                $originalName = $request->file->getOriginalName();

                if (! stripos($originalName, 'devis')) {
                    $fileName = 'Devis'.$originalName;
                }

                $this->path_quote = $request->file('file')->storeAs('uploads/orders/'.$this->order_num, $fileName, 'public'); // public -> a disk ?

                return ! is_null($this->path_quote);
            } catch (\Throwable $th) {
                error_log("Une erreur est survenue lors de l'enregistrement d'un bon de livraison : \n".$th->getMessage());
                report($th);

                return false;
            }

        }

        return false;
    }

    /**
     * Enregistrer le fichier du bon de commande
     *
     * @param  Request  $request  : la requête HTTP issue du controlleur contenant le fichier à uploader
     * @param  bool  $is_signed  : indique si le devis est signé ou non
     * @return bool true si l'enregistrement du fichier a fonctionné, false sinon
     */
    public function uploadPurchaseOrder(Request $request, bool $is_signed = false): bool
    {
        $request->validate([
            'file' => 'required|mimes:pdf,doc,docx|max:10240', // Max 10MB
        ]);

        if ($request->file()) {

            try {
                $originalName = $request->file->getOriginalName();

                if (! stripos($originalName, 'BonDeCommande')) {
                    $fileName = 'BonDeCommande'.$originalName;
                }

                $fileName = $originalName;
                if ($is_signed) {
                    $ext = $request->file('file')->getExtension();
                    $fileName = str_replace('.'.$ext, '(signe).'.$ext, $originalName);
                }

                $this->path_purchase_order = $request->file('file')->storeAs('uploads/orders/'.$this->order_num, $fileName, 'public'); // public -> a disk ?

                return ! is_null($this->path_purchase_order);
            } catch (\Throwable $th) {
                return false;
            }

        }

        return false;
    }

    /**
     * Enregistrer le fichier du bon de livraison
     *
     * @param  Request  $request  : la requête HTTP issue du controlleur contenant le fichier à uploader
     * @return bool true si l'enregistrement du fichier a fonctionné, false sinon
     */
    public function uploadDeliveryNote(Request $request): bool
    {
        $request->validate([
            'file' => 'required|mimes:pdf,doc,docx|max:10240', // Max 10MB
        ]);

        if ($request->file()) {

            try {
                $originalName = $request->file->getOriginalName();

                if (! stripos($originalName, 'BonDeLivraison')) {
                    $fileName = 'BonDeLivraison'.$originalName;
                }

                $this->path_delivery_note = $request->file('file')->storeAs('uploads/orders/'.$this->order_num, $fileName, 'public'); // public -> a disk ?

                return ! is_null($this->path_delivery_note);
            } catch (\Throwable $th) {
                error_log("Une erreur est survenue lors de l'enregistrement d'un bon de livraison : \n".$th->getMessage());
                report($th);

                return false;
            }

        }

        return false;
    }

    // TODO : Autre moyen de récupérer l'url d'un fichier (à tester)
    public function getUrlQuoteAlt(): ?string
    {
        if (is_null($this->path_quote)) {
            return null;
        }

        return asset('storage/'.$this->path_quote);
    }

    public function getUrlPurchaseOrderAlt(): ?string
    {
        if (is_null($this->path_purchase_order)) {
            return null;
        }

        return asset('storage/'.$this->path_purchase_order);
    }

    public function getUrlDeliveryNoteAlt(): ?string
    {
        if (is_null($this->path_delivery_note)) {
            return null;
        }

        return asset('storage/'.$this->path_delivery_note);
    }

    /**
     * Retourne la liste des colis de la commande
     *
     * @return HasMany // Liste des colis de la commande
     */
    public function packages(): HasMany
    {
        return $this->hasMany(Package::class);
    }

    /**
     * Retourne la liste le fournisseur de la commande
     *
     * @return BelongsTo // Fournisseur de la commande
     */
    public function supplier(): BelongsTo
    {
        return $this->belongsTo(Supplier::class);
    }

    /**
     * Retourne la liste des commentaires de la commande
     *
     * @return HasMany // Liste des commentaires de la commande
     */
    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class);
    }

    /**
     * Retourne la liste des actions associées à la commande
     *
     * @return HasMany // Liste des actions de la commande
     */
    public function logs(): HasMany
    {
        return $this->hasMany(Log::class);
    }

    /**
     * Retourne le rôle du département associé à la commande
     *
     * @return BelongsTo // Rôle du département
     */
    public function department(): BelongsTo
    {
        return $this->belongsTo(Role::class, 'department_id');
    }

    // TODO
    // /**
    //  * Retourne le nom du service/département à l'origine de la commande
    //  *
    //  * @return string // Nom du service/département
    //  */
    // public function getService(): string {}
    //
    // /**
    //  * Retourne l'utilisateur à l'origine de la commande
    //  *
    //  * @return User // Nom du service/département
    //  */
    // public function getUser(): User {}
    //
    // /**
    //  * Retourne la date de la dernière modification de la commande
    //  *
    //  * @return int // date
    //  */
    // public function getLastUpdateDate(): int {}
    //
    // /**
    //  * Retourne la date de création de la commande
    //  *
    //  * @return int // date
    //  */
    // public function getCreationDate(): int {}

    // Pas prioritaire - TODO
    // j'ai mis pleins d'options de recherche mais pas obliger de toutes les coder si on manque de temps
    //
    // /**
    //  * Récupérer le log d'une commande à partir d'un indice
    //  *
    //  * @param  int  $indexToSearch  Indice dans la liste des logs de la commande
    //  * @return array // ligne de log
    //  */
    // public function getLog(int $indexToSearch): string {}
    //
    // /**
    //  * Récupérer les logs d'une commande
    //  *
    //  * @return array // tableau de lignes de logs
    //  */
    // public function getLogs(): array {}
    //
    // // /**
    // //  * Récupérer les logs d'une commande contenant un certain texte
    // //  *
    // //  * @param  string  $valueToSearch  récupérer tous les logs contenant une chaîne de caractère en particulier
    // //  * @return array // tableau de lignes de logs
    // //  */
    // // public function getLogsWithText(string $valueToSearch) {}
    //
    // /**
    //  * Ajouter un log
    //  *
    //  * @param  User  $author  Auteur de l'action à l'origine du log
    //  * @param  string  $text  Contenu du log
    //  * @return void
    //  */
    // public function addLog(User $author, string $text) {}
    //
    // /**
    //  * Retirer un log
    //  *
    //  * @param  int  $index  Indice du log
    //  * @return void
    //  */
    // public function removeLog(int $index) {}
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class Order extends Model
{
    use \Illuminate\Database\Eloquent\Factories\HasFactory;

    // Source - https://stackoverflow.com/a
    // Posted by Sameer Shaikh, modified by community. See post 'Timeline' for change history
    // Retrieved 2025-12-26, License - CC BY-SA 4.0

    public $timestamps = false;

    protected $fillable = [
        'label',
        'description',
        'cost',
        'quote_num',
        'path_quote',
        'path_purchase_order',
        'path_delivery_note',
        'states',
    ];

    public function getSupplier()
    {
        return $this->belongsTo(Supplier::class);
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
}

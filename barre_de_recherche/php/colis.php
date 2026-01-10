<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Colis extends Model
{
    protected $table = 'colis';
    protected $primaryKey = 'id_colis';

    protected $fillable = [
        'label',
        'cout',
        'date_reception',
        'date_livraison'
    ];
}

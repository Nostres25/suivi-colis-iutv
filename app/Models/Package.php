<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Package extends Model
{
    use \Illuminate\Database\Eloquent\Factories\HasFactory;

    // Source - https://stackoverflow.com/a
    // Posted by Sameer Shaikh, modified by community. See post 'Timeline' for change history
    // Retrieved 2025-12-26, License - CC BY-SA 4.0

    public $timestamps = false;

    protected $fillable = [
        'label',
        'cost',
        'date_expected_delivery',
        'shipping_date',
    ];
}

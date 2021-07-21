<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductAndServiceValues extends Model
{
    protected $table = 'products_and_services_values';

    protected $fillable = [
        'products_and_services_id',
        'maximum_parcels',
        'value',
        'date_start',
        'date_end',
    ];
}

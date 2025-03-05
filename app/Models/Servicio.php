<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Servicio extends Model
{
    use HasFactory;

    /**
     * table
     *
     * @var string
     */
    protected $table = 'services';

    /**
     * fillable
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'price_net',
        'price_iva',
        'price_subtotal',
        'price_total',
        'description',
    ];

    /**
     * hidden
     *
     * @var array
     */
    protected $hidden = [
        'created_at',
        'updated_at',
        'deleted_at'
    ];


}

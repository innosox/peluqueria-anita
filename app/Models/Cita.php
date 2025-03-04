<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cita extends Model
{
    use HasFactory;


    /**
     * table
     *
     * @var string
     */
    protected $table = 'appointments';

    /**
     * fillable
     *
     * @var array
     */
    protected $fillable = [
        'customer_id',
        'service_id',
        'appointment_date',
        'appointment_time',
        'status',
        'reason',
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

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

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

    /**
     * cliente
     *
     * @return BelongsTo
     */
    public function cliente() : BelongsTo
    {
        return $this->belongsTo(Cliente::class, 'customer_id');
    }

    /**
     * servicio
     *
     * @return BelongsTo
     */
    public function servicio() : BelongsTo
    {
        return $this->belongsTo(Servicio::class, 'service_id');
    }


}

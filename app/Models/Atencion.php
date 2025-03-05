<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Atencion extends Model
{
    use HasFactory;

    /**
     * table
     *
     * @var string
     */
    protected $table = 'attentions';

    /**
     * fillable
     *
     * @var array
     */
    protected $fillable = [
        'appointment_id',
        'service_id',
        'detail',
        'price',
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
     * cita
     *
     * @return BelongsTo
     */
    public function cita() : BelongsTo
    {
        return $this->belongsTo(Cita::class, 'appointment_id');
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

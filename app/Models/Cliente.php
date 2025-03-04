<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    use HasFactory;

    /**
     * table
     *
     * @var string
     */
    protected $table = 'customer';

    /**
     * fillable
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'identificacion',
        'email',
        'phone',
        'birthday',
        'address',
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

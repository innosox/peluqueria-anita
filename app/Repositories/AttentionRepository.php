<?php

namespace App\Repositories;

use App\Models\Atencion;
use App\Repositories\Base\BaseRepository;

/**
 * AttentionRepository
 */
class AttentionRepository extends BaseRepository
{

    /**
     * relations
     *
     * @var array
     */
    protected $relations = ['cita.cliente', 'servicio'];

    /**
     * __construct
     *
     * @return void
     */
    public function __construct(Atencion $attention)
    {
        parent::__construct($attention);

    }


}

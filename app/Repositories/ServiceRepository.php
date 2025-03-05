<?php

namespace App\Repositories;

use App\Models\Servicio;
use App\Repositories\Base\BaseRepository;

/**
 * ServiceRepository
 */
class ServiceRepository extends BaseRepository
{

    /**
     * relations
     *
     * @var array
     */
    protected $relations = [];

    /**
     * __construct
     *
     * @return void
     */
    public function __construct(Servicio $services)
    {
        parent::__construct($services);
    }


}

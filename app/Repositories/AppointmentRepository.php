<?php

namespace App\Repositories;

use App\Models\Cita;
use App\Repositories\Base\BaseRepository;

/**
 * AppointmentRepository
 */
class AppointmentRepository extends BaseRepository
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
    public function __construct(Cita $appointment)
    {
        parent::__construct($appointment);
    }


}

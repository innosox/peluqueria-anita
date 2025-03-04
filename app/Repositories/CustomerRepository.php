<?php

namespace App\Repositories;

use App\Models\Cliente;
use App\Repositories\Base\BaseRepository;

/**
 * CustomerRepository
 */
class CustomerRepository extends BaseRepository
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
    public function __construct(Cliente $customers)
    {
        parent::__construct($customers);
    }


}

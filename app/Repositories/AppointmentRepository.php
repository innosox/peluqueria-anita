<?php

namespace App\Repositories;

use App\Models\Cita;
use App\Models\Cliente;
use App\Repositories\Base\BaseRepository;
use Illuminate\Http\Request;

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
    protected $relations = ['cliente', 'servicio'];

    /**
     * __construct
     *
     * @return void
     */
    public function __construct(Cita $appointment)
    {
        parent::__construct($appointment);
    }

    public function getAppointmentsByCustomer(Request $request, Cliente $cliente)
    {

        // Base query con relaciones
        $query = $this->model->with($this->relations);
        $query->where('customer_id', $cliente->id);

        // Filtro por estado (por defecto: "realizada")
        if ($request->has('status')) {
            $query->where('status', $request->status);
        }

        // Ordenamiento (por defecto: cliente ascendente)
        $orderBy = $request->input('order_by', 'customer_id');
        $orderDirection = $request->input('id', 'asc');
        $query->orderBy($orderBy, $orderDirection);

        return $query->get();
    }


}

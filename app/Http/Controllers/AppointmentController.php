<?php

namespace App\Http\Controllers;

use App\Exceptions\Custom\ConflictException;
use App\Http\Requests\Appointment\AppointmentRequest;
use App\Http\Requests\Appointment\AppointmentStoreRequest;
use App\Models\Cita;
use App\Models\Cliente;
use App\Repositories\AppointmentRepository;
use App\Repositories\CustomerRepository;
use App\Traits\RestResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Throwable;

class AppointmentController extends Controller
{

    use RestResponse;

    /**
     * @var AppointmentRepository
     */
    private $appointmentRepository;

    /**
     * @var CustomerRepository
     */
    private $customerRepository;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(
        AppointmentRepository $appointmentRepository,
        CustomerRepository $customerRepository
        )
    {
        $this->appointmentRepository = $appointmentRepository;
        $this->customerRepository = $customerRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function index(Request $request) : JsonResponse
    {
        return $this->success(
            $this->appointmentRepository->all($request)
        );
    }

   /**
     * Store a newly created resource in storage.
     *
     * @param AppointmentRequest $request
     * @return JsonResponse
     */
    public function store(AppointmentRequest $request) : JsonResponse
    {
        DB::beginTransaction();
        try {
            $appointment = new Cita($request->all());
            $appointment = $this->appointmentRepository->save($appointment);
            DB::commit();
            return $this->success(
                $appointment, Response::HTTP_CREATED
            );

        } catch (Throwable $e) {
            DB::rollBack();
            throw new ConflictException($e->getMessage());
        }
    }


    /**
     * Display the specified resource.
     *
     * @param Cita $appointment
     * @return JsonResponse
     */
    public function show(Cita $appointment) : JsonResponse
    {
        return $this->success(
            $this->appointmentRepository->find($appointment->id)
        );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param AppointmentRequest $request
     * @param Cita $appointment
     * @return JsonResponse
     */
    public function update(AppointmentRequest $request, Cita $appointment) : JsonResponse
    {
        $appointment->fill($request->all());

        if ($appointment->isClean()) {
            return $this->information(__('messages.nochange'));
        }

        return $this->success(
            $this->appointmentRepository->save($appointment)
        );
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Cita $appointment
     * @return JsonResponse
     */
    public function destroy(Cita $appointment) : JsonResponse
    {
        return $this->success(
            $this->appointmentRepository->destroy($appointment)
        );
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param AppointmentStoreRequest $request
     * @return JsonResponse
     */
    public function generateAppointment(AppointmentStoreRequest $request) : JsonResponse
    {
        DB::beginTransaction();
        try {

            $customer = new Cliente($request->all());
            $customer = $this->customerRepository->save($customer);

            $appointment = new Cita($request->all() + ['customer_id' => $customer->id]);
            $appointment = $this->appointmentRepository->save($appointment);

            DB::commit();
            return $this->success(
                $appointment, Response::HTTP_CREATED
            );

        } catch (Throwable $e) {
            DB::rollBack();
            throw new ConflictException($e->getMessage());
        }
    }


    public function getAppointmentsByCustomer(Request $request, Cliente $cliente) : JsonResponse
    {
        return $this->success(
            $this->appointmentRepository->getAppointmentsByCustomer($request, $cliente)
        );
    }




}

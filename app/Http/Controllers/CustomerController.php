<?php

namespace App\Http\Controllers;

use App\Exceptions\Custom\ConflictException;
use App\Http\Requests\Customer\CustomerRequest;
use App\Http\Requests\Customer\CustomerUpdateRequest;
use App\Models\Cliente;
use App\Repositories\CustomerRepository;
use App\Traits\RestResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Throwable;

class CustomerController extends Controller
{
    use RestResponse;

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
        CustomerRepository $customerRepository
        )
    {
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
            $this->customerRepository->all($request)
        );
    }

   /**
     * Store a newly created resource in storage.
     *
     * @param CustomerRequest $request
     * @return JsonResponse
     */
    public function store(CustomerRequest $request) : JsonResponse
    {
        DB::beginTransaction();
        try {
            $customer = new Cliente($request->all());
            $customer = $this->customerRepository->save($customer);
            DB::commit();
            return $this->success(
                $customer, Response::HTTP_CREATED
            );

        } catch (Throwable $e) {
            DB::rollBack();
            throw new ConflictException($e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param Cliente $customer
     * @return JsonResponse
     */
    public function show(Cliente $customer) : JsonResponse
    {
        return $this->success(
            $this->customerRepository->find($customer->id)
        );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param CustomerUpdateRequest $request
     * @param Cliente $customer
     * @return JsonResponse
     */
    public function update(CustomerUpdateRequest $request, Cliente $customer) : JsonResponse
    {
        $customer->fill($request->all());

        if ($customer->isClean()) {
            return $this->information(__('messages.nochange'));
        }

        return $this->success(
            $this->customerRepository->save($customer)
        );
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Cliente $customer
     * @return JsonResponse
     */
    public function destroy(Cliente $customer) : JsonResponse
    {
        return $this->success(
            $this->customerRepository->destroy($customer)
        );
    }


}

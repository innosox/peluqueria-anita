<?php

namespace App\Http\Controllers;

use App\Repositories\ServiceRepository;
use App\Traits\RestResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    use RestResponse;


    /**
     * @var ServiceRepository
     */
    private $serviceRepository;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(
        ServiceRepository $serviceRepository
        )
    {
        $this->serviceRepository = $serviceRepository;
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
            $this->serviceRepository->all($request)
        );
    }


}

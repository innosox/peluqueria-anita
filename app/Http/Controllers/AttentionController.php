<?php

namespace App\Http\Controllers;

use App\Exceptions\Custom\ConflictException;
use App\Http\Requests\Attention\AttentionRequest;
use App\Models\Atencion;
use App\Repositories\AttentionRepository;
use App\Traits\RestResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Throwable;

class AttentionController extends Controller
{

    use RestResponse;

    /**
     * @var AttentionRepository
     */
    private $attentionRepository;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(
        AttentionRepository $attentionRepository
        )
    {
        $this->attentionRepository = $attentionRepository;
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
            $this->attentionRepository->all($request)
        );
    }

   /**
     * Store a newly created resource in storage.
     *
     * @param AttentionRequest $request
     * @return JsonResponse
     */
    public function store(AttentionRequest $request) : JsonResponse
    {
        DB::beginTransaction();
        try {
            $attention = new Atencion($request->all());
            $attention = $this->attentionRepository->save($attention);
            DB::commit();
            return $this->success(
                $attention, Response::HTTP_CREATED
            );

        } catch (Throwable $e) {
            DB::rollBack();
            throw new ConflictException($e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param Atencion $attention
     * @return JsonResponse
     */
    public function show(Atencion $attention) : JsonResponse
    {
        return $this->success(
            $this->attentionRepository->find($attention->id)
        );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param attentionRequest $request
     * @param Atencion $attention
     * @return JsonResponse
     */
    public function update(attentionRequest $request, Atencion $attention) : JsonResponse
    {
        $attention->fill($request->all());

        if ($attention->isClean()) {
            return $this->information(__('messages.nochange'));
        }

        return $this->success(
            $this->attentionRepository->save($attention)
        );
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Atencion $attention
     * @return JsonResponse
     */
    public function destroy(Atencion $attention) : JsonResponse
    {
        return $this->success(
            $this->attentionRepository->destroy($attention)
        );
    }



}

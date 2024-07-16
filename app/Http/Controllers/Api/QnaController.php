<?php

namespace App\Http\Controllers\Api;

use App\Models\Qna;
use App\Services\Api\QnaService;
use App\Services\Api\QnatService;
use Illuminate\Http\JsonResponse;
use App\Http\Resources\Api\QnaResource;
use App\Http\Controllers\Api\ApiController;

class QnaController extends ApiController
{
    /**
     * Qna Controller Constructor.
     *
     * @param QnaService $service
     */
    public function __construct(public QnaService $service) {}

    /**
     * List all qnas.
     *
     * @return JsonResponse
     */
    public function index() : JsonResponse
    {
        $qnas = $this->service->getAllQnas();
        return $this->setApiResponse(true, 200, QnaResource::collection($qnas), trans("qnas.api.qnas_retrived"));
    }

    /**
     * Get Qna using id.
     *
     * @param id $qna_id
     * @return JsonResponse
     */
    public function show(int $qna_id) : JsonResponse
    {
        $qna = $this->service->getQnaUsingID($qna_id);
        return $this->setApiResponse(true, 200, new QnaResource($qna), trans("qnas.api.qna_retrived"));
    }
}

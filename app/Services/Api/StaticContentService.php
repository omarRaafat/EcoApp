<?php

namespace App\Services\Api;

use App\Http\Resources\Api\StaticContentResource;
use App\Models\StaticContent;
use App\Repositories\StaticContentRepository;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class StaticContentService
{
    /**
     * StaticContent Service Constructor.
     *
     * @param StaticContentRepository $repository
     */
    public function __construct(public StaticContentRepository $repository) {}

    /**
     * Get StaticContents.
     *
     * @return Collection
     */
    public function getAllStaticContents($type)
    {
        $StaticContents = $this->repository->all()
        ->where('type',$type)->get();
        return  StaticContentResource::Collection($StaticContents)->additional([
            "success" => true,
            "status" => 200,
            "message"=> trans("static_content.api.StaticContent.retrived")
        ]);
    }

    /**
     * Get StaticContents with pagination.
     *
     * @param integer $perPage
     * @return LengthAwarePaginator
     */
    public function getAllStaticContentsWithPagination(int $perPage = 20)
    {
        $StaticContents = $this->repository->all()->paginate($perPage);
        $StaticContents->withPath("StaticContent");
        return StaticContentResource::collection($StaticContents)->additional([
            "success" => true,
            "status" => 200,
            "message"=> trans("static_content.api.StaticContent.retrived")
        ]);
        
    }

    /**
     * Get StaticContent using ID.
     *
     * @param integer $id
     * @return StaticContent
     */
    public function getStaticContentUsingID(int $id) 
    {
        $StaticContent = $this->repository->getModelUsingID($id);
        if($StaticContent != null)
        {
            return [
                'success'=>true,
                'status'=>200 ,
                'data'=> new StaticContentResource($StaticContent),
                'message'=>__('static_content.api.StaticContent.retrived')
            ];
        }
        return [
            'success'=>false,
            'status'=>404 ,
            'data'=> [],
            'message'=>__('static_content.api.StaticContent.not_found')
        ];
    }
}

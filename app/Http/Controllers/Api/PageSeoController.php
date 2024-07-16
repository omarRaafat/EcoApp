<?php
namespace App\Http\Controllers\Api;

use App\Enums\PageSeoEnum;
use App\Models\PageSeo;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class PageSeoController extends ApiController
{
    public function getPageSeo($page) : JsonResponse {
        if (!in_array($page, PageSeoEnum::pages())) return $this->emptyResponse();

        $pageSeo = PageSeo::where("page", $page)->first();
        if (!$pageSeo) return $this->emptyResponse();

        return $this->setApiResponse(
            true,
            Response::HTTP_OK,
            [
                "tags" => $pageSeo->getTranslation("tags", app()->getLocale()),
                "description" => $pageSeo->getTranslation("description", app()->getLocale())
            ],
            "success"
        );
    }

    private function emptyResponse() : JsonResponse {
        return $this->setApiResponse(
            true,
            Response::HTTP_OK,
            ["tags" => "", "description" => "",],
            "not found"
        );
    }
}

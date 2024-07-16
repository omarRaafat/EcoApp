<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\Admin\StaticContentService;

class AboutUsContentController extends Controller
{
    use StaticContentShared;

    private const routeBase = 'admin.about-us';
    private const translateBase = 'admin.static-content.about-us';

    /**
     * @param StaticContentService $service
     */
    public function __construct(
        public StaticContentService $service,
    ) {}

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $collection = $this->service->getAboutUsPaginated(20, request()->get('search') ?? "");
        return view(
            "admin.static-content.index",
            ['collection' => $collection, 'routeBase' => self::routeBase, 'translateBase' => self::translateBase]
        );
    }

    private function getRouteBase() {
        return self::routeBase;
    }

    private function getTranslateBase() {
        return self::translateBase;
    }

    private function getModelType() {
        return "about";
    }

    private function getBreadcrumb() {
        return "admin.about-us.index";
    }

    private function getBreadcrumbUrl() {
        return route('admin.about-us.index');
    }
}

<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\Admin\StaticContentService;

class UsageAgreementContentController extends Controller
{
    use StaticContentShared;

    private const routeBase = 'admin.usage-agreement';
    private const translateBase = 'admin.static-content.usage-agreement';

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
        $collection = $this->service->getUsageAndAgreementPaginated(20, request()->get('search') ?? "");
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
        return "usage";
    }

    private function getBreadcrumb() {
        return "admin.usage-agreement.index";
    }

    private function getBreadcrumbUrl() {
        return route('admin.usage-agreement.index');
    }
}

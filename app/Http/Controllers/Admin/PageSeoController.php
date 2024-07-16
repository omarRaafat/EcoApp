<?php

namespace App\Http\Controllers\Admin;

use App\Enums\PageSeoEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\PageSeo as PageSeoRequests;
use App\Models\PageSeo;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use RealRashid\SweetAlert\Facades\Alert;

class PageSeoController extends Controller
{
    public function index() : View
    {
        return view(
            "admin.page-seo.index",
            ['collection' => PageSeo::descOrder()->paginate(10)]
        );
    }

    public function create() : View
    {
        return view("admin.page-seo.create", [
            "breadcrumbParent" => "admin.page-seo.index",
            "breadcrumbParentUrl" => route('admin.page-seo.index'),
            "pages" => PageSeoEnum::pages(),
        ]);
    }

    public function store(PageSeoRequests\Create $request) : RedirectResponse
    {
        $data = $request->validated();
        $data['created_by'] = auth()->id();
        PageSeo::create($data);
        Alert::success(__('page-seo.created.title'), __('page-seo.created.body'));
        return redirect(route("admin.page-seo.index"));
    }

    public function show(PageSeo $pageSeo) : View
    {
        return view("admin.page-seo.show", [
            "breadcrumbParent" => "admin.page-seo.index",
            "breadcrumbParentUrl" => route('admin.page-seo.index'),
            "model" => $pageSeo
        ]);
    }

    public function edit(PageSeo $pageSeo) : View
    {
        return view("admin.page-seo.edit", [
            "breadcrumbParent" => "admin.page-seo.index",
            "breadcrumbParentUrl" => route('admin.page-seo.index'),
            "pages" => PageSeoEnum::pages(),
            "model" => $pageSeo
        ]);
    }

    public function update(PageSeoRequests\Update $request, PageSeo $pageSeo) : RedirectResponse
    {
        $data = $request->validated();
        $data['edited_by'] = auth()->id();
        $pageSeo->update($data);
        Alert::success(__('page-seo.edited.title'), __('page-seo.edited.body'));
        return redirect(route("admin.page-seo.index"));
    }

    public function destroy(PageSeo $pageSeo) : RedirectResponse
    {
        $pageSeo->delete();
        Alert::success(__('page-seo.deleted.title'), __('page-seo.deleted.body'));
        return redirect()->back();
    }
}

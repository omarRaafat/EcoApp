<?php
namespace App\Http\Controllers\Admin;

use App\Http\Requests\Admin\StaticContentRequest;
use RealRashid\SweetAlert\Facades\Alert;

trait StaticContentShared {
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view(
            "admin.static-content.create",
            ['routeBase' => $this->getRouteBase(), 'translateBase' => $this->getTranslateBase(), "breadcrumbParent" => $this->getBreadcrumb(), "breadcrumbParentUrl" => $this->getBreadcrumbUrl()]
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  StaticContentRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StaticContentRequest $request)
    {
        $this->service->create($request, $this->getModelType());
        Alert::success(__('admin.static-content.messages.success'), __('admin.static-content.messages.section-created'));
        return redirect(route($this->getRouteBase().'.index'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return view(
            "admin.static-content.show",
            ['translateBase' => $this->getTranslateBase(), 'model' => $this->service->show($id), "breadcrumbParent" => $this->getBreadcrumb(), "breadcrumbParentUrl" => $this->getBreadcrumbUrl()]
        );
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return view(
            "admin.static-content.edit",
            ['routeBase' => $this->getRouteBase(), 'translateBase' => $this->getTranslateBase(), 'model' => $this->service->show($id), "breadcrumbParent" => $this->getBreadcrumb(), "breadcrumbParentUrl" => $this->getBreadcrumbUrl()]
        );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param StaticContentRequest $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(StaticContentRequest $request, $id)
    {
        $this->service->update($id, $request);
        Alert::success(__('admin.static-content.messages.success'), __('admin.static-content.messages.section-updated'));
        return redirect(route($this->getRouteBase().'.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if ($this->service->delete($id)) {
            Alert::success(__('admin.static-content.messages.success'), __('admin.static-content.messages.section-deleted'));
        } else {
            Alert::warning(__('admin.static-content.messages.warning'), __('admin.static-content.messages.section-not-deleted'));
        }
        return redirect(route($this->getRouteBase().'.index'));

    }
}

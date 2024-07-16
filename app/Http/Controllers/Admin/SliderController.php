<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Slider\CreateRequest;
use App\Http\Requests\Admin\Slider\UpdateRequest;
use App\Models\Slider;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use RealRashid\SweetAlert\Facades\Alert;

class SliderController extends Controller
{
    /**
     * @return View
     */
    public function index() : View {
        $request = request();
        $sliders = Slider::descOrder()->paginate(10);
        return view("admin.slider.index",compact('sliders'));
    }

    /**
     * @param integer $id
     * @return View
     */
    public function show(int $id) : View {
        $Slider = Slider::findOrFail($id);
        return view("admin.slider.show", compact('Slider'));
    }

    /**
     * @return View
     */
    public function create() : View {
        $breadcrumbParent = 'admin.slider.index';
        $breadcrumbParentUrl = route('admin.slider.index');
        // TODO: must be changed when go live with 5 langs
        $locales = [
            "ar" => trans("translation.arabic"),
            "en" => trans("translation.english"),
        ];

        return view('admin.slider.create', compact(
            "breadcrumbParent", "breadcrumbParentUrl", "locales"
        ));
    }

    public function store(CreateRequest $request) {
        $slider = Slider::create($request->validated());

        $slider->addMediaFromDisk($slider->image, 'root-public')
            ->preservingOriginal()
            ->toMediaCollection(Slider::mediaCollectionName);

        Alert::success(
            trans("admin.sliders.messages.created_successfully_title"),
            trans("admin.sliders.messages.created_successfully_body")
        );
        return redirect()->route("admin.slider.index");
    }

    /**
     * @param integer $id
     * @return View
     */
    public function edit(int $id) : View {
        $model =  Slider::findOrFail($id);
        $breadcrumbParent = 'admin.slider.index';
        $breadcrumbParentUrl = route('admin.slider.index');
        // TODO: must be changed when go live with 5 langs
        $locales = [
            "ar" => trans("translation.arabic"),
            "en" => trans("translation.english"),
        ];

        return view("admin.slider.edit", compact(
            'model', "breadcrumbParent", "breadcrumbParentUrl", "locales"
        ));
    }

    /**
     * @param UpdateRequest $request
     * @param integer $id
     * @return RedirectResponse
     */
    public function update(UpdateRequest $request, int $id) : RedirectResponse {
        $slider =  Slider::findOrFail($id);
        $slider->update($request->validated());

       /* if ($request->hasFile("image")) {
            $slider->clearMediaCollection(Slider::mediaCollectionName);
            $slider->addMediaFromDisk($slider->image, 'root-public')
                ->preservingOriginal()
                ->toMediaCollection(Slider::mediaCollectionName);
        }*/

        Alert::success(
            trans("admin.sliders.messages.updated_successfully_title"),
            trans("admin.sliders.messages.updated_successfully_body")
        );

        return redirect()->route("admin.slider.index");
    }

    /**
     * @param integer $id
     * @return RedirectResponse
     */
    public function destroy(int $id) : RedirectResponse {
        $slider = Slider::findOrFail($id);
        $slider->media()?->delete();
        $slider->delete();

        Alert::success(
            trans("admin.sliders.messages.deleted_successfully_title"),
            trans("admin.sliders.messages.deleted_successfully_message")
        );

        return redirect()->route('admin.slider.index');
    }
}

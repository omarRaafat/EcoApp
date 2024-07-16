<?php

namespace App\Http\Controllers\Admin;

use App\Models\ClientMessage;
use Illuminate\Contracts\View\View;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ClientMessage\UpdateClientMessage;
use RealRashid\SweetAlert\Facades\Alert;

class ClientMessageController extends Controller
{
    public function index() : View {
        $collection = ClientMessage::descOrder()->paginate(15);
        return view("admin.client-messages.index", ['collection' => $collection]);
    }

    public function edit(ClientMessage $clientMessage) : View {
        $breadcrumbParent = 'admin.client-messages.index';
        $breadcrumbParentUrl = route('admin.client-messages.index');
        return view("admin.client-messages.edit", [
            'clientMessage' => $clientMessage,
            'breadcrumbParent' => $breadcrumbParent,
            'breadcrumbParentUrl' => $breadcrumbParentUrl,
        ]);
    }

    public function update(UpdateClientMessage $request, ClientMessage $clientMessage) {
        $clientMessage->update(['message' => $request->get("message")]);

        Alert::success(__("client-messages.edited.title"), __("client-messages.edited.body"));
        return redirect(route("admin.client-messages.index"));
    }
}

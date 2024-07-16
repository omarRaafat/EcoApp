<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Certificate;
use App\Models\CertificateVendor;
use Illuminate\Support\Facades\Validator;

class CertificateController extends Controller
{
    public function index(Request $request)
    {
        $certificates = Certificate::with('requests')->orderBy('id', 'desc')->paginate(10);

        return view('admin.certificate.index',['certificates' => $certificates]);
    }

    public function add()
    {
        return view('admin.certificate.add', [
            'breadcrumbParent' => 'admin.certificates.index',
            'breadcrumbParentUrl' => route('admin.certificates.index')
        ]);
    }

    public function store(Request $request)
    {
        $certificate_attributes = request()->all();
        $validator = Validator::make($certificate_attributes, [
            'title.*' => ['required', 'string', 'max:255'],
            'image' => ['required', 'image','mimes:jpeg,png,jpg,gif,svg', 'max:2048'],

        ]);
        if ($validator->fails())
        {
            return back()->withErrors($validator)->withInput();
        }
        Certificate::create($certificate_attributes);
        return redirect('admin/certificates/');
    }

    public function edit(Certificate $certificate)
    {
        return view('admin.certificate.edit',[
            'certificate' => $certificate,
            'breadcrumbParent' => 'admin.certificates.index',
            'breadcrumbParentUrl' => route('admin.certificates.index')
        ]);
    }

    public function update(Certificate $certificate)
    {
        $certificate_attributes = request()->all();
        $validator = Validator::make($certificate_attributes, [
            'title.*' => ['required', 'string', 'max:255']
        ]);
        if ($validator->fails())
        {
            return back()->withErrors($validator)->withInput();
        }

        $certificate->update($certificate_attributes);
        return redirect('admin/certificates/');
    }

    public function destroy(Certificate $certificate)
    {
        $certificate->delete();
        return redirect('admin/certificates/');
    }

    public function requests(Certificate $certificate)
    {
        $certificate_requests = CertificateVendor::whereIn('approval', ['pending','approved'])
            ->where('certificate_id',$certificate->id)
            ->orderByRaw("approval = 'pending' DESC")
            ->paginate(10);

        return view('admin.certificate.requests',[
            'certificate_requests' => $certificate_requests,
            'breadcrumbParent' => 'admin.certificates.index',
            'breadcrumbParentUrl' => route('admin.certificates.index')
        ]);
    }

    public function approve(CertificateVendor $certificate_request)
    {
        $certificate_request->approval = 'approved';
        $message = __('admin.certificate_approve');
        $certificate_request->save();
        return response()->json(['status' => 'success','data' => $certificate_request->approval,'message' => $message],200);
    }

    public function reject(CertificateVendor $certificate_request)
    {
        $certificate_request->approval = 'rejected';
        $message = __('admin.certificate_reject');
        $certificate_request->save();
        return response()->json(['status' => 'success','data' => $certificate_request->approval,'message' => $message],200);
    }
}

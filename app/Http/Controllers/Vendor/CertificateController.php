<?php

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\Vendor\CertificateRepository;
use App\Repositories\Vendor\CertificateVendorRepository;
use App\Http\Requests\Vendor\CertificateRequest;
use App\DataTables\CertificateVendorDataTable;
use App\Models\CertificateVendor;

class CertificateController extends Controller
{
    public function __construct(public CertificateRepository $certificateRepository,public CertificateVendorRepository $certificateVendorRepository)
    {
        $this->view='vendor/certificates';
    }
    
    public function index(Request $request,CertificateVendorDataTable $certificateVendorDataTable)
    {
        return $certificateVendorDataTable->render('vendor.certificates.index',compact('request'));
    }
    public function create()
    {
        $data['certificates']=$this->certificateRepository->getCertificatesForSelect();
        return view($this->view.'/create',$data);
    }

    public function store(CertificateRequest $request)
    {
        $row=$this->certificateVendorRepository->store($request);
        return redirect('/vendor/certificates')->with('success',__('translation.certificate_vendor_created_successfully'));
    }

    public function edit(int $id)
    {
        $data['row']=$this->certificateVendorRepository->getModelUsingID($id);
        $data['certificates']=$this->certificateRepository->getCertificatesForSelect();
        return view($this->view.'/edit',$data);
    }

    public function update(CertificateRequest $request,$id)
    {
        $certificateVendor=$this->certificateVendorRepository->getModelUsingID($id);
        $this->certificateVendorRepository->update($request,$certificateVendor);
        return redirect('/vendor/certificates')->with('success',__('translation.certificate_vendor_updated_successfully'));
    }

    public function destroy($id)
    {
        $certificateVendor=$this->certificateVendorRepository->getModelUsingID($id);
        $this->certificateVendorRepository->delete($certificateVendor);
        return true;
    }
}

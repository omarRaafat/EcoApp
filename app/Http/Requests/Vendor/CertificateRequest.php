<?php

namespace App\Http\Requests\Vendor;

use Illuminate\Foundation\Http\FormRequest;
use App\Enums\UserTypes;

class CertificateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $user = auth()->check() ? auth()->user() : null;
        return $user ? ( $user->type == UserTypes::VENDOR || $user->type == UserTypes::SUBVENDOR ) : false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        $rules=[
            'expire_date'=>'required|date|after:now',
            'certificate_file'=>'required|max:10000|mimes:pdf,jpg,png,svg,JPG,jpeg,JPEG,PNG'
        ];
        if ($this->method()=='PATCH') {
            $rules['certificate_file']='max:10000|mimes:pdf,jpg,png,svg,JPG,jpeg,JPEG,PNG';
        }
        return $rules; 
    }
}

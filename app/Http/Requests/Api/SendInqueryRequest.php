<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;

class SendInqueryRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [

            'title'=>'required|min:3',
            'desc'=>'required|min:5',
            'category' => 'required|in:الشكاوى,الاستفسارات,الشكاوي',
            'name'=> 'nullable',
            'email'=> 'nullable|email',
            'phone'=> 'nullable|phone:AUTO',
            'file' => 'nullable|max:25600'
        ];
    }

    public function messages()
    {
        return [
            'name.required' => __('validation.name-required') ,
            'desc.required'  => __('validation.description-required'),
            'title.required'  => __('validation.title-required'),
            'title.min'  => __('validation.title-min'),
            'category.required'  => __('validation.category-required'),
            'type.in' =>__('validation.invalid_type'),
            'type.required'  => __('validation.type-required'),
            'email.required'  => __('validation.email-required'),
            'phone.required'  => __('validation.phone-required'),
            'phone.phone'  => __('validation.phone-not-valid'),
            'file.max'  => __('validation.extra-size-file'),
        ];
    }
    public function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'success'   => false,
            'message'   => __('validation.some_field_missing'),
            "status" => 422,
            'data'      => $validator->errors()

        ],422));
    }
}

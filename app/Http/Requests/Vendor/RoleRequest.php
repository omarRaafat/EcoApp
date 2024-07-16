<?php

namespace App\Http\Requests\Vendor;

use Illuminate\Foundation\Http\FormRequest;
use App\Enums\UserTypes;

class RoleRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $user = auth()->check() ? auth()->user() : null;
        return $user ? ($user->type == UserTypes::VENDOR || $user->type == UserTypes::SUBVENDOR) : false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'name.ar'=>'required',
            'permissions'=>'required|array'
        ];
    }
}

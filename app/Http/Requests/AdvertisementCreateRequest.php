<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AdvertisementCreateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'name'=>['required'],
            'duration'=>['required','numeric','min:1'],
            'link'=>['required'],
            'image'=>['required','image','max:2048','mimes:jpg,jpeg,gif,png'],
            'merchants'=>['required','array','min:1']
        ];
    }


    public function messages(): array
    {
        return [];
    }
}

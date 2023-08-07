<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AdvertisementUpdateRequest extends FormRequest
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
        $rules = [
            'name'=>['required'],
            'duration'=>['required','numeric','min:1'],
            'link'=>['required'],
            'merchants'=>['required','array','min:1'],
        ];


        if(!is_null($this->file('image'))) {
            $rules['image'] = ['required','image','max:2048','mimes:jpg,jpeg,gif,png'];
        }

        return $rules;
    }


    public function messages(): array
    {
        return [];
    }
}

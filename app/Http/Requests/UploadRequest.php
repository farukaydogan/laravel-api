<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UploadRequest extends FormRequest
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
     * @return array
     */
    public function rules()
    {
        return [
            'upLoadFile' => 'required|image|mimes:png,jpg,jpeg|max:5120',
        ];
    }

    public function messages()
    {
        return [
            'upLoadFile.required' => 'Dosya yükleme alanı doldurmak zorunludur!',
            'upLoadFile.image' => 'Yüklenen dosya image formatında olamalıdır!',
            'upLoadFile.mimes' => 'Yüklenen dosya png, jpg veya jpeg formatında olmalıdır!',
            'upLoadFile.max' => 'Dosya boyutu 5 Mbyte\'ı geçemez!',
        ];
        // return parent::messages(); // TODO: Change the autogenerated stub
    }
}

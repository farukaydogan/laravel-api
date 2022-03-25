<?php

namespace App\Http\Requests;

class UserStoreRequest extends BaseFormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        // return false; // varsayılan
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
            'email' => 'required|email|unique:users',
            'name' => 'required|string|max:50',
            'password' => 'required',
        ];
    }

    /* Örnek Kullanım
    public function messages()
    {
        return [
            'name.required' => 'İsim alanının doldurulması zorunludur.',
            'password.required' => 'Şifre alanının doldurulması zorunludur.',
            'email.required' => 'Email alanını doldurmak zorunludur.',
            'email.unique' => 'Bu email ile daha önce kayıt olunmuş. Lütfen başka bir email ile deneyiniz.',
        ];
    }
    */
}

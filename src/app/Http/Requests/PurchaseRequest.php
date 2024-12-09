<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PurchaseRequest extends FormRequest
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
            'payment_method' => 'required|string',
            'postcode' => 'required|regex:/^\d{3}-\d{4}$/',
            'address' => 'required|string',
            'build' => 'required|string',
        ];
    }

    public function messages()
    {
        return [
            'payment_method.required' => 'お支払い条件を選択してください',
            'postcode.required' => '郵便番号を入力してください',
            'postcode.regex' => 'ハイフンを入れて7桁で入力してください',
            'address.required' => '住所を入力してください',
            'build.required' => '建物名を入力してください',
        ];
    }
}

<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ExhibitionRequest extends FormRequest
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
            'name' => 'required|string',
            'description' => 'required|string|max:255',
            'img_url' => 'required|image|mimes:jpeg,png',
            'category' => 'required|string',
            'condition' => 'required|string',
            'price' => 'required|integer',
        ];
    }

    public function messages() {
        return [
            'name.required' => '商品名を入力してください',
            'description.required' => '商品説明を入力してください',
            'img_url.required' => '画像を選択してください',
            'img_url.mimes' => 'jpegもしくはpngで選択してください',
            'category.required' => 'カテゴリーを選択してください',
            'condition.required' => '状態を選択してください',
            'price.required' => '金額を入力してください',
        ];
    }
}

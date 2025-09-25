<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProductRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name'        => 'required|string|max:255',
            'price'       => 'required|numeric|min:0|max:10000',
            'season'   => 'required|array|min:1',
            'season.*' => 'exists:seasons,id',
            'description' => 'required|string|max:120',
            'image'       => 'nullable|image|mimes:jpeg,png|max:2048',
            'delete_image'=> 'nullable|in:0,1', // 削除フラグ
        ];
    }

    public function messages(): array
    {
        return [
            'name.required'        => '商品名を入力してください',
            'price.required'       => '値段を入力してください',
            'price.numeric'        => '数値で入力してください',
            'price.min'            => '0~10000円以内で入力してください',
            'price.max'            => '0~10000円以内で入力してください',
            'season.required'      => '季節を選択してください',
            'season.min'           => '季節を1つ以上選択してください',
            'description.required' => '商品説明を入力してください',
            'description.max'      => '120文字以内で入力してください',
            'image.image'          => '「.png」または「.jpeg」形式でアップロードしてください',
            'image.mimes'          => '「.png」または「.jpeg」形式でアップロードしてください',
        ];
    }

    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            $product = $this->route('product');
            $deleteImage = $this->input('delete_image');

            // 元画像がなく、かつ新しい画像もアップロードされていない場合はエラー
            if (!$this->hasFile('image') && (!$product->image || $deleteImage)) {
                $validator->errors()->add('image', '商品画像を登録してください');
            }
        });
    }
}
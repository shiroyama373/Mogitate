<?php

return [
    'required' => ':attribute は必須です。',
    'numeric' => ':attribute は数値で入力してください。',
    'image' => ':attribute は画像ファイルでなければなりません。',
    'mimes' => ':attribute は :values タイプのファイルでなければなりません。',
    'max' => [
        'file' => ':attribute のサイズは :max KB 以下でなければなりません。',
        'string' => ':attribute は :max 文字以内で入力してください。',
    ],
    'array' => ':attribute は配列でなければなりません。',
    'in' => ':attribute の値が正しくありません。',
    'min' => [
        'numeric' => ':attribute は :min 以上で入力してください。',
        'array' => ':attribute は :min 個以上選択してください。',
        'string' => ':attribute は :min 文字以上で入力してください。',
    ],
    'attributes' => [
        'name' => '商品名',
        'price' => '値段',
        'season' => '季節',
        'description' => '商品説明',
        'image' => '商品画像',
    ],
];

@extends('layouts.app')

@section('title', '商品登録ページ')

@section('css')
<link rel="stylesheet" href="{{ asset('css/create.css') }}">

@endsection

@section('content')
<div class="page-container">
    <h1 class="page-title">商品登録</h1>

    <form id="product-form" action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <!-- 商品名 -->
    <div class="form-group">
        <label class="form-label" for="name">商品名<span class="required">必須</span></label>
        <input type="text" name="name" id="name" placeholder="商品名を入力" value="{{ old('name') }}">
        @error('name')<p class="error">{{ $message }}</p>@enderror
    </div>


    <!-- 値段 -->
    <div class="form-group">
        <label class="form-label" for="price">値段<span class="required">必須</span></label>
        <input type="text" name="price" id="price" placeholder="値段を入力" value="{{ old('price') }}">
        <p class="error" id="price-error" style="color:red;font-size:14px;">
    {{ $errors->first('price') }}
    </p>
    </div>
        <!-- 商品画像 -->
    <div class="form-group">
        <label class="form-label">商品画像<span class="required">必須</span></label>

        <img id="image-preview" 
        src="{{ old('image_preview') }}" 
        style="display:{{ old('image_preview') ? 'block' : 'none' }}; max-width: 400px; margin-bottom: 10px;">

        <div class="file-select-wrapper">
            <input type="file" name="image" id="image" accept="image/png, image/jpeg" style="display:none;">
            <button type="button" id="select-file-btn" class="btn btn-secondary">ファイルを選択</button>
            <span id="file-name" style="margin-left: 10px;">選択されていません</span>
        </div>
        @error('image')<p class="error">{{ $message }}</p>@enderror
    </div>

        <!-- 季節 -->
    <div class="form-group">
        <label class="form-label">
        季節 <span class="required">必須</span>
        <span style="color: red; font-size: 0.9em;">  複数選択可 </span>
        </label>
        <div class="season-checkboxes">
            @foreach($allSeasons as $season)
            <label class="custom-radio">
                <input type="checkbox" name="season[]" value="{{ $season->id }}"
                    {{ (is_array(old('season')) && in_array($season->id, old('season'))) ? 'checked' : '' }}>
                <span class="checkmark"></span>
                {{ $season->name }}
            </label>
            @endforeach
        </div>
        @error('season')<p class="error">{{ $message }}</p>@enderror
    </div>
        <!-- 商品説明 -->
    <div class="form-group">
        <label class="form-label" for="description">商品説明<span class="required">必須</span></label>
        <textarea name="description" id="description" placeholder="商品の説明を入力">{{ old('description') }}</textarea>
        @error('description')<p class="error">{{ $message }}</p>@enderror
    </div>

        <!-- ボタン -->
        <div class="button-group">
            <a href="{{ route('products.index') }}" class="btn btn-secondary">戻る</a>
            <button type="submit" class="btn btn-primary">登録</button>
        </div>
    </form>
</div>

<script>
const input = document.getElementById('image');
const preview = document.getElementById('image-preview');
const btn = document.getElementById('select-file-btn');
const fileName = document.getElementById('file-name');

// ボタンをクリックしたらファイル選択
btn.addEventListener('click', () => input.click());

// ファイル選択時
input.addEventListener('change', e => {
    const file = e.target.files[0];
    if (file) {
        fileName.textContent = file.name; // ファイル名を表示
        fileName.style.display = 'inline';

        const reader = new FileReader();
        reader.onload = e => {
            preview.src = e.target.result;
            preview.style.display = 'block';
        };
        reader.readAsDataURL(file);
    } else {
        preview.src = '';
        preview.style.display = 'none';
        fileName.textContent = '';
        fileName.style.display = 'none';
    }
});

// ページ読み込み時にセッション画像があればプレビュー表示
document.addEventListener('DOMContentLoaded', function() {
    const tmpImage = "{{ session('image_tmp') }}";
    if (tmpImage) {
        preview.src = "/storage/" + tmpImage;
        preview.style.display = 'block';
    }
});

// 値段の入力チェック
const form = document.getElementById('product-form');
const priceInput = document.getElementById('price');

form.addEventListener('submit', function(e) {
    const priceError = document.getElementById('price-error');
    const value = priceInput.value.trim();

    if (!/^\d+$/.test(value)) {
        priceError.textContent = '数値で入力してください';
        // e.preventDefault(); ← 入力ミスの時だけ送信止めたいなら有効化
    } else if (parseInt(value) < 0 || parseInt(value) > 10000) {
        priceError.textContent = '0~10000円以内で入力してください';
        // e.preventDefault();
    } else {
        priceError.textContent = '';
    }
});
</script>

@endsection
@extends('layouts.app')

@section('title', '商品編集ページ')

@section('css')
<link rel="stylesheet" href="{{ asset('css/edit.css') }}">
@endsection

@section('content')
<div class="page-container">

    <!-- パンくず -->
    <nav class="breadcrumb">
        <a href="{{ route('products.index') }}">商品一覧</a> &gt;
        <span>{{ $product->name }}</span>
    </nav>

    <!-- 商品編集フォーム -->
    <form id="update-form" action="{{ route('products.update', $product) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        @php
            $deleteFlag = old('delete_image', 0);
            $previewImage = asset('images/no-image.png');

            if ($deleteFlag == 0 && $product->image) {
                $imagePath = 'products/' . $product->image;
                if (Storage::disk('public')->exists($imagePath)) {
                    $previewImage = asset('storage/' . $imagePath);
                }
            }

            if (old('image_url') && $deleteFlag == 0) {
                $previewImage = old('image_url');
            }
        @endphp

        <div class="product-page">

            <!-- 左: 画像 -->
            <div class="product-left">
                <div class="product-image">
                    <img id="preview" src="{{ $previewImage }}" style="{{ $previewImage ? '' : 'display:none;' }}">
                </div>

                <div class="file-wrapper">
                    <label for="image" class="custom-file-label">ファイルを選択</label>
                    <span id="image-name">{{ old('image_name', $product->image ?? '') }}</span>
                    <input type="file" name="image" id="image" hidden>
                </div>

                <input type="hidden" name="delete_image" id="delete_image" value="{{ old('delete_image', 0) }}">
                <input type="hidden" name="image_url" id="image_url" value="{{ old('image_url') }}">

                @if($product->image)
                    <button type="button" id="delete-image" class="btn btn-sm btn-outline-danger">ファイルを削除</button>
                @endif
                @error('image')<p class="error">{{ $message }}</p>@enderror
            </div>

            <!-- 右: 商品情報 -->
            <div class="product-right">
                <label for="name">商品名</label>
                <input type="text" name="name" value="{{ old('name', $product->name) }}">
                @error('name')<p class="error">{{ $message }}</p>@enderror

                <label for="price">値段</label>
                <input type="text" name="price" value="{{ old('price', $product->price) }}">
                @error('price')<p class="error">{{ $message }}</p>@enderror

                <label>季節</label>
                <div class="season-checkboxes">
                    @foreach($allSeasons as $season)
                    <label class="custom-radio">
                        <input type="checkbox" name="season[]" value="{{ $season->id }}"
                        {{ (isset($selectedSeasons) && in_array($season->id, $selectedSeasons)) ? 'checked' : '' }}>
                        <span class="checkmark"></span>
                        {{ $season->name }}
                    </label>
                    @endforeach
                </div>
                @error('season')<p class="error">{{ $message }}</p>@enderror
            </div>
        </div> 

        <!-- 商品説明 -->
        <div class="product-description">
            <label for="description">商品説明</label>
            <textarea name="description">{{ old('description', $product->description) }}</textarea>
            @error('description')<p class="error">{{ $message }}</p>@enderror
        </div>

        <!-- ボタンエリア -->
        <div class="button-wrapper center-buttons">
            <a href="{{ route('products.index') }}" class="btn btn-secondary">戻る</a>
            <button type="submit" class="btn btn-primary">変更を保存</button>

    <!-- 商品削除ボタン -->
        @if($product->image && !$errors->any())
        <button type="button" id="delete-product" class="btn btn-delete">
            <i class="fas fa-trash"></i>
        </button>
        @endif
    </div>

    <!-- 削除用のhiddenを追加 -->
    <input type="hidden" name="delete_flag" id="delete_flag" value="0">
</form>
</div>
@endsection

@section('scripts')
<script>
const input = document.getElementById('image');
const preview = document.getElementById('preview');
const nameSpan = document.getElementById('image-name');
const imageDeleteBtn = document.getElementById('delete-image'); // 画像削除
const productDeleteBtn = document.getElementById('delete-product'); // 商品削除
const deleteInput = document.getElementById('delete_image');
const hiddenUrl = document.getElementById('image_url');
const form = document.getElementById('update-form');
const deleteFlag = document.getElementById('delete_flag');


// 画像削除ボタン
if(imageDeleteBtn){
    imageDeleteBtn.addEventListener('click', function() {
        preview.style.display = 'none';
        input.value = '';
        nameSpan.textContent = '';
        deleteInput.value = 1;
        hiddenUrl.value = '';
        imageDeleteBtn.style.display = 'none';
    });
}

// 商品削除ボタン
if(productDeleteBtn){
    productDeleteBtn.addEventListener('click', function() {
        if (confirm("本当に削除しますか？")) {
            deleteFlag.value = 1; // 削除フラグON
            form.submit();        // PUTフォームを送信
        }
    });
}

// ファイル選択時のプレビュー更新
if(input){
    input.addEventListener('change', function() {
        if (this.files && this.files[0]) {
            const file = this.files[0];
            nameSpan.textContent = file.name;

            const reader = new FileReader();
            reader.onload = function(e) {
                preview.src = e.target.result;
                preview.style.display = 'block';
                hiddenUrl.value = e.target.result;
            };
            reader.readAsDataURL(file);
            deleteInput.value = 0;
        }
    });
}

</script>
@endsection
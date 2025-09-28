@extends('layouts.app')

@section('title', '商品編集ページ')

@section('css')
<link rel="stylesheet" href="{{ asset('css/show_edit.css') }}">
@endsection

@section('content')
<div class="page-container">

    <nav class="breadcrumb">
        <a href="{{ route('products.index') }}">商品一覧</a> &gt;
        <span>{{ $product->name }}</span>
    </nav>

    <form id="update-form" action="{{ route('products.update', $product) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        @php
            // 画像プレビュー用
            $previewImage = asset('images/no-image.png'); // デフォルト画像

if ($product->image) {
    $imagePath = 'products/' . $product->image;
    if (Storage::disk('public')->exists($imagePath)) {
        $previewImage = asset('storage/' . $imagePath);
    }
}
            // チェックボックスの選択状態
                $oldSeasons = old('season');

    if ($oldSeasons !== null) {
        $selectedSeasons = array_map('strval', (array)$oldSeasons);
    } else {
        // 初回表示時のみDBの値をセット
        $selectedSeasons = $product->seasons->pluck('id')->map(fn($i) => (string)$i)->toArray();
    }

    // バリデーションエラーで全てチェックを外して送信された場合に備えて
    // old('season') が null なら空配列にする
    if ($oldSeasons === null && $errors->any()) {
        $selectedSeasons = [];
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
        {{ in_array((string)$season->id, $selectedSeasons) ? 'checked' : '' }}>
    <span class="checkmark"></span>
    {{ $season->name }}
</label>
@endforeach
                </div>
                @error('season')<p class="error">{{ $message }}</p>@enderror
            </div>
        </div> 

        <!-- 商品説明 -->
        <div class="product-description-container">
            <div class="product-description">
                <label for="description">商品説明</label>
                <textarea name="description">{{ old('description', $product->description) }}</textarea>
                @error('description')<p class="error">{{ $message }}</p>@enderror
            </div>
        </div>

        <!-- ボタンエリア -->
        <div class="button-wrapper" style="display:flex; align-items:center; justify-content:center; gap:20px; margin-top:20px; position:relative;">
        <!-- 中央ボタン -->
        <div class="button-wrapper">
            <div class="button-center">
                <a href="{{ route('products.index') }}" class="btn btn-secondary">戻る</a>
                <button type="submit" class="btn btn-primary" data-action="update">変更を保存</button>
            </div>
        </div>
    </form>
    <form method="POST" action="{{ route('products.destroy', $product) }}" style="position:absolute; right:0; top:0; margin:0;">
        @csrf
        @method('DELETE')
        @if($product->image && !$errors->any())
    <button type="submit" class="delete-button"><i class="fas fa-trash"></i></button>
        @endif
    </form>
    </div>

</div>
@endsection

@section('scripts')
<script>
const input = document.getElementById('image');
const preview = document.getElementById('preview');
const nameSpan = document.getElementById('image-name');
const deleteBtn = document.getElementById('delete-image');
const deleteInput = document.getElementById('delete_image');
const hiddenUrl = document.getElementById('image_url');

// ファイル選択時
input.addEventListener('change', function() {
    if (this.files && this.files[0]) {
        const file = this.files[0];
        nameSpan.textContent = file.name;

        const reader = new FileReader();
        reader.onload = function(e) {
            preview.src = e.target.result;
            preview.style.display = 'block';
            hiddenUrl.value = e.target.result; // バリデーション後も復元用
        };
        reader.readAsDataURL(file);

        deleteInput.value = 0; // 新しい画像選択で削除フラグOFF
    }
});

// 削除ボタン押下時
if (deleteBtn) {
    deleteBtn.addEventListener('click', function() {
        preview.style.display = 'none';
        input.value = '';
        nameSpan.textContent = '';
        deleteInput.value = 1;    // 削除フラグON
        hiddenUrl.value = '';      // プレビューも消す
        deleteBtn.style.display = 'none';
    });
}
</script>
@endsection

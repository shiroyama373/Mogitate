@extends('layouts.app')

@section('title', '商品一覧')

@section('css')
<link rel="stylesheet" href="{{ asset('css/products.css') }}">
@endsection

@section('content')
<div class="products-page">
    <!-- サイドバー -->
    <div class="sidebar">
        <h1>商品一覧</h1>
        <form method="GET" action="{{ route('products.index') }}">
            <input type="text" name="keyword" placeholder="商品名を入力" value="{{ request('keyword') }}">
            <button type="submit" class="btn-search">検索</button>

            <h3>価格順で表示</h3>
            <select name="sort" onchange="this.form.submit()">
                <option value="">価格で並び替え</option>
                <option value="price_desc" @if(request('sort')=='price_desc') selected @endif>高い順に表示</option>
                <option value="price_asc" @if(request('sort')=='price_asc') selected @endif>低い順に表示</option>
            </select>

            @if(request('sort'))
            <div class="tags">
                <span>　{{ request('sort') == 'price_desc' ? '高い順に表示' : '低い順に表示' }} <a href="{{ route('products.index') }}">×</a></span>
            </div>
            @endif

            <hr class="line">
        </form>
    </div>

    <!-- 商品一覧 -->
    <div class="product-container-wrapper">
        @if(!request('keyword') || request('sort'))
        <a href="{{ route('products.create') }}" class="btn-add-page">+ 商品を追加</a>
        @endif

        <div class="product-container">
            @php
                $displayed = []; // 表示済みの商品名を記録
            @endphp

            @foreach($products as $product)
                @if(!in_array($product->name, $displayed))
                    <div class="product-card">
                        <a href="{{ route('products.show', $product) }}">
                            <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}">
                        </a>
                        <div class="product-info">
                            <span class="name">{{ $product->name }}</span>
                            <span class="price">¥{{ number_format($product->price) }}</span>
                        </div>
                    </div>
                    @php $displayed[] = $product->name; @endphp
                @endif
            @endforeach
        </div>

        <div class="pagination-wrapper">
            {{ $products->withQueryString()->links() }}
        </div>
    </div>
</div>
@endsection
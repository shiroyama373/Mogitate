<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>@yield('title')</title>
    <!-- 共通CSS -->
    <link rel="stylesheet" href="{{ asset('css/common.css') }}">

        <!-- Font Awesome を追加 -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

    <!-- ページごとのCSS -->
    @yield('css')
</head>
<body>
    <!-- ヘッダー -->
    <header>
        <div class="logo">mogitate</div>
    </header>

    <!-- メインコンテンツ -->
    <main>
        @yield('content')
    </main>

    @yield('scripts')
    
</body>
</html>
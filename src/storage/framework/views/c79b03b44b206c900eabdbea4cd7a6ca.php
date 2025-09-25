<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title><?php echo $__env->yieldContent('title'); ?></title>
    <!-- 共通CSS -->
    <link rel="stylesheet" href="<?php echo e(asset('css/common.css')); ?>">

        <!-- Font Awesome を追加 -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

    <!-- ページごとのCSS -->
    <?php echo $__env->yieldContent('css'); ?>
</head>
<body>
    <!-- ヘッダー -->
    <header>
        <div class="logo">mogitate</div>
    </header>

    <!-- メインコンテンツ -->
    <main>
        <?php echo $__env->yieldContent('content'); ?>
    </main>

    <?php echo $__env->yieldContent('scripts'); ?>
    
</body>
</html><?php /**PATH /var/www/resources/views/layouts/app.blade.php ENDPATH**/ ?>
<?php $__env->startSection('title', '商品一覧'); ?>

<?php $__env->startSection('css'); ?>
<link rel="stylesheet" href="<?php echo e(asset('css/products.css')); ?>">
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div class="products-page">
    <!-- サイドバー -->
    <div class="sidebar">
        <h1>商品一覧</h1>
        <form method="GET" action="<?php echo e(route('products.index')); ?>">
            <input type="text" name="keyword" placeholder="商品名を入力" value="<?php echo e(request('keyword')); ?>">
            <button type="submit" class="btn-search">検索</button>

            <h3>価格順で表示</h3>
            <select name="sort" onchange="this.form.submit()">
                <option value="">価格で並び替え</option>
                <option value="price_desc" <?php if(request('sort')=='price_desc'): ?> selected <?php endif; ?>>高い順に表示</option>
                <option value="price_asc" <?php if(request('sort')=='price_asc'): ?> selected <?php endif; ?>>低い順に表示</option>
            </select>

            <?php if(request('sort')): ?>
            <div class="tags">
                <span>　<?php echo e(request('sort') == 'price_desc' ? '高い順に表示' : '低い順に表示'); ?> <a href="<?php echo e(route('products.index')); ?>">×</a></span>
            </div>
            <?php endif; ?>

            <hr class="line">
        </form>
    </div>

    <!-- 商品一覧 -->
    <div class="product-container-wrapper">
        <?php if(!request('keyword') || request('sort')): ?>
        <a href="<?php echo e(route('products.create')); ?>" class="btn-add-page">+ 商品を追加</a>
        <?php endif; ?>

        <div class="product-container">
            <?php
                $displayed = []; // 表示済みの商品名を記録
            ?>

            <?php $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <?php if(!in_array($product->name, $displayed)): ?>
                    <div class="product-card">
                        <a href="<?php echo e(route('products.show', $product)); ?>">
                            <img src="<?php echo e(asset('storage/' . $product->image)); ?>" alt="<?php echo e($product->name); ?>">
                        </a>
                        <div class="product-info">
                            <span class="name"><?php echo e($product->name); ?></span>
                            <span class="price">¥<?php echo e(number_format($product->price)); ?></span>
                        </div>
                    </div>
                    <?php $displayed[] = $product->name; ?>
                <?php endif; ?>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>

        <div class="pagination-wrapper">
            <?php echo e($products->withQueryString()->links()); ?>

        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/resources/views/products/index.blade.php ENDPATH**/ ?>
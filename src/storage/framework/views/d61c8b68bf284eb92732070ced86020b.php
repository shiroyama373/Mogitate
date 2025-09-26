<?php $__env->startSection('title', '商品編集ページ'); ?>

<?php $__env->startSection('css'); ?>
<link rel="stylesheet" href="<?php echo e(asset('css/show_edit.css')); ?>">
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div class="page-container">

    <nav class="breadcrumb">
        <a href="<?php echo e(route('products.index')); ?>">商品一覧</a> &gt;
        <span><?php echo e($product->name); ?></span>
    </nav>

    <form id="update-form" action="<?php echo e(route('products.update', $product)); ?>" method="POST" enctype="multipart/form-data">
        <?php echo csrf_field(); ?>
        <?php echo method_field('PUT'); ?>

        <?php
            // 画像プレビュー用
            $previewImage = old('delete_image') == 1
                            ? null
                            : (old('image_url') ?? ($product->image ? asset('storage/' . $product->image) : null));

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
        ?>
        <div class="product-page">
            <!-- 左: 画像 -->
            <div class="product-left">
                <div class="product-image">
                    <img id="preview" src="<?php echo e($previewImage); ?>" style="<?php echo e($previewImage ? '' : 'display:none;'); ?>">
                </div>

                <div class="file-wrapper">
                    <label for="image" class="custom-file-label">ファイルを選択</label>
                    <span id="image-name"><?php echo e(old('image_name', $product->image ?? '')); ?></span>
                    <input type="file" name="image" id="image" hidden>
                </div>

                <input type="hidden" name="delete_image" id="delete_image" value="<?php echo e(old('delete_image', 0)); ?>">
                <input type="hidden" name="image_url" id="image_url" value="<?php echo e(old('image_url')); ?>">

                <?php if($product->image): ?>
                    <button type="button" id="delete-image" class="btn btn-sm btn-outline-danger">ファイルを削除</button>
                <?php endif; ?>
                <?php $__errorArgs = ['image'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><p class="error"><?php echo e($message); ?></p><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>

            <!-- 右: 商品情報 -->
            <div class="product-right">
                <label for="name">商品名</label>
                <input type="text" name="name" value="<?php echo e(old('name', $product->name)); ?>">
                <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><p class="error"><?php echo e($message); ?></p><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>

                <label for="price">値段</label>
                <input type="text" name="price" value="<?php echo e(old('price', $product->price)); ?>">
                <?php $__errorArgs = ['price'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><p class="error"><?php echo e($message); ?></p><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>

                <label>季節</label>
                <div class="season-checkboxes">
                    <?php $__currentLoopData = $allSeasons; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $season): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
<label class="custom-radio">
    <input type="checkbox" name="season[]" value="<?php echo e($season->id); ?>"
        <?php echo e(in_array((string)$season->id, $selectedSeasons) ? 'checked' : ''); ?>>
    <span class="checkmark"></span>
    <?php echo e($season->name); ?>

</label>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
                <?php $__errorArgs = ['season'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><p class="error"><?php echo e($message); ?></p><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>
        </div> 

        <!-- 商品説明 -->
        <div class="product-description-container">
            <div class="product-description">
                <label for="description">商品説明</label>
                <textarea name="description"><?php echo e(old('description', $product->description)); ?></textarea>
                <?php $__errorArgs = ['description'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><p class="error"><?php echo e($message); ?></p><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>
        </div>

        <!-- ボタンエリア -->
        <div class="button-wrapper" style="display:flex; align-items:center; justify-content:center; gap:20px; margin-top:20px; position:relative;">
        <!-- 中央ボタン -->
        <div class="button-wrapper">
            <div class="button-center">
                <a href="<?php echo e(route('products.index')); ?>" class="btn btn-secondary">戻る</a>
                <button type="submit" class="btn btn-primary" data-action="update">変更を保存</button>
            </div>
        </div>
    </form>
    <form method="POST" action="<?php echo e(route('products.destroy', $product)); ?>" style="position:absolute; right:0; top:0; margin:0;">
        <?php echo csrf_field(); ?>
        <?php echo method_field('DELETE'); ?>
        <?php if($product->image && !$errors->any()): ?>
    <button type="submit" class="delete-button"><i class="fas fa-trash"></i></button>
        <?php endif; ?>
    </form>
    </div>

</div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>
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
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/resources/views/products/show_edit.blade.php ENDPATH**/ ?>
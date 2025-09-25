<?php $__env->startSection('title', '商品登録ページ'); ?>

<?php $__env->startSection('css'); ?>
<link rel="stylesheet" href="<?php echo e(asset('css/create.css')); ?>">

<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div class="page-container">
    <h1 class="page-title">商品登録</h1>

    <form id="product-form" action="<?php echo e(route('products.store')); ?>" method="POST" enctype="multipart/form-data">
        <?php echo csrf_field(); ?>

        <!-- 商品名 -->
    <div class="form-group">
        <label class="form-label" for="name">商品名<span class="required">必須</span></label>
        <input type="text" name="name" id="name" placeholder="商品名を入力" value="<?php echo e(old('name')); ?>">
        <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><p class="error"><?php echo e($message); ?></p><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
    </div>


    <!-- 値段 -->
    <div class="form-group">
        <label class="form-label" for="price">値段<span class="required">必須</span></label>
        <input type="text" name="price" id="price" placeholder="値段を入力" value="<?php echo e(old('price')); ?>">
        <p class="error" id="price-error" style="color:red;font-size:14px;">
    <?php echo e($errors->first('price')); ?>

    </p>
    </div>
        <!-- 商品画像 -->
    <div class="form-group">
        <label class="form-label">商品画像<span class="required">必須</span></label>

        <img id="image-preview" 
        src="<?php echo e(old('image_preview')); ?>" 
        style="display:<?php echo e(old('image_preview') ? 'block' : 'none'); ?>; max-width: 400px; margin-bottom: 10px;">

        <div class="file-select-wrapper">
            <input type="file" name="image" id="image" accept="image/png, image/jpeg" style="display:none;">
            <button type="button" id="select-file-btn" class="btn btn-secondary">ファイルを選択</button>
            <span id="file-name" style="margin-left: 10px;">選択されていません</span>
        </div>
        <?php $__errorArgs = ['image'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><p class="error"><?php echo e($message); ?></p><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
    </div>

        <!-- 季節 -->
    <div class="form-group">
        <label class="form-label">
        季節 <span class="required">必須</span>
        <span style="color: red; font-size: 0.9em;">  複数選択可 </span>
        </label>
        <div class="season-checkboxes">
            <?php $__currentLoopData = $allSeasons; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $season): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <label class="custom-radio">
                <input type="checkbox" name="season[]" value="<?php echo e($season->id); ?>"
                    <?php echo e((is_array(old('season')) && in_array($season->id, old('season'))) ? 'checked' : ''); ?>>
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
        <!-- 商品説明 -->
    <div class="form-group">
        <label class="form-label" for="description">商品説明<span class="required">必須</span></label>
        <textarea name="description" id="description" placeholder="商品の説明を入力"><?php echo e(old('description')); ?></textarea>
        <?php $__errorArgs = ['description'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><p class="error"><?php echo e($message); ?></p><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
    </div>

        <!-- ボタン -->
        <div class="button-group">
            <a href="<?php echo e(route('products.index')); ?>" class="btn btn-secondary">戻る</a>
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
    const tmpImage = "<?php echo e(session('image_tmp')); ?>";
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

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/resources/views/products/create.blade.php ENDPATH**/ ?>
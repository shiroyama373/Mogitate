<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Season;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    // 商品一覧
    public function index(Request $request)
    {
        $query = Product::query();

        // 部分一致検索
        if ($request->filled('keyword')) {
            $query->where('name', 'like', '%' . $request->keyword . '%');
        }

        // 並び替え
        if ($request->filled('sort')) {
            if ($request->sort === 'price_desc') {
                $query->orderBy('price', 'desc');
            } elseif ($request->sort === 'price_asc') {
                $query->orderBy('price', 'asc');
            }
        }

        $products = $query->paginate(6)->withQueryString();

        return view('products.index', compact('products'));
    }

    // 商品詳細・編集画面
    public function show(Product $product)
    {
        $allSeasons = Season::all();
        return view('products.show_edit', compact('product', 'allSeasons'));
    }

    // 商品作成フォーム
    public function create()
    {
        $allSeasons = Season::all();
        return view('products.create', compact('allSeasons'));
    }

    // 商品保存
    public function store(StoreProductRequest $request)
    {
        $validated = $request->validated();

        // 画像アップロード
        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('products', 'public');
        }

        // 商品作成
        $product = Product::create([
            'name' => $validated['name'],
            'price' => $validated['price'],
            'description' => $validated['description'],
            'image' => $imagePath,
        ]);

        // シーズン情報を同期
        $seasons = $validated['season'] ?? [];
        $product->seasons()->sync($seasons);

        return redirect()->route('products.index')->with('success', '商品を追加しました');
    }

    // 商品更新
    public function update(UpdateProductRequest $request, Product $product)
{
    $validated = $request->validated();

    $seasons = $request->input('season', []);
    $deleteImage = $request->input('delete_image');

    // 画像処理
    if ($request->hasFile('image')) {
        // 古い画像を削除
        if ($product->image) {
            Storage::disk('public')->delete($product->image);
        }
        $validated['image'] = $request->file('image')->store('products', 'public');
    } elseif ($deleteImage) {
        // 削除フラグが立っている場合、画像を削除
        if ($product->image) {
            Storage::disk('public')->delete($product->image);
        }
        $validated['image'] = null;
    } else {
        // 何もしない場合は既存画像を保持
        unset($validated['image']);
    }

    // Product更新（seasonは除外）
    $product->update(collect($validated)->except('season')->toArray());

    // 中間テーブル（season）更新
    $product->seasons()->sync($seasons);

    return redirect()->route('products.index')->with('success', '商品を更新しました');
}


    // 商品削除
    public function destroy(Product $product)
    {
        if ($product->image) {
            Storage::disk('public')->delete($product->image);
        }
        $product->delete();

        return redirect()->route('products.index')->with('success', '商品を削除しました');
    }

    // 商品編集フォーム
public function edit(Product $product)
{
    $allSeasons = Season::all(); // チェックボックス用の全季節データ
    return view('products.edit', compact('product', 'allSeasons'));
}
}
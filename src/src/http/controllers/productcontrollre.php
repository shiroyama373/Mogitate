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

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('products', 'public');
        }

        $product = Product::create([
            'name' => $validated['name'],
            'price' => $validated['price'],
            'description' => $validated['description'],
            'image' => $imagePath,
        ]);

        $product->seasons()->sync($validated['season'] ?? []);

        return redirect()->route('products.index')->with('success', '商品を追加しました');
    }

    // 商品編集フォーム
    public function edit(Product $product)
    {
        $allSeasons = Season::all();
        $selectedSeasons = old('season', $product->seasons->pluck('id')->toArray());
        return view('products.edit', compact('product', 'allSeasons', 'selectedSeasons'));
    }

    // 商品更新
    public function update(UpdateProductRequest $request, Product $product)
    {
        $validated = $request->validated();
        $seasons = $request->input('season', []);
        $deleteImage = $request->input('delete_image');

        if ($request->hasFile('image')) {
            if ($product->image) {
                Storage::disk('public')->delete($product->image);
            }
            $validated['image'] = $request->file('image')->store('products', 'public');
        } elseif ($deleteImage) {
            if ($product->image) {
                Storage::disk('public')->delete($product->image);
            }
            $validated['image'] = null;
        } else {
            unset($validated['image']);
        }

        $product->update(collect($validated)->except('season')->toArray());
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
}
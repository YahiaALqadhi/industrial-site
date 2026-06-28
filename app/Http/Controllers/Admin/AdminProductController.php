<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ProductStoreRequest;
use App\Http\Requests\Admin\ProductUpdateRequest;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductFeature;
use App\Models\ProductImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class AdminProductController extends Controller
{
    public function index(Request $request)
    {
        $this->authorize('viewAny', Product::class);

        $query = Product::query()->with('category');

        $search = trim((string) $request->query('q', ''));
        if ($search !== '') {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('slug', 'like', "%{$search}%");
            });
        }

        $categoryId = $request->query('category_id');
        if (!empty($categoryId)) {
            $query->where('category_id', $categoryId);
        }

        $products = $query
            ->orderByDesc('id')
            ->paginate(15)
            ->withQueryString();

        $categories = Category::query()->orderBy('sort_order')->orderBy('name')->get();

        return view('admin.products.index', compact('products', 'categories', 'search', 'categoryId'));
    }

    public function create()
    {
        $this->authorize('create', Product::class);

        $categories = Category::query()->orderBy('sort_order')->orderBy('name')->get();

        return view('admin.products.create', compact('categories'));
    }

    public function store(ProductStoreRequest $request)
    {
        $data = $request->validated();

        if (empty($data['slug'])) {
            $data['slug'] = Str::slug($data['name']);
        }

        if ($request->hasFile('cover_image')) {
            $data['cover_image'] = $request->file('cover_image')->store('products/covers', 'public');
        }

        if ($request->hasFile('brochure_pdf')) {
            $data['brochure_pdf'] = $request->file('brochure_pdf')->store('products/brochures', 'public');
        }

        $data['is_active'] = (bool) ($data['is_active'] ?? false);

        $product = Product::query()->create($data);

        $this->syncFeatures($product, $request->input('features', []));
        $this->storeGalleryImages($product, $request);

        return redirect()->route('admin.products.edit', $product)->with('success', 'Product created successfully.');
    }

    public function edit(Product $product)
    {
        $this->authorize('update', $product);

        $product->load(['images', 'features', 'category']);
        $categories = Category::query()->orderBy('sort_order')->orderBy('name')->get();

        return view('admin.products.edit', compact('product', 'categories'));
    }

    public function update(ProductUpdateRequest $request, Product $product)
    {
        $data = $request->validated();

        if (empty($data['slug'])) {
            $data['slug'] = Str::slug($data['name']);
        }

        if ($request->hasFile('cover_image')) {
            if ($product->cover_image) {
                Storage::disk('public')->delete($product->cover_image);
            }
            $data['cover_image'] = $request->file('cover_image')->store('products/covers', 'public');
        }

        if ($request->hasFile('brochure_pdf')) {
            if ($product->brochure_pdf) {
                Storage::disk('public')->delete($product->brochure_pdf);
            }
            $data['brochure_pdf'] = $request->file('brochure_pdf')->store('products/brochures', 'public');
        }

        $data['is_active'] = (bool) ($data['is_active'] ?? false);

        $product->update($data);

        $this->syncFeatures($product, $request->input('features', []));
        $this->storeGalleryImages($product, $request);

        $deleteGalleryIds = $request->input('delete_gallery', []);
        $this->deleteGalleryImagesByIds($product, $deleteGalleryIds);

        return redirect()->route('admin.products.edit', $product)->with('success', 'Product updated successfully.');
    }

    public function destroy(Product $product)
    {
        $this->authorize('delete', $product);

        $product->load('images');

        if ($product->cover_image) {
            Storage::disk('public')->delete($product->cover_image);
        }

        if ($product->brochure_pdf) {
            Storage::disk('public')->delete($product->brochure_pdf);
        }

        foreach ($product->images as $img) {
            Storage::disk('public')->delete($img->path);
        }

        $product->delete();

        return redirect()->route('admin.products.index')->with('success', 'Product deleted successfully.');
    }

    public function show(Product $product)
    {
        return redirect()->route('admin.products.edit', $product);
    }

    private function storeGalleryImages(Product $product, Request $request): void
    {
        if (!$request->hasFile('gallery_images')) {
            return;
        }

        $files = $request->file('gallery_images', []);
        $nextSort = (int) ($product->images()->max('sort_order') ?? 0);

        foreach ($files as $file) {
            $path = $file->store('products/gallery', 'public');
            $nextSort++;
            ProductImage::query()->create([
                'product_id' => $product->id,
                'path' => $path,
                'sort_order' => $nextSort,
            ]);
        }
    }

    private function deleteGalleryImagesByIds(Product $product, array $ids): void
    {
        $ids = array_values(array_filter(array_map('intval', $ids)));
        if (count($ids) === 0) {
            return;
        }

        $images = $product->images()->whereIn('id', $ids)->get();
        foreach ($images as $img) {
            Storage::disk('public')->delete($img->path);
            $img->delete();
        }
    }

    private function syncFeatures(Product $product, array $features): void
    {
        $clean = [];
        foreach ($features as $i => $text) {
            $t = trim((string) $text);
            if ($t === '') {
                continue;
            }
            $clean[] = ['text' => $t, 'sort_order' => count($clean)];
        }

        $product->features()->delete();

        foreach ($clean as $row) {
            ProductFeature::query()->create([
                'product_id' => $product->id,
                'text' => $row['text'],
                'sort_order' => $row['sort_order'],
            ]);
        }
    }
}

<?php

namespace App\Http\Requests\Admin;

use App\Models\Product;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProductUpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        /** @var \App\Models\Product $product */
        $product = $this->route('product');

        return $this->user()->can('update', $product);
    }

    public function rules(): array
    {
        /** @var \App\Models\Product $product */
        $product = $this->route('product');

        return [
            'category_id' => ['required', 'integer', 'exists:categories,id'],
            'name' => ['required', 'string', 'max:255'],
            'slug' => ['nullable', 'string', 'max:255', Rule::unique('products', 'slug')->ignore($product->id)],
            'short_desc' => ['nullable', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'cover_image' => ['nullable', 'file', 'mimes:jpg,jpeg,png,webp', 'max:6144'],
            'brochure_pdf' => ['nullable', 'file', 'mimes:pdf', 'max:10240'],
            'gallery_images' => ['nullable', 'array'],
            'gallery_images.*' => ['file', 'mimes:jpg,jpeg,png,webp', 'max:6144'],
            'delete_gallery' => ['nullable', 'array'],
            'delete_gallery.*' => ['integer'],
            'features' => ['nullable', 'array'],
            'features.*' => ['nullable', 'string', 'max:255'],
            'is_active' => ['nullable', 'boolean'],
        ];
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'is_active' => $this->boolean('is_active'),
        ]);
    }
}

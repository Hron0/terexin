<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductCharacteristic;
use App\Models\ProductImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    /**
     * Display a listing of the products.
     */
    public function index()
    {
        $products = Product::with('category')->latest()->paginate(10);
        return view('admin.products.index', compact('products'));
    }

    /**
     * Show the form for creating a new product.
     */
    public function create()
    {
        $categories = Category::all();
        return view('admin.products.create', compact('categories'));
    }

    /**
     * Store a newly created product in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'description' => 'required|string',
            'category_id' => 'required|exists:categories,id',
            'main_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'additional_images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'screen' => 'nullable|string|max:255',
            'processor' => 'nullable|string|max:255',
            'ram' => 'nullable|string|max:255',
            'battery' => 'nullable|string|max:255',
            'os' => 'nullable|string|max:255',
        ]);

        // Upload main image if provided
        if ($request->hasFile('main_image')) {
            $imagePath = $request->file('main_image')->store('products', 'public');
            $validated['main_image'] = $imagePath;
        }

        DB::beginTransaction();

        try {
            // Create product
            $product = Product::create($validated);

            // Create product characteristics
            $characteristics = [
                'screen' => $request->screen,
                'processor' => $request->processor,
                'ram' => $request->ram,
                'battery' => $request->battery,
                'os' => $request->os,
            ];
            
            $product->characteristics()->create($characteristics);

            // Upload additional images if provided
            if ($request->hasFile('additional_images')) {
                $sortOrder = 0;
                foreach ($request->file('additional_images') as $image) {
                    $imagePath = $image->store('products', 'public');
                    $product->images()->create([
                        'image_path' => $imagePath,
                        'sort_order' => $sortOrder++,
                    ]);
                }
            }

            DB::commit();

            return redirect()->route('admin.products.index')
                ->with('success', 'Товар успешно создан.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Произошла ошибка при создании товара: ' . $e->getMessage())->withInput();
        }
    }

    /**
     * Show the form for editing the specified product.
     */
    public function edit(Product $product)
    {
        $categories = Category::all();
        $product->load('characteristics', 'images');
        return view('admin.products.edit', compact('product', 'categories'));
    }

    /**
     * Update the specified product in storage.
     */
    public function update(Request $request, Product $product)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'description' => 'required|string',
            'category_id' => 'required|exists:categories,id',
            'main_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'additional_images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'screen' => 'nullable|string|max:255',
            'processor' => 'nullable|string|max:255',
            'ram' => 'nullable|string|max:255',
            'battery' => 'nullable|string|max:255',
            'os' => 'nullable|string|max:255',
        ]);

        // Upload main image if provided
        if ($request->hasFile('main_image')) {
            // Delete old image if exists
            if ($product->main_image) {
                Storage::disk('public')->delete($product->main_image);
            }
            
            $imagePath = $request->file('main_image')->store('products', 'public');
            $validated['main_image'] = $imagePath;
        }

        DB::beginTransaction();

        try {
            // Update product
            $product->update($validated);

            // Update product characteristics
            $characteristics = [
                'screen' => $request->screen,
                'processor' => $request->processor,
                'ram' => $request->ram,
                'battery' => $request->battery,
                'os' => $request->os,
            ];
            
            if ($product->characteristics) {
                $product->characteristics->update($characteristics);
            } else {
                $product->characteristics()->create($characteristics);
            }

            // Upload additional images if provided
            if ($request->hasFile('additional_images')) {
                $sortOrder = $product->images()->max('sort_order') + 1 ?? 0;
                foreach ($request->file('additional_images') as $image) {
                    $imagePath = $image->store('products', 'public');
                    $product->images()->create([
                        'image_path' => $imagePath,
                        'sort_order' => $sortOrder++,
                    ]);
                }
            }

            DB::commit();

            return redirect()->route('admin.products.index')
                ->with('success', 'Товар успешно обновлен.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Произошла ошибка при обновлении товара: ' . $e->getMessage())->withInput();
        }
    }

    /**
     * Remove the specified product from storage.
     */
    public function destroy(Product $product)
    {
        // Delete main image if exists
        if ($product->main_image) {
            Storage::disk('public')->delete($product->main_image);
        }

        // Delete additional images if exist
        foreach ($product->images as $image) {
            Storage::disk('public')->delete($image->image_path);
            $image->delete();
        }

        // Delete product characteristics
        if ($product->characteristics) {
            $product->characteristics->delete();
        }

        $product->delete();

        return redirect()->route('admin.products.index')
            ->with('success', 'Товар успешно удален.');
    }

    /**
     * Remove a specific additional image.
     */
    public function deleteImage($id)
    {
        $image = ProductImage::findOrFail($id);
        
        // Delete image file
        Storage::disk('public')->delete($image->image_path);
        
        // Delete image record
        $image->delete();
        
        return response()->json(['success' => true]);
    }
}
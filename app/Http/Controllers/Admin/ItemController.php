<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Item;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class ItemController extends Controller
{
    public function index()
    {
        $items = Item::with('category')->latest()->paginate(10);
        return view('admin.items.index', compact('items'));
    }

    public function create()
    {
        $categories = Category::where('is_active', true)->get();
        return view('admin.items.create', compact('categories'));
    }

    public function store(Request $request)
    {
        // Debug: See what's coming in the request
        Log::info('Item Store Request:', $request->all());

        $request->validate([
            'name_en' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'normal_price' => 'required|numeric|min:0',
            'cover_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:5120', // Increased to 5MB
            'gallery_images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:5120'
        ]);

        try {
            $data = $request->all();

            // Handle checkbox value properly
            $data['is_active'] = $request->has('is_active') ? 1 : 0;

            // Handle cover image upload
            if ($request->hasFile('cover_image')) {
                $coverImage = $request->file('cover_image');
                $coverImagePath = $coverImage->store('items/cover', 'public');
                $data['cover_image'] = $coverImagePath;
                Log::info('Cover image stored at: ' . $coverImagePath);
            }

            // Handle gallery images upload
            if ($request->hasFile('gallery_images')) {
                $galleryPaths = [];
                foreach ($request->file('gallery_images') as $image) {
                    $galleryPath = $image->store('items/gallery', 'public');
                    $galleryPaths[] = $galleryPath;
                    Log::info('Gallery image stored at: ' . $galleryPath);
                }
                $data['gallery_images'] = $galleryPaths;
            }

            // Set default values for optional fields
            $data['price_with_ice_cream'] = $data['price_with_ice_cream'] ?? 0;
            $data['price_per_kilo'] = $data['price_per_kilo'] ?? 0;
            $data['currency'] = $data['currency'] ?? 'IQD';

            // Generate UNIQUE slug
            $baseSlug = \Str::slug($data['name_en']);
            $slug = $baseSlug;
            $counter = 1;

            while (Item::where('slug', $slug)->exists()) {
                $slug = $baseSlug . '-' . $counter;
                $counter++;
            }
            $data['slug'] = $slug;

            // Create the item
            $item = Item::create($data);
            Log::info('Item created successfully with ID: ' . $item->id);

            // Update category items count
            $category = Category::find($data['category_id']);
            if ($category) {
                $category->update([
                    'total_items' => $category->items()->count()
                ]);
            }

            return redirect()->route('admin.items.index')
                ->with('success', 'Item created successfully.');

        } catch (\Exception $e) {
            Log::error('Error creating item: ' . $e->getMessage());
            return redirect()->back()
                ->with('error', 'Error creating item: ' . $e->getMessage())
                ->withInput();
        }
    }

    public function edit(Item $item)
    {
        $categories = Category::where('is_active', true)->get();
        return view('admin.items.edit', compact('item', 'categories'));
    }

    public function update(Request $request, Item $item)
    {
        $request->validate([
            'name_en' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'normal_price' => 'required|numeric|min:0',
            'cover_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:5120',
            'gallery_images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:5120'
        ]);

        try {
            $data = $request->all();

            // Handle checkbox value properly
            $data['is_active'] = $request->has('is_active') ? 1 : 0;

            // Handle file uploads
            if ($request->hasFile('cover_image')) {
                // Delete old cover image
                if ($item->cover_image) {
                    Storage::disk('public')->delete($item->cover_image);
                }
                $coverImagePath = $request->file('cover_image')->store('items/cover', 'public');
                $data['cover_image'] = $coverImagePath;
                Log::info('Cover image updated to: ' . $coverImagePath);
            }

            if ($request->hasFile('gallery_images')) {
                // Delete old gallery images
                if ($item->gallery_images) {
                    foreach ($item->gallery_images as $oldImage) {
                        Storage::disk('public')->delete($oldImage);
                    }
                }

                $galleryPaths = [];
                foreach ($request->file('gallery_images') as $image) {
                    $galleryPath = $image->store('items/gallery', 'public');
                    $galleryPaths[] = $galleryPath;
                    Log::info('Gallery image stored at: ' . $galleryPath);
                }
                $data['gallery_images'] = $galleryPaths;
            }

            $oldCategoryId = $item->category_id;

            $item->update($data);
            Log::info('Item updated successfully with ID: ' . $item->id);

            // Update category items count if category changed
            if ($oldCategoryId != $data['category_id']) {
                $oldCategory = Category::find($oldCategoryId);
                if ($oldCategory) {
                    $oldCategory->update([
                        'total_items' => $oldCategory->items()->count()
                    ]);
                }

                $newCategory = Category::find($data['category_id']);
                if ($newCategory) {
                    $newCategory->update([
                        'total_items' => $newCategory->items()->count()
                    ]);
                }
            }

            return redirect()->route('admin.items.index')
                ->with('success', 'Item updated successfully.');

        } catch (\Exception $e) {
            Log::error('Error updating item: ' . $e->getMessage());
            return redirect()->back()
                ->with('error', 'Error updating item: ' . $e->getMessage())
                ->withInput();
        }
    }

    public function destroy(Item $item)
    {
        try {
            // Delete associated images
            if ($item->cover_image) {
                Storage::disk('public')->delete($item->cover_image);
                Log::info('Deleted cover image: ' . $item->cover_image);
            }

            if ($item->gallery_images) {
                foreach ($item->gallery_images as $image) {
                    Storage::disk('public')->delete($image);
                    Log::info('Deleted gallery image: ' . $image);
                }
            }

            $category = $item->category;
            $itemId = $item->id;

            $item->delete();
            Log::info('Item deleted successfully with ID: ' . $itemId);

            // Update category items count
            if ($category) {
                $category->update([
                    'total_items' => $category->items()->count()
                ]);
            }

            return redirect()->route('admin.items.index')
                ->with('success', 'Item deleted successfully.');

        } catch (\Exception $e) {
            Log::error('Error deleting item: ' . $e->getMessage());
            return redirect()->back()
                ->with('error', 'Error deleting item: ' . $e->getMessage());
        }
    }

    public function toggleStatus(Item $item)
    {
        try {
            $item->update(['is_active' => !$item->is_active]);
            Log::info('Item status toggled for ID: ' . $item->id . ' to: ' . ($item->is_active ? 'active' : 'inactive'));

            return response()->json([
                'success' => true,
                'is_active' => $item->is_active
            ]);

        } catch (\Exception $e) {
            Log::error('Error toggling item status: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }
}

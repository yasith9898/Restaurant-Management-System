<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Item;
use App\Models\Feedback;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;

class MenuController extends Controller
{
    public function index()
    {
        return view('menu.index');
    }

    public function show($id)
    {
        $item = Item::with('category')->findOrFail($id);

        return response()->json([
            'success' => true,
            'item' => [
                'id' => $item->id,
                'name_en' => $item->name_en,
                'name_ar' => $item->name_ar,
                'name_ku' => $item->name_ku,
                'name_tr' => $item->name_tr,
                'name_fa' => $item->name_fa,
                'normal_price' => $item->normal_price,
                'price_with_ice_cream' => $item->price_with_ice_cream,
                'price_per_kilo' => $item->price_per_kilo,
                'currency' => $item->currency,
                'cover_image' => $this->absoluteImageUrl($item->cover_image_url), // Ensure absolute URL with host/port
                'options' => $this->formatItemOptions($item)
            ]
        ]);
    }

    public function byCategory($slug)
    {
        $category = Category::where('slug', $slug)
            ->where('is_active', true)
            ->with(['items' => function($query) {
                $query->where('is_active', true);
            }])
            ->firstOrFail();

        $items = $category->items->map(function($item) {
            return [
                'id' => $item->id,
                'name_en' => $item->name_en,
                'name_ar' => $item->name_ar,
                'name_ku' => $item->name_ku,
                'name_tr' => $item->name_tr,
                'name_fa' => $item->name_fa,
                'price' => $item->normal_price ? number_format($item->normal_price) . ' ' . $item->currency : 'N/A',
                'cover_image' => $item->cover_image_url, // Use the accessor
                'options' => $this->formatItemOptions($item)
            ];
        });

        return response()->json([
            'success' => true,
            'category' => $category,
            'items' => $items
        ]);
    }

    public function search(Request $request)
    {
        $query = $request->get('q');

        $items = Item::where('is_active', true)
            ->where(function($q) use ($query) {
                $q->where('name_en', 'LIKE', "%{$query}%")
                  ->orWhere('name_ar', 'LIKE', "%{$query}%")
                  ->orWhere('name_ku', 'LIKE', "%{$query}%")
                  ->orWhere('name_tr', 'LIKE', "%{$query}%")
                  ->orWhere('name_fa', 'LIKE', "%{$query}%");
            })
            ->with('category')
            ->get();

        return view('menu.search', compact('items', 'query'));
    }

    public function feedback()
    {
        return view('menu.feedback');
    }

    public function submitFeedback(Request $request)
    {
        $validated = $request->validate([
            'staff_rating' => 'nullable|integer|min:1|max:5',
            'service_rating' => 'nullable|integer|min:1|max:5',
            'hygiene_rating' => 'nullable|integer|min:1|max:5',
            'overall_experience' => 'nullable|string|in:very-poor,poor,neutral,good,excellent',
            'phone' => 'nullable|string|max:20',
            'comment' => 'nullable|string|max:1000'
        ]);

        Feedback::create($validated);

        return response()->json([
            'success' => true,
            'message' => 'Feedback submitted successfully!'
        ]);
    }

    public function changeLanguage(Request $request)
    {
        $validated = $request->validate([
            'language' => 'required|in:en,ar,ku,tr,fa'
        ]);

        Session::put('language', $validated['language']);

        return response()->json([
            'success' => true,
            'message' => 'Language changed successfully'
        ]);
    }

    // Get all menu data for frontend
    public function getMenuData()
    {
        $categories = Category::where('is_active', true)
            ->with(['items' => function($query) {
                $query->where('is_active', true)->orderBy('name_en');
            }])
            ->orderBy('order')
            ->get();

        $menuData = [];

        foreach ($categories as $category) {
            $categoryItems = [];

            foreach ($category->items as $item) {
                $categoryItems[] = [
                    'id' => $item->id,
                    'name_en' => $item->name_en,
                    'name_ar' => $item->name_ar,
                    'name_ku' => $item->name_ku,
                    'name_tr' => $item->name_tr,
                    'name_fa' => $item->name_fa,
                    'price' => $item->normal_price ? number_format($item->normal_price) . ' ' . $item->currency : 'N/A',
                    'cover_image' => $this->absoluteImageUrl($item->cover_image_url), // Ensure absolute URL with host/port
                    'options' => $this->formatItemOptions($item)
                ];
            }

            if (count($categoryItems) > 0) {
                $menuData[$category->slug] = $categoryItems;
            }
        }

        return response()->json($menuData);
    }

    // Get categories for header and modal
    public function getCategories()
    {
        $categories = Category::where('is_active', true)
            ->orderBy('order')
            ->get(['id', 'name_en', 'name_ar', 'name_ku', 'name_tr', 'name_fa', 'slug', 'image']);

        $categoriesWithUrls = $categories->map(function($category) {
            return [
                'id' => $category->id,
                'name_en' => $category->name_en,
                'name_ar' => $category->name_ar,
                'name_ku' => $category->name_ku,
                'name_tr' => $category->name_tr,
                'name_fa' => $category->name_fa,
                'slug' => $category->slug,
                'image' => $this->absoluteImageUrl($category->image_url) // Use the accessor and make absolute
            ];
        });

        return response()->json($categoriesWithUrls);
    }

    /**
     * Ensure the provided image URL (or path) is absolute and uses the current request host/port.
     */
    private function absoluteImageUrl($url)
    {
        if (empty($url)) {
            return asset('images/default-category.png');
        }

        // If already an absolute URL
        if (filter_var($url, FILTER_VALIDATE_URL)) {
            // If the URL points to the /storage path but doesn't include the current host/port,
            // rebuild it using the current request host so the port is preserved (useful with php artisan serve).
            $parsed = parse_url($url);
            $path = $parsed['path'] ?? '';
            if ($path && strpos($path, '/storage') === 0) {
                return request()->getSchemeAndHttpHost() . $path;
            }

            return $url;
        }

        // If it's a relative path starting with '/', prefix with current host
        if (strpos($url, '/') === 0) {
            return request()->getSchemeAndHttpHost() . $url;
        }

        // Otherwise assume it's a storage-relative path and prefix with /storage and current host
        return request()->getSchemeAndHttpHost() . '/' . ltrim($url, '/');
    }

    private function formatItemOptions($item)
    {
        $options = [];

        // Add normal price option
        if ($item->normal_price > 0) {
            $options[] = [
                'label' => 'Standard',
                'price' => number_format($item->normal_price) . ' ' . $item->currency
            ];
        }

        // Add with ice cream option
        if ($item->price_with_ice_cream > 0 && $item->price_with_ice_cream != $item->normal_price) {
            $options[] = [
                'label' => 'With Ice Cream',
                'price' => number_format($item->price_with_ice_cream) . ' ' . $item->currency
            ];
        }

        // Add per kilo option
        if ($item->price_per_kilo > 0) {
            $options[] = [
                'label' => 'Per Kilo',
                'price' => number_format($item->price_per_kilo) . ' ' . $item->currency . '/kg'
            ];
        }

        // If no specific options, at least show the standard price
        if (empty($options) && $item->normal_price > 0) {
            $options[] = [
                'label' => 'Standard',
                'price' => number_format($item->normal_price) . ' ' . $item->currency
            ];
        }

        return $options;
    }
}

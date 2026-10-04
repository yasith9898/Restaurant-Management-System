<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Item;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_categories' => Category::count(),
            'total_items' => Item::count(),
            'active_categories' => Category::where('is_active', true)->count(),
            'active_items' => Item::where('is_active', true)->count(),
        ];

        $recentItems = Item::with('category')
            ->latest()
            ->take(5)
            ->get();

        return view('admin.dashboard', compact('stats', 'recentItems'));
    }
}

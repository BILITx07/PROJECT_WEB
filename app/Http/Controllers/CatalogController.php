<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item;
use App\Services\WeatherService;
use Carbon\Carbon;

class CatalogController extends Controller
{
    public function index(Request $request)
    {
        // Default rental dates: tomorrow to the day after tomorrow
        $defaultStart = Carbon::tomorrow()->format('Y-m-d');
        $defaultEnd = Carbon::tomorrow()->addDays(2)->format('Y-m-d');

        $startDate = $request->get('start_date', $defaultStart);
        $endDate = $request->get('end_date', $defaultEnd);

        // Keep dates in session so cart can access them
        session([
            'rental_start_date' => $startDate,
            'rental_end_date' => $endDate,
        ]);

        $tab = $request->get('tab', 'satuan'); // satuan, paket_hiking, paket_camping
        $sub = $request->get('sub', 'semua'); // semua, tas, tenda, masak, lampu, sleeping, pakaian, aksesoris
        $search = $request->get('q', '');
        $selectedCategories = $request->input('categories', []);

        $query = Item::query();

        // 1. Search Query
        if (!empty($search)) {
            $query->where('name', 'like', '%' . $search . '%');
        }

        // 2. Category filtering
        if (!empty($selectedCategories) && is_array($selectedCategories)) {
            // New logic: Filter by checked categories from sidebar
            $query->whereIn('category', $selectedCategories);
        } else {
            // Old logic: Tab filtering
            if ($tab === 'paket_hiking') {
                $query->where('category', 'Paket Hiking');
            } elseif ($tab === 'paket_camping') {
                $query->where('category', 'Paket Camping');
            } else {
                // Satuan: exclude packages
                $query->whereNotIn('category', ['Paket Hiking', 'Paket Camping']);

                // Subcategory filtering (only for Satuan)
                if ($sub !== 'semua') {
                    if ($sub === 'tas') {
                        $query->where('category', 'like', '%tas%');
                    } elseif ($sub === 'tenda') {
                        $query->where('category', 'like', '%tenda%');
                    } elseif ($sub === 'masak') {
                        $query->where(function($q) {
                            $q->where('category', 'like', '%masak%')
                              ->orWhere('category', 'like', '%alat masak%');
                        });
                    } elseif ($sub === 'lampu') {
                        $query->where('category', 'like', '%lampu%');
                    } elseif ($sub === 'sleeping') {
                        $query->where(function($q) {
                            $q->where('category', 'like', '%sleeping%')
                              ->orWhere('category', 'like', '%perlengkapan%');
                        });
                    } elseif ($sub === 'pakaian') {
                        $query->where('category', 'like', '%pakaian%');
                    } elseif ($sub === 'aksesoris') {
                        $query->where('category', 'like', '%aksesoris%');
                    }
                }
            }
        }
        $isProductsPage = $request->get('is_products_page', false);
        
        if ($isProductsPage) {
            $items = $query->get();
        } else {
            $items = $query->take(16)->get();
        }

        // Calculate days duration
        $duration = 1;
        try {
            $start = Carbon::parse($startDate);
            $end = Carbon::parse($endDate);
            $duration = $start->diffInDays($end);
            if ($duration <= 0) {
                $duration = 1;
            }
        } catch (\Exception $e) {
            // fallback
        }

        // Retrieve user's cart item count and wishlist
        $cartCount = 0;
        $wishlistIds = [];
        if (auth()->check()) {
            $cartCount = auth()->user()->cartItems()->sum('quantity');
            $wishlistIds = auth()->user()->wishlists()->pluck('item_id')->toArray();
        }


        $allCategories = Item::select('category')->distinct()->pluck('category')->toArray();

        // Fetch Weather Data using WeatherService
        $weatherService = new WeatherService();
        $weatherForecasts = $weatherService->getDestinationsForecast();

        if ($isProductsPage) {
            return view('user.products', compact('items', 'startDate', 'endDate', 'tab', 'sub', 'search', 'duration', 'cartCount', 'wishlistIds', 'isProductsPage', 'allCategories', 'selectedCategories', 'weatherForecasts'));
        }

        return view('user.dashboard', compact('items', 'startDate', 'endDate', 'tab', 'sub', 'search', 'duration', 'cartCount', 'wishlistIds', 'allCategories', 'selectedCategories', 'weatherForecasts'));
    }

    public function products(Request $request)
    {
        $request->merge(['is_products_page' => true]);
        return $this->index($request);
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Wishlist;
use App\Models\Item;
use Illuminate\Support\Facades\Auth;

class WishlistController extends Controller
{
    public function index()
    {
        // Get all wishlist items for the logged-in user
        $wishlists = Wishlist::with('item')->where('user_id', Auth::id())->latest()->get();
        return view('user.wishlist', compact('wishlists'));
    }

    public function toggle(Request $request)
    {
        $request->validate([
            'item_id' => 'required|exists:items,id'
        ]);

        $userId = Auth::id();
        $itemId = $request->item_id;

        $wishlist = Wishlist::where('user_id', $userId)->where('item_id', $itemId)->first();

        if ($wishlist) {
            // Already in wishlist, so remove it (Unlike)
            $wishlist->delete();
            return response()->json([
                'status' => 'removed',
                'message' => 'Barang dihapus dari Favorit.'
            ]);
        } else {
            // Not in wishlist, add it (Like)
            Wishlist::create([
                'user_id' => $userId,
                'item_id' => $itemId
            ]);
            return response()->json([
                'status' => 'added',
                'message' => 'Barang ditambahkan ke Favorit!'
            ]);
        }
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item;

class ItemController extends Controller
{
    public function index(Request $request)
    {
        $query = Item::query();

        if ($request->filled('search')) {
            $query->where(function($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('category', 'like', '%' . $request->search . '%');
            });
        }

        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }

        if ($request->filled('status')) {
            if ($request->status == 'tersedia') {
                $query->where('stock', '>', 0);
            } elseif ($request->status == 'habis') {
                $query->where('stock', 0);
            }
        }

        $items = $query->latest()->get();

        return view('admin.items', compact('items'));
    }

    public function store(Request $request)
    {
        if ($request->has('price_per_day')) {
            $request->merge([
                'price_per_day' => preg_replace('/[^0-9]/', '', $request->price_per_day)
            ]);
        }

        $validated = $request->validate([
            'name'          => ['required', 'string', 'max:255'],
            'category'      => ['required', 'string', 'max:255'],
            'stock'         => ['required', 'integer', 'min:0'],
            'price_per_day' => ['required', 'numeric', 'min:0'],
            'description'   => ['nullable', 'string'],
            'image'         => ['nullable', 'image', 'max:2048'],
        ]);

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('items', 'public');
            $validated['image'] = $path;
        }

        Item::create($validated);

        return redirect()->route('admin.items.index')->with('success', 'Barang berhasil ditambahkan!');
    }

    public function update(Request $request, Item $item)
    {
        if ($request->has('price_per_day')) {
            $request->merge([
                'price_per_day' => preg_replace('/[^0-9]/', '', $request->price_per_day)
            ]);
        }

        $validated = $request->validate([
            'name'          => ['required', 'string', 'max:255'],
            'category'      => ['required', 'string', 'max:255'],
            'stock'         => ['required', 'integer', 'min:0'],
            'price_per_day' => ['required', 'numeric', 'min:0'],
            'description'   => ['nullable', 'string'],
            'image'         => ['nullable', 'image', 'max:2048'],
        ]);

        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($item->image && \Illuminate\Support\Facades\Storage::disk('public')->exists($item->image)) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($item->image);
            }
            $path = $request->file('image')->store('items', 'public');
            $validated['image'] = $path;
        } else {
            unset($validated['image']); // Keep existing image
        }

        $item->update($validated);

        return redirect()->route('admin.items.index')->with('success', 'Data barang berhasil diubah!');
    }

    public function destroy(Item $item)
    {
        if ($item->image && \Illuminate\Support\Facades\Storage::disk('public')->exists($item->image)) {
            \Illuminate\Support\Facades\Storage::disk('public')->delete($item->image);
        }

        $item->delete();

        return redirect()->route('admin.items.index')->with('success', 'Barang berhasil dihapus!');
    }

    public function updateStock(Request $request, Item $item)
    {
        $validated = $request->validate([
            'stock' => ['required', 'integer', 'min:0'],
        ]);

        $item->update(['stock' => $validated['stock']]);

        return redirect()->route('admin.items.index')->with('success', 'Stok barang berhasil diperbarui!');
    }
}

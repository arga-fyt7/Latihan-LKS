<?php

namespace App\Http\Controllers;

use App\Models\Shop;
use Illuminate\Http\Request;
use App\Http\Requests\UpdateShopRequest;

class ShopController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $shops = Shop::all();
        return view('dashboard.shopping', [
            "shops" => $shops
        ], compact('shops'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('dashboard.shopping');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validate form data
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'amount' => 'required|numeric',
            'size' => 'required|in:M,S,L,XL,XXL',
            'color' => 'required', 'string', 'max:255',
            'attachment' => 'required|file|mimes:jpeg,png,mp4|max:2048',
            'sku' => 'required|string|unique:shops',
            'category' => 'required|string|max:255',
            'tags' => 'nullable|string|max:255',
            'contents' => 'nullable|string',
        ]);

        $attachmentName = null;

        if ($request->hasFile('attachment')) {
            $attachment = $request->file('attachment');
            $attachmentName = time() . '.' . $attachment->extension();
            $attachment->move(public_path('storage/shop'), $attachmentName);
        }
        $validatedData['attachment'] = $attachmentName;

        $color = strtoupper($validatedData['color']);;
        if (strpos($color, '#') !== 0) {
            $color = '#' . $color;
        }
        $validatedData['color'] = $color;

        Shop::create($validatedData);

        return redirect()->back()->with('status', 'Shop created successfully.');
    }


    /**
     * Display the specified resource.
     */
    public function show(Shop $shop)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Shop $shop)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateShopRequest $request, Shop $shop)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Shop $shop)
    {
        //
    }
}

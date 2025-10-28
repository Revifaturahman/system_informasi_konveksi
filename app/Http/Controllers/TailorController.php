<?php

namespace App\Http\Controllers;

use App\Models\Tailor;
use Illuminate\Http\Request;

class TailorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tailors = Tailor::all();
        return view('employe.tailor', compact('tailors'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
{
    $validated = $request->validate([
        'name' => 'required|string|max:100',
        'phone_number' => 'required|string|max:20',
        'address' => 'required|string|max:255',
        'rate_per_piece' => 'required|numeric',
        'latitude' => 'required|numeric|between:-90,90',
        'longitude' => 'required|numeric|between:-180,180',
    ]);

    if ($request->id) {
        // update
        $tailor = Tailor::findOrFail($request->id);
        $tailor->update($validated);
        $message = 'Data penjahit berhasil diperbarui!';
    } else {
        // create
        Tailor::create($validated);
        $message = 'Penjahit baru berhasil ditambahkan!';
    }

    return redirect()->route('tailor.index')->with('success', $message);
}


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Tailor $tailor)
    {
        $tailor->delete();
        return redirect()->route('tailor.index')->with('success', 'tailor deleted successfully!');
    }
}

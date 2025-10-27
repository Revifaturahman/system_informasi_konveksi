<?php

namespace App\Http\Controllers;

use App\Models\Overdeck;
use Illuminate\Http\Request;

class OverdeckController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $overdecks = Overdeck::all();
        return view('employe.overdeck', compact('overdecks'));
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
        'rate_per_piece' => 'required|numeric',
    ]);

    if ($request->id) {
        // update
        $overdeck = Overdeck::findOrFail($request->id);
        $overdeck->update($validated);
        $message = 'Data overdek berhasil diperbarui!';
    } else {
        // create
        Overdeck::create($validated);
        $message = 'overdek baru berhasil ditambahkan!';
    }

    return redirect()->route('overdeck.index')->with('success', $message);
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
    public function destroy(Overdeck $overdeck)
    {
        $overdeck->delete();
        return redirect()->route('overdeck.index')->with('success', 'overdeck deleted successfully!');
    }
}

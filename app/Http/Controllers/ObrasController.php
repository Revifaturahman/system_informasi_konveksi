<?php

namespace App\Http\Controllers;

use App\Models\Obras;
use Illuminate\Http\Request;

class ObrasController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        {
        $obrass = Obras::all();
        return view('employe.obras', compact('obrass'));
    }
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
        $obras = Obras::findOrFail($request->id);
        $obras->update($validated);
        $message = 'Data obras berhasil diperbarui!';
    } else {
        // create
        Obras::create($validated);
        $message = 'obras baru berhasil ditambahkan!';
    }

    return redirect()->route('obras.index')->with('success', $message);
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
    public function destroy(Obras $obras)
    {
        $obras->delete();
        return redirect()->route('obras.index')->with('success', 'obras deleted successfully!');
    }
}

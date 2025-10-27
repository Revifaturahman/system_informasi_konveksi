<?php

namespace App\Http\Controllers;

use App\Models\Cutter;
use Illuminate\Http\Request;

class CutterController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $cutters = Cutter::all();
        return view('employe.cutter', compact('cutters'));
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
    ]);

    if ($request->id) {
        // update
        $cutter = Cutter::findOrFail($request->id);
        $cutter->update($validated);
        $message = 'Data pemotong berhasil diperbarui!';
    } else {
        // create
        Cutter::create($validated);
        $message = 'pemotong baru berhasil ditambahkan!';
    }

    return redirect()->route('cutter.index')->with('success', $message);
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
    public function destroy(Cutter $cutter)
    {
        $cutter->delete();
        return redirect()->route('cutter.index')->with('success', 'cutter deleted successfully!');
    }
}

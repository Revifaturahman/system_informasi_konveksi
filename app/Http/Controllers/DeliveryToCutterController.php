<?php

namespace App\Http\Controllers;

use App\Models\Courier;
use App\Models\Cutter;
use App\Models\DeliveryToCutter;
use Illuminate\Http\Request;

class DeliveryToCutterController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $deliveries = DeliveryToCutter::with(['courier', 'cutter'])->latest()->get();
        $couriers = Courier::all();
        $cutters = Cutter::all();

        return view('operation.delivery-to-cutter', compact('deliveries', 'couriers', 'cutters'));
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
            'id' => 'nullable|exists:delivery_to_cutters,id',
            'courier_id' => 'required|exists:couriers,id',
            'cutter_id' => 'required|exists:cutters,id',
            'delivery_date' => 'required|date',
            'due_date' => 'nullable|date',
            'material_weight' => 'required|numeric|min:0',
        ]);

        if ($request->id) {
            // UPDATE
            $validated['remaining'] = $validated['material_weight'];
            $delivery = DeliveryToCutter::findOrFail($request->id);
            $delivery->update($validated);
            return redirect()->route('delivery-to-cutter.index')->with('success', 'Data pengantaran berhasil diperbarui!');
        } else {
            // CREATE baru
            $validated['remaining'] = $validated['material_weight'];
            $validated['status'] = 'proses';
            DeliveryToCutter::create($validated);
            return redirect()->route('delivery-to-cutter.index')->with('success', 'Data pengantaran berhasil ditambahkan!');
        }
    }

    public function takeResult(Request $request, $id)
    {
        $validated = $request->validate([
            'amount_taken' => 'required|numeric|min:0',
        ]);

        $delivery = DeliveryToCutter::findOrFail($id);

        $delivery->remaining -= $validated['amount_taken'];
        if ($delivery->remaining <= 0) {
            $delivery->remaining = 0;
            $delivery->status = 'selesai';
        } elseif ($delivery->remaining < $delivery->material_weight) {
            $delivery->status = 'sebagian';
        }

        $delivery->save();

        return redirect()->route('delivery-to-cutter.index')->with('success', 'Pengambilan hasil berhasil diperbarui!');
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
    public function destroy(DeliveryToCutter $delivery_to_cutter)
    {
        $delivery_to_cutter->delete();
        return redirect()->route('delivery-to-cutter.index')->with('success', 'Data berhasil dihapus!');
    }
}

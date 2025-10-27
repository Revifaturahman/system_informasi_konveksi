<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Courier;
use App\Models\User;
class CourierController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $couriers = Courier::with('user')->latest()->get();
        $users = User::all();
        return view('employe.courier', compact('couriers', 'users'));
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
            'user_id' => 'required|exists:users,id',
            'phone_number' => 'required|string|max:20',
        ]);

        if ($request->id) {
            $courier = Courier::findOrFail($request->id);
            $courier->update($validated);
        } else {
            Courier::create($validated);
        }

        return redirect()->route('courier.index')->with('success', 'Data saved successfully!');
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
    public function destroy(Courier $courier)
    {
        $courier->delete();
        return redirect()->route('employe.courier.index')->with('success', 'Courier deleted successfully!');
    }
}

<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Structural;
use Illuminate\Http\Request;

class StructuralController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $structural = \App\Models\Structural::with('skills', 'sosmeds')->get();

        return response()->json($structural);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $structural = Structural::with('skills', 'sosmeds')->find($id);
        if (! $structural) {
            return response()->json(['message' => 'Structural not found'], 404);
        }

        return response()->json($structural);
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
    public function destroy(string $id)
    {
        //
    }
}

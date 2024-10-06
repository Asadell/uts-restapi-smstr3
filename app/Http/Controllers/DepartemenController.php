<?php

namespace App\Http\Controllers;

use App\Models\Departemen;
use App\Http\Requests\StoreDepartemenRequest;
use App\Http\Requests\UpdateDepartemenRequest;

class DepartemenController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Departemen::all();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreDepartemenRequest $request)
    {
        $departemen = Departemen::query()->create($request->all());

        return ['data' => $departemen];
    }

    /**
     * Display the specified resource.
     */
    public function show(Departemen $departemen)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateDepartemenRequest $request, Departemen $departemen)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Departemen $departemen)
    {
        //
    }
}

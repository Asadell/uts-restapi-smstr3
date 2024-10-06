<?php

namespace App\Http\Controllers;

use App\Classes\ApiResponseClass;
use App\Models\Departemen;
use App\Http\Requests\StoreDepartemenRequest;
use App\Http\Requests\UpdateDepartemenRequest;
use App\Http\Resources\DepartemenResource;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class DepartemenController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $departemen = Departemen::all();
    
            return ApiResponseClass::sendResponse(DepartemenResource::collection($departemen), '', 200);
        } catch (\Exception $e) {
            ApiResponseClass::throw($e, 'Failed to show Departemen!');
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreDepartemenRequest $request)
    {
        try {
            $departemen = Departemen::query()->create($request->all());
    
            return ApiResponseClass::sendResponse(new DepartemenResource($departemen), 'Departemen Create Successful', 201);
        } catch (\Exception $e) { // kalo validasi salah TIDAK kesini
            ApiResponseClass::throw($e, 'Failed to store Departemen!'); // kalo sql mati kesini
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        try {
            $departemen = Departemen::findOrFail($id);
    
            return ApiResponseClass::sendResponse(new DepartemenResource($departemen), '', 200);
        } catch (ModelNotFoundException $e) {
            ApiResponseClass::throw($e, 'Departemen not found.', 404);
        } catch (\Exception $e) {
            ApiResponseClass::throw($e, 'Failed to retrieve Departemen!');
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateDepartemenRequest $request, $id)
    {
        try {
            $departemen = Departemen::findOrFail($id);
            $departemen->update($request->validated());

            return ApiResponseClass::sendResponse(new DepartemenResource($departemen), 'Departemen Update Successful', 200);
            // return ApiResponseClass::sendResponse(null, 'Departemen Update Successful', 200);
        } catch (ModelNotFoundException $e) {
            ApiResponseClass::throw($e, 'Departemen not found.', 404);
        } catch (\Exception $e) { // kalo validasi salah TIDAK kesini
            ApiResponseClass::throw($e, 'Failed to update Departemen!'); // kalo sql mati kesini
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        
        try {
            $departemen = Departemen::findOrFail($id);
            $departemen->delete();

            return ApiResponseClass::sendResponse(null, 'Departemen Delete Successful', 200);
        } catch (ModelNotFoundException $e) {
            ApiResponseClass::throw($e, 'Departemen not found.', 404);
        } catch (\Exception $e) { // kalo validasi salah TIDAK kesini
            ApiResponseClass::throw($e, 'Failed to delete Departemen!'); // kalo sql mati kesini
        }
    }
}

<?php

namespace App\Http\Controllers;

use App\Classes\ApiResponseClass;
use App\Models\Jabatan;
use App\Http\Requests\StoreJabatanRequest;
use App\Http\Requests\UpdateJabatanRequest;
use App\Http\Resources\JabatanResource;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class JabatanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $jabatan = Jabatan::all();
    
            return ApiResponseClass::sendResponse(JabatanResource::collection($jabatan), '', 200);
        } catch (\Exception $e) {
            ApiResponseClass::throw($e, 'Failed to show Jabatan!');
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreJabatanRequest $request)
    {
        try {
            $jabatan = Jabatan::query()->create($request->all());
    
            return ApiResponseClass::sendResponse(new JabatanResource($jabatan), 'Jabatan Create Successful', 201);
        } catch (\Exception $e) {
            ApiResponseClass::throw($e, 'Failed to store Jabatan!');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        try {
            $jabatan = Jabatan::findOrFail($id);
    
            return ApiResponseClass::sendResponse(new JabatanResource($jabatan), '', 200);
        } catch (ModelNotFoundException $e) {
            ApiResponseClass::throw($e, 'Jabatan not found.', 404);
        } catch (\Exception $e) {
            ApiResponseClass::throw($e, 'Failed to retrieve Jabatan!');
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateJabatanRequest $request, $id)
    {
        try {
            $jabatan = Jabatan::findOrFail($id);
            $jabatan->update($request->validated());

            return ApiResponseClass::sendResponse(new JabatanResource($jabatan), 'Jabatan Update Successful', 200);
        } catch (ModelNotFoundException $e) {
            ApiResponseClass::throw($e, 'Jabatan not found.', 404);
        } catch (\Exception $e) {
            ApiResponseClass::throw($e, 'Failed to update Jabatan!');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            $jabatan = Jabatan::findOrFail($id);
            $jabatan->delete();

            return ApiResponseClass::sendResponse(null, 'Jabatan Delete Successful', 200);
        } catch (ModelNotFoundException $e) {
            ApiResponseClass::throw($e, 'Jabatan not found.', 404);
        } catch (\Exception $e) {
            ApiResponseClass::throw($e, 'Failed to delete Jabatan!');
        }
    }
}

<?php

namespace App\Http\Controllers;

use App\Classes\ApiResponseClass;
use App\Models\Gaji;
use App\Http\Requests\StoreGajiRequest;
use App\Http\Requests\UpdateGajiRequest;
use App\Http\Resources\GajiResource;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class GajiController extends Controller implements HasMiddleware
{
    public static function middleware() {
        return [
            new Middleware('auth:sanctum', except: ['index', 'show'])
        ];
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $gaji = Gaji::all();
    
            return ApiResponseClass::sendResponse(GajiResource::collection($gaji), '', 200);
        } catch (\Exception $e) {
            ApiResponseClass::throw($e, 'Failed to show Gaji!');
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreGajiRequest $request)
    {
        try {
            $gaji = Gaji::query()->create($request->all());
    
            return ApiResponseClass::sendResponse(new GajiResource($gaji), 'Gaji Create Successful', 201);
        } catch (\Exception $e) {
            ApiResponseClass::throw($e, 'Failed to store Gaji!');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        try {
            $gaji = Gaji::findOrFail($id);
    
            return ApiResponseClass::sendResponse(new GajiResource($gaji), '', 200);
        } catch (ModelNotFoundException $e) {
            ApiResponseClass::throw($e, 'Gaji not found.', 404);
        } catch (\Exception $e) {
            ApiResponseClass::throw($e, 'Failed to retrieve Gaji!');
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateGajiRequest $request, $id)
    {
        try {
            $gaji = Gaji::findOrFail($id);
            $gaji->update($request->validated());

            return ApiResponseClass::sendResponse(new GajiResource($gaji), 'Gaji Update Successful', 200);
        } catch (ModelNotFoundException $e) {
            ApiResponseClass::throw($e, 'Gaji not found.', 404);
        } catch (\Exception $e) {
            ApiResponseClass::throw($e, 'Failed to update Gaji!');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            $gaji = Gaji::findOrFail($id);
            $gaji->delete();

            return ApiResponseClass::sendResponse(null, 'Gaji Delete Successful', 200);
        } catch (ModelNotFoundException $e) {
            ApiResponseClass::throw($e, 'Gaji not found.', 404);
        } catch (\Exception $e) {
            ApiResponseClass::throw($e, 'Failed to delete Gaji!');
        }
    }
}

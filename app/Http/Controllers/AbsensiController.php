<?php

namespace App\Http\Controllers;

use App\Classes\ApiResponseClass;
use App\Models\Absensi;
use App\Http\Requests\StoreAbsensiRequest;
use App\Http\Requests\UpdateAbsensiRequest;
use App\Http\Resources\AbsensiResource;
use App\Service\AbsensiService;
use GuzzleHttp\Middleware;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Validation\ValidationException;

class AbsensiController extends Controller
{
    protected $absensiService;

    public function __construct(AbsensiService $absensiService)
    {
        $this->absensiService = $absensiService;
    }
    
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $absensi = Absensi::query()->latest()->get();
    
            return ApiResponseClass::sendResponse(AbsensiResource::collection($absensi), '', 200);
        } catch (\Exception $e) {
            ApiResponseClass::throw($e, 'Failed to show Absensi!');
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreAbsensiRequest $request)
    {
        try {
            $absensi = $this->absensiService->storeAbsensi($request->all());
            
            // print_r($absensi);
            // die();
            
            if (is_array($absensi) && count($absensi) === 1 && array_key_exists('message', $absensi)) {
                return ApiResponseClass::sendResponse(null, $absensi['message'], 200);
            }
            
            return ApiResponseClass::sendResponse(new AbsensiResource($absensi), $absensi['message'], 201);
        } catch (ValidationException $e) {
            ApiResponseClass::throw($e, $e->getMessage(), 400);
        } catch (\Exception $e) {
            $statusCode = ($e->getCode() === 409) ? 409 : 500;
            ApiResponseClass::throw($e, $e->getMessage(), $statusCode);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        try {
            $absensi = Absensi::findOrFail($id);
    
            return ApiResponseClass::sendResponse(new AbsensiResource($absensi), '', 200);
        } catch (ModelNotFoundException $e) {
            ApiResponseClass::throw($e, 'Absensi not found.', 404);
        } catch (\Exception $e) {
            ApiResponseClass::throw($e, 'Failed to retrieve Absensi!');
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateAbsensiRequest $request, $id)
    {
        try {
            $absensi = Absensi::findOrFail($id);
            $absensi->update($request->validated());

            return ApiResponseClass::sendResponse(new AbsensiResource($absensi), 'Absensi Update Successful', 200);
        } catch (ValidationException $e) {
            ApiResponseClass::throw($e, $e->getMessage(), 400);
        } catch (ModelNotFoundException $e) {
            ApiResponseClass::throw($e, 'Absensi not found.', 404);
        } catch (\Exception $e) {
            ApiResponseClass::throw($e, 'Failed to update Absensi!');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            $absensi = Absensi::findOrFail($id);
            $absensi->delete();

            return ApiResponseClass::sendResponse(null, 'Absensi Delete Successful', 200);
        } catch (ModelNotFoundException $e) {
            ApiResponseClass::throw($e, 'Absensi not found.', 404);
        } catch (\Exception $e) {
            ApiResponseClass::throw($e, 'Failed to delete Absensi!');
        }
    }
}

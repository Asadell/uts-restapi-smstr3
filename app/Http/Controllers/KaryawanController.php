<?php

namespace App\Http\Controllers;

use App\Classes\ApiResponseClass;
use App\Models\Karyawan;
use App\Http\Requests\StoreKaryawanRequest;
use App\Http\Requests\UpdateKaryawanRequest;
use App\Http\Resources\KaryawanResource;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class KaryawanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $karyawan = Karyawan::query()->latest()->get();;
    
            return ApiResponseClass::sendResponse(KaryawanResource::collection($karyawan), '', 200);
        } catch (\Exception $e) {
            ApiResponseClass::throw($e, 'Failed to show Karyawan!');
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreKaryawanRequest $request)
    {
        // $input = $request->all();
        // $input['password'] = bcrypt($input['password']);

        // $karyawan = Karyawan::query()->create($input);
        // $karyawan['token'] = $karyawan->createToken($karyawan->nama_lengkap)->plainTextToken;

        // return [
        //     'data' => $karyawan,
        // ];

        try {
            $input = $request->all();
            $input['password'] = bcrypt($input['password']);

            $karyawan = Karyawan::query()->create($input);
            $karyawan['access_token'] = $karyawan->createToken($karyawan->email)->plainTextToken;

            return ApiResponseClass::sendResponse(new KaryawanResource($karyawan), 'Karyawan Create Successful', 201);
        } catch (\Exception $e) {
            ApiResponseClass::throw($e, 'Failed to Register Karyawan!');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        try {
            $karyawan = Karyawan::with(['departemen', 'jabatan'])->findOrFail($id);
    
            return ApiResponseClass::sendResponse(new KaryawanResource($karyawan), '', 200);
        } catch (ModelNotFoundException $e) {
            ApiResponseClass::throw($e, 'Karyawan not found.', 404);
        } catch (\Exception $e) {
            ApiResponseClass::throw($e, 'Failed to retrieve Karyawan!');
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateKaryawanRequest $request, $id)
    {
        try {
            $karyawan = Karyawan::findOrFail($id);
            $karyawan->update($request->validated());

            return ApiResponseClass::sendResponse(new KaryawanResource($karyawan), 'Karyawan Update Successful', 200);
        } catch (ModelNotFoundException $e) {
            ApiResponseClass::throw($e, 'Karyawan not found.', 404);
        } catch (\Exception $e) {
            ApiResponseClass::throw($e, 'Failed to update Karyawan!');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            $karyawan = Karyawan::findOrFail($id);
            $karyawan->delete();

            return ApiResponseClass::sendResponse(null, 'Karyawan Delete Successful', 200);
        } catch (ModelNotFoundException $e) {
            ApiResponseClass::throw($e, 'Karyawan not found.', 404);
        } catch (\Exception $e) {
            ApiResponseClass::throw($e, 'Failed to delete Karyawan!');
        }
    }
}

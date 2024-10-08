<?php

namespace App\Service;

use App\Classes\ApiResponseClass;
use App\Enum\AbsensiStatus;
use App\Models\Absensi;
use App\Models\Karyawan;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class AbsensiService
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }

    public function storeAbsensi($data) {
        $isExistsAbsensi = Absensi::where('karyawan_id',  $data['karyawan_id'])
                            ->where('tanggal', $data['tanggal'])
                            ->first();
        // die('1');
            // print_r($isExistsAbsensi);
            // die();
        if ($isExistsAbsensi) {
            // die('11');
            $this->checkUsersOwnAbsensi($isExistsAbsensi->id);
            $this->updateAbsensi($data);
            // $response = $this->updateAbsensi($data);
            // print_r($response['message']);
            // die();
            $response['message'] = 'Check-out successful. See you again.';

            return $response;
        }

        $response = Absensi::create($data);
        $response['message'] = 'Check-in successful. Welcome.';

        return $response;
    }

    public function updateAbsensi($data) {
        $absensi = Absensi::where('karyawan_id',  $data['karyawan_id'])
                            ->where('tanggal', $data['tanggal'])
                            ->first();

        if (!is_null($absensi->waktu_keluar)) {
            throw new \Exception('You have already checked in for today.', 409);
        }

        $validator = Validator::make($data, [
            'waktu_keluar' => 'required|date_format:H:i:s',
        ]);
        if($validator->fails()) {
            throw  new ValidationException($validator);
        }

        $absensi->update([
            'waktu_keluar' => $data['waktu_keluar'],
        ]);

        return;
    }

    public function checkUsersOwnAbsensi($absensiId) {
        $user = Auth::user();
        // print_r($user);
        // die();
        $absensi = Absensi::findOrFail($absensiId);

        if ($user->id !== $absensi->karyawan_id) {
            throw new AuthorizationException('You are not authorized to update this absensi.');
        }

        return true;
    }

    public function isOnLeaveOrAbsent($absensiId) {
        $absensi = Absensi::findOrFail($absensiId);
        
        if ($absensi->status_absensi == AbsensiStatus::IZIN->value || $absensi->status_absensi == AbsensiStatus::SAKIT->value || $absensi->status_absensi == AbsensiStatus::ALPHA->value) {
            ApiResponseClass::throw('Clock-out failed', 'You cannot clock out because your status is either leave, sick, or absent.', 403);
        }
    }
}

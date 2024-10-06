<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class KaryawanResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'nama_lengkap' => $this->nama_lengkap,
            'email' => $this->email,
            'nomor_telepon' => $this->nomor_telepon,
            'tanggal_lahir' => $this->tanggal_lahir,
            'alamat' => $this->alamat,
            'tanggal_masuk' => $this->tanggal_masuk,
            // 'departemen' => new DepartemenResource($this->whenLoaded('departemen')), 
            // 'jabatan' => new JabatanResource($this->whenLoaded('jabatan')), 
            'departemen' => $this->departemen->nama_departemen, 
            'jabatan' => $this->jabatan->nama_jabatan, 
            'status' => $this->status,
        ];
    }
}

<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UnitKerjaResource extends JsonResource
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
            'nama' => $this->nama,
            'keterangan' => $this->keterangan,
            'is_pilihan' => $this->is_pilihan,
            'parent_id' => $this->parent_id,
            'parent' => new UnitKerjaResource($this->whenLoaded('parent')), // Memuat data parent jika ada
            'children' => UnitKerjaResource::collection($this->whenLoaded('children')), // Memuat semua anak
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}

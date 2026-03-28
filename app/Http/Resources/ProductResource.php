<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'kode_barang' => $this->kode_barang,
            'nama_barang' => $this->nama_barang,
            'stok_saat_ini' => $this->stok_saat_ini,
            'stok_minimum' => $this->stok_minimum,
            'satuan' => $this->satuan,
            'harga' => $this->harga,
            'created_at' => $this->created_at,
        ];
    }
}

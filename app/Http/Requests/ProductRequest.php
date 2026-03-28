<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules()
    {
        $id = $this->route('product')?->id;

        return [
            'kode_barang' => 'required|string|max:50|unique:products,kode_barang,' . $id,
            'nama_barang' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'stok_saat_ini' => 'required|integer|min:0',
            'stok_minimum' => 'required|integer|min:0',
            'satuan' => 'required|string|max:20',
            'harga' => 'nullable|numeric|min:0',
        ];
    }
}

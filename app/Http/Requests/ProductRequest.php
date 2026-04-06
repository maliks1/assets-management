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
        $categoryType = $this->input('category_type');
        $subCategoryRules = $categoryType === 'persediaan'
            ? 'required|in:project'
            : 'required|in:kantor,project';

        return [
            'kode_barang' => 'required|string|max:50|unique:products,kode_barang,' . $id,
            'nama_barang' => 'required|string|max:255',
            'stok_saat_ini' => 'required|integer|min:0',
            'satuan' => 'required|string|max:20',
            'harga' => 'nullable|numeric|min:0',

            // Category fields
            'category_type' => 'required|in:persediaan,perlengkapan,peralatan',
            'sub_category' => $subCategoryRules,
            'no_project' => 'required_if:sub_category,project|string|max:255',

            // Depreciation fields (only applicable for peralatan/equipment)
            'acquisition_date' => 'nullable|date',
            'useful_life_years' => 'nullable|integer|min:1|max:50',
            'salvage_value' => 'nullable|numeric|min:0',
            'accumulated_depreciation' => 'nullable|numeric|min:0',
        ];
    }
}

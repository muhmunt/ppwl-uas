<?php

namespace App\Http\Requests;

use App\Rules\SufficientStock;
use Illuminate\Foundation\Http\FormRequest;

class OrderRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth()->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        // Get current order ID if editing
        $currentOrderId = $this->route('order')?->id;

        return [
            'customer_name' => ['nullable', 'string', 'max:255'],
            'table_number' => ['nullable', 'string', 'max:255'],
            'notes' => ['nullable', 'string'],
            'items' => [
                'required',
                'array',
                'min:1',
                new SufficientStock($this->input('items', []), $currentOrderId)
            ],
            'items.*.menu_id' => ['required', 'exists:menus,id'],
            'items.*.quantity' => ['required', 'integer', 'min:1'],
            'items.*.price' => ['required', 'numeric', 'min:0'],
            'items.*.notes' => ['nullable', 'string'],
        ];
    }

    /**
     * Get custom error messages for validation rules.
     */
    public function messages(): array
    {
        return [
            'items.required' => 'Keranjang tidak boleh kosong.',
            'items.min' => 'Minimal harus ada 1 item dalam pesanan.',
            'items.*.menu_id.required' => 'Item menu harus dipilih.',
            'items.*.menu_id.exists' => 'Menu yang dipilih tidak valid.',
            'items.*.quantity.required' => 'Jumlah item harus diisi.',
            'items.*.quantity.min' => 'Jumlah item minimal 1.',
        ];
    }
}

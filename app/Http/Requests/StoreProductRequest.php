<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreProductRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name' => 'required',
            'description' => 'required|min:250',
            'type' => 'required|in:t-shirt,hat,jacket,hoodie,pants,shoes',
            'price' => ['required', 'numeric', function ($attribute, $value, $fail) {
                if (strpos($value, 'kata_kunci') !== false) {
                    $fail('Kolom ' . $attribute . ' tidak boleh mengandung kata kunci tertentu.');
                }
            }],
            'thumbnail' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'gambar' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ];
    }
}

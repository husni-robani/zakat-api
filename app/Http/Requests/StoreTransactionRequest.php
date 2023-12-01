<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreTransactionRequest extends FormRequest
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
    public function rules(): array
    {
        return [
//            'amount' => 'required|integer|min:1000',
            'amount' =>  [
                'required',
                'integer',
                function ($attribute, $value, $fail) {
                    $good_types_id = $this->input('good_types_id');

                    if ($good_types_id == 1 && $value < 1000) {
                        $fail("masukan jumlah uang dengan minimal Rp 1.000");
                    }

                    if ($good_types_id == 2 && $value < 1) {
                        $fail("minimal beras 1kg");
                    }
                },
            ],
            'description_transaction' => 'nullable|string',
            'donation_types_id' => 'required|in:1,2,3,4',
            'good_types_id' => 'required|in:1,2',
            'name' => 'required',
            'phone_number' => ['required', 'regex:/^(\+62|0)[0-9]{8,15}$/'],
            'email' => 'nullable|email',
        ];
    }

    public function messages()
    {
        return [
            'amount.integer' => 'input harus berupa angka',
            'amount.required' => 'wajib diisi',
            'donation_types_id.required' => 'pilih tipe donasi',
            'donation_types_id.in' => 'pilih tipe donasi dengan benar',
            'good_types_id.in' => 'pilih barang dengan benar',
            'good_types_id.required' => 'pilih tipe barang untuk di donasikan',
            'name.required' => 'wajib diisi',
            'phone_number.required' => 'wajib diisi',
            'phone_number.regex' => 'masukan format nomor hp dengan benar',
            'email.email' => 'masukan format email dengan benar'
        ]; // TODO: Change the autogenerated stub
    }
}
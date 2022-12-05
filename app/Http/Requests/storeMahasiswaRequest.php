<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class storeMahasiswaRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            "nrp" => "required|min:9|max:10|unique:mahasiswas,nrp",
            "nama" => "required|min:3",
            "email" => "required|min:5|email|unique:mahasiswas,email",
            "jurusan" => "required"
        ];
    }
}

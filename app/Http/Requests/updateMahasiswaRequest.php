<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class updateMahasiswaRequest extends FormRequest
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
            "nama" => "nullable|min:3",
            "nrp" => "nullable|min:9|max:10|unique:mahasiswas,nrp",
            "email" => "nullable|min:5|email|unique:mahasiswas,email",
            "jurusan" => "nullable|min:2"
        ];
    }
}

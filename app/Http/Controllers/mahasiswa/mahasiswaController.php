<?php

namespace App\Http\Controllers\mahasiswa;

use App\Helpers\keyAccessApi;
use App\Helpers\ResponseFormatter;
use App\Http\Controllers\Controller;
use App\Http\Requests\storeMahasiswaRequest;
use App\Http\Requests\updateMahasiswaRequest;
use App\Models\keys;
use App\Models\limits;
use App\Models\mahasiswa;
use DateTime;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class mahasiswaController extends Controller
{
    public function generateKey()
    {
        $key = [
            "key" => Str::random(10),
            "user_id" => auth()->user()->id,
        ];

        $limit = [
            "uri" => "mahasiswa",
            "count" => "0",
            "api_key" => $key["key"],
            "hour_started" => new DateTime()
        ];

        keys::create($key);
        limits::create($limit);
        return ResponseFormatter::success(["Api-key" => $key["key"]], "Api key has been generated");
    }

    public function index()
    {
        $key = keys::where('key', request()->query('api-key'))->first();
        if (!$key || $key == null) {
            return ResponseFormatter::error(null, "Please insert a correct key");
        } elseif ($key) {
            $limit = limits::where('api_key', $key["key"])->first();
            if ($limit) {
                $limit_key = keyAccessApi::limit_key($limit);
                if ( $limit_key == "createLimits" || $limit_key == "KeyAccessAvailable" || $limit_key == "limitRegenerate") {
                    if ($id = request()->query('id')) { $mhs = mahasiswa::where('id', $id)->first();
                    } else { $mhs = mahasiswa::all(); }

                    if ($mhs) { return ResponseFormatter::success($mhs);
                    } else { ResponseFormatter::error(null, "Id not found"); }
                } elseif ($limit_key == "ExpKey") {
                    return ResponseFormatter::error(null, "This API key has reached the time limit", 404);
                }
            }
        } else { return ResponseFormatter::error(null, "Something was wrong"); }
    }

    public function destroy(Request $request)
    {
        $key = keys::where('key', request()->query('api-key'))->first();
        if (!$key || $key == null) {
            return ResponseFormatter::error(null, "Please insert a correct key");
        } else {
            $data = mahasiswa::where('id', $request->mhs_id)->first();
            if ($data) {
                $data->delete();
                return ResponseFormatter::success("Mahasiswa has been deleted");
            } else { return ResponseFormatter::error(null, "Id not found", 404); }
        }
    }

    public function store(storeMahasiswaRequest $request)
    {
        $key = keys::where('key', request()->query('api-key'))->first();
        if (!$key || $key == null) {
            return ResponseFormatter::error(null, "Please insert a correct key");
        } else {
            $data = $request->all();
            $data = mahasiswa::create($data);
            return ResponseFormatter::success($data, "Mahasiswa has been added");
        }
    }

    public function update(updateMahasiswaRequest $request)
    {
        $key = keys::where("key", request()->query("api-key"))->first();
        if (!$key || $key == null) {
            return ResponseFormatter::error(null, "Please insert a correct key");
        } else {
            $db = mahasiswa::where("id" ,$request->id)->first();
            if ($db) {
                $data = $request->all();
                $db->update($data);
                return ResponseFormatter::success($db, "Mahasiswa has been updated");
            } else {
                return ResponseFormatter::error(null, "Mahasiswa not found", 404);
            }
        }
    }
}

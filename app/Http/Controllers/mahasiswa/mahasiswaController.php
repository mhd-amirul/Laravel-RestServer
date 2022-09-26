<?php

namespace App\Http\Controllers\mahasiswa;

use App\Http\Controllers\Controller;
use App\Models\keys;
use App\Models\limits;
use App\Models\mahasiswa;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class mahasiswaController extends Controller
{

    public function validationInput($data, $rules)
    {
        $val = Validator::make($data, $rules);
        if ($val->fails()) {
            return
            [
                'status' => false,
                'message' => $val->errors()
            ];
        } else {
            return ['status' => true];
        }
    }

    public function request_apiKey($key)
    {
        if (!$key || $key == null) {
            return [
                "status" => false,
                "message" => "Please Insert a Correct key"
            ];
        } else {
            return [
                "status" => true,
            ];
        }
    }

    public function checkTimeExp($timeStart)
    {
        date_default_timezone_set("Asia/Jakarta");
        $timeStart = new DateTime($timeStart);
        $timeEnd = new DateTime();
        $allTime = $timeEnd->getTimestamp() - $timeStart->getTimestamp();
        $regenerateTime = 86400;
        if ($allTime > $regenerateTime) {
            # 24 jam ke detik = 86400
            return [
                'status' => 'limitRegenerate',
                'countTime' => $allTime,
                'newTime' => $timeEnd
            ];
        } elseif ($allTime <= $regenerateTime) {
            return [
                'status' => 'limitKey',
                'countTime' => $allTime,
            ];
        } else {
            return ['status' => 'checkTimeExp Err'];
        }
    }

    public function limit_key($key)
    {
        $limit = limits::where('api_key', $key)->first();
        $limitAccessKey = 1000;
        if ($limit) {
            $checkTimeExp = $this->checkTimeExp($limit->hour_started);
            if ($checkTimeExp['status'] == 'limitRegenerate') {
                $count = [
                    'count' => 1,
                    'hour_started' => $checkTimeExp['newTime']
                ];
                $limit->update($count);
                return [
                    'status' => 'limitRegenerate',
                    'message' => 'Key ready',
                    'data_limit' => $limit
                ];
            } elseif ($checkTimeExp['status'] == 'limitKey' && $limit['count'] < $limitAccessKey) {
                $count = [
                    'count' => $limit['count'] += 1,
                ];
                $limit->update($count);
                return [
                    'status' => 'KeyAccessAvailable',
                    'message' => 'Key ready'
                ];
            } elseif ($checkTimeExp['status'] == 'limitKey' && $limit['count'] >= $limitAccessKey) {
                return [
                    'status' => 'ExpKey',
                    'message' => 'Key have limits'
                ];
            }
        } else {
            $limit = [
                    'uri' => 'mahasiswa',
                    'hour_started' => new DateTime(),
                    'api_key' => $key,
                    'count' => 1
                ];
            $createLimits = limits::create($limit);
            return [
                'status' => 'createLimits',
                'message' => 'Key ready',
                'items' => $createLimits
            ];
        }
    }

    public function index()
    {
        $key = keys::where('key', request()->query('api-key'))->first();
        if ($this->request_apiKey($key)['status'] == false) {
            return response()->json($this->request_apiKey($key));
        } elseif ($this->request_apiKey($key) == true) {
            if ($id = request()->query('id')) {
                $data = mahasiswa::where('id', $id)->first();
            } else {
                $data = mahasiswa::all();
            }
            if ($data) {
                $limit_key = $this->limit_key($key['key']);
                if ( $limit_key['status'] == "createLimits" || $limit_key['status'] == "KeyAccessAvailable" || $limit_key['status'] == "limitRegenerate") {
                    return response()->json($data, 200);
                } elseif ($limit_key['status'] == "ExpKey") {
                    return $limit_key;
                }
            } else {
                return response()->json([
                    'status' => false,
                    'message' => 'id not found'
                ], 404);
            }
        } else {
            return response()->json(['status' => 'failed']);
        }
    }

    public function destroy()
    {
        $key = keys::where('key', request()->query('api-key'))->first();
        if ($this->request_apiKey($key)['status'] == false) {
            return response()->json($this->request_apiKey($key));
        } elseif ($this->request_apiKey($key) == true) {
            $data = mahasiswa::where('id', Request()->query('detroyID'))->first();
            if ($data) {
                $data->delete();
                return response()->json([
                    'status' => true,
                    'id' => $data,
                    'message' => 'deleted'
                ], 200);
            } else {
                return response()->json([
                    'status' => false,
                    'message' => 'id not found'
                ], 404);
            }
        } else {

        }
    }

    public function store(Request $request)
    {
        $key = keys::where('key', request()->query('api-key'))->first();
        if ($this->request_apiKey($key)['status'] == false) {
            return response()->json($this->request_apiKey($key));
        } else {
            $data = $request->all();
            $rules = [
                'nrp' => 'required|min:9|max:10|unique:mahasiswas,nrp',
                'nama' => 'required|min:3',
                'email' => 'required|min:5|email|unique:mahasiswas,email',
                'jurusan' => 'required',
            ];

            $val = $this->validationInput($data, $rules);

            if ($val['status'] == false) {
                return response()->json($val['message'], 422);
            }

            $data = mahasiswa::create($data);
            return response()->json(
                [
                    'status' => true,
                    'message' => 'proccess was successfully',
                    'items' => $data
                ], 201
            );
        }
    }

    public function update(Request $request)
    {
        $key = keys::where('key', request()->query('api-key'))->first();
        if ($this->request_apiKey($key)['status'] == false) {
            return response()->json($this->request_apiKey($key));
        } else {
            $db = mahasiswa::where('id' ,$request->id)->first();
            if ($db) {
                $data = $request->all();
                $rules = ['nama' => 'min:3',];
                if ($request->nrp && $request->nrp != $db->nrp) {
                    $rules['nrp'] = 'required|min:9|max:10|unique:mahasiswas,nrp';
                }
                if ($request->email && $request->email != $db->email) {
                    $rules['email'] = 'required|min:5|email|unique:mahasiswas,email';
                }

                $val = $this->validationInput($data, $rules);
                if ($val['status'] == false) {
                    return response()->json($val, 422);
                }

                $data[] = $db->update($data);
                return response()->json(
                    [
                        'status' => true,
                        'message' => 'proccess was successfully',
                        'items' => $data
                    ], 201
                );
            } else {
                return response()->json([
                    'status' => false,
                    'message' => "mahasiswa not found"
                ], 404);
            }
        }
    }
}

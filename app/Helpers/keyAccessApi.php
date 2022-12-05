<?php

namespace App\Helpers;

use DateTime;

class keyAccessApi
{
    // public static function request_apiKey($key, $limit)
    // {
    //     if (!$key || $key == null) {
    //         return ResponseFormatter::error(null, "Please insert a correct key");
    //     }
    // }

    public static function checkTimeExp($timeStart)
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

    public static function limit_key($limit, $limitAccessKey = 1000)
    {
        $checkTimeExp = keyAccessApi::checkTimeExp($limit->hour_started);
        if ($checkTimeExp["status"] == "limitRegenerate") {
            $count = [
                "count" => 1,
                "hour_started" => $checkTimeExp["newTime"]
            ];
            $limit->update($count);
            return "limitRegenerate";
        } elseif ($checkTimeExp["status"] == "limitKey" && $limit["count"] < $limitAccessKey) {
            $count = [ "count" => $limit["count"] += 1 ];
            $limit->update($count);
            return "KeyAccessAvailable";
        } elseif ($checkTimeExp["status"] == "limitKey" && $limit["count"] >= $limitAccessKey) {
            return "ExpKey";
        }
    }
}

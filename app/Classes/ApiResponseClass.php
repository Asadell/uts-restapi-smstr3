<?php

namespace App\Classes;

use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ApiResponseClass
{
    public static function rollback($e, $message ="Something went wrong! Process not completed"){
        DB::rollBack();
        self::throw($e, $message);
    }

    public static function throw($e, $message ="Something went wrong! Process not completed", $code = 500){
        Log::info($e);
        throw new HttpResponseException(response()->json(["message"=> $message], $code));
    }

    public static function sendResponse($result, $message, $code = 200){
        $response=[
            'success' => true,
        ];
        if(!empty($message)){
            $response['message'] = $message;
        }
        if(!empty($result)){
            $response['data'] = $result;
        }
        return response()->json($response, $code);
    }
}

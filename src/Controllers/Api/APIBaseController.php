<?php

namespace XRA\Blog\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller as Controller;

class APIBaseController extends Controller
{

    public function sendResponse($result, $message){
        if(\Request::ajax()){
            \Debugbar::disable();
        }
    	$response = [
            'success' => true,
            'data'    => $result,
            'message' => $message,
        ];

        return response()->json($response, 200);
    }

    public function sendError($error, $errorMessages = [], $code = 500){ //error 404
        if(\Request::ajax()){
            \Debugbar::disable();
        }
    	$response = [
            'success' => false,
            'message' => $error,
        ];

        if(!empty($errorMessages)){
            $response['data'] = $errorMessages;
        }

        return response()->json($response, $code);
    }
}
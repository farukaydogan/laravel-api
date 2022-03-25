<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

/**
 *
 * @OA\Schema (
 *     title="ApiResponse",
 *     description="ApiResponse model",
 *     type="object",
 *     schema="ApiResponse",
 *     properties={
 *         @OA\Property (property="success", type="boolean"),
 *         @OA\Property (property="data", type="object"),
 *         @OA\Property (property="message", type="string"),
 *     }
 * )
 */
class ApiController extends Controller
{
    public function apiResponse($resultType, $data, $message = null, $status = 200)
    {
        /*
        $response = [
            'data' => $data,
            'message' => $message,
        ];
        return response()->json($response, $status);
        */

        $response = [];
        $response['success'] = $resultType == ResultType::Success ? true : false;

        if (isset($data)) {
            if ($resultType != ResultType::Error)
                $response['data'] = $data;
            if ($resultType == ResultType::Error)
                $response['data'] = $data;
        }
        if (isset($message)) {
            $response['message'] = $message;
        }

        return response()->json($response, $status);
    }
}

class ResultType
{
    const Success = 1;
    const Information = 2;
    const Warning = 3;
    const Error = 4;
}

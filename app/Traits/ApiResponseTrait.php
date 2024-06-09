<?php

namespace App\Traits;

trait ApiResponseTrait {

    public function exceptionResponse($message) {
        return response()->json([
                    'code' => 500,
                    'status' => 'fail',
                    'message' => gettype($message) === 'array' ? $message : array($message),
                    'data' => null
                        ], 200);
    }

    /**
     * Invalid Request Response / Custom Validation Response
     *
     * @param string $message
     * @param array|null $errors
     * @return \Illuminate\Http\JsonResponse
     */
    public function invalidResponse($message, array $errors = null, $code = 422) {
        return response()->json([
                    'status' => 'fail',
                    'message' => gettype($message) === 'array' ? $message : array($message),
                    'data' => $errors,
                    'code' => $code,
                        ], 200);
    }

    public function successResponse($message, $data = null) {
        return response()->json([
                    'message' => gettype($message) === 'array' ? $message : array($message),
                    'status' => 'success',
                    'data' => $data,
                    'code' => 200,
                        ], 200);
    }

    /**
     * Response with Access Token
     *
     * @param $accessToken
     * @return \Illuminate\Http\JsonResponse
     */
    public function respondWithAccessToken($accessToken) {
        return response()->json([
                    'code' => 200,
                    'message' => [],
                    'data' => $accessToken
                        ], 200);
    }

    public function unauthorizedResponse($messages) {
        return response()->json([
                    'code' => 401,
                    'message' => $messages,
                    'data' => ""
                        ], 200);
    }

    public function _encrypt_string($data = "") {
        $iv = str_random(16);
        $encrypted = openssl_encrypt($data, "aes-256-cbc", 'G7RAi4BTpa32H1ykg56LkrjqTBoEYqCc', 0, $iv);

        return base64_encode($iv . '||' . $encrypted);
    }

    /**
     * Invalid Request Response / Custom Validation Response
     *
     * @param array $messages
     * @param string $middleware
     * @return \Illuminate\Http\JsonResponse
     */
    public function middlewareResponse(array $messages, $middleware) {
        return response()->json([
                    'code' => 900,
                    'message' => $messages,
                    'middleware' => $middleware
                        ], 200);
    }

    public function response($messages, $code, $data = []) {
        return response()->json([
                    'code' => $code,
                    'message' => $messages,
                    'data' => $data
                        ], 200);
    }

}

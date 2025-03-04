<?php

function apiSuccess(
    $data = [],
    $message,
    $code
) {
    $response = [
        'success' => true,
        'message' => $message,
        'data'    => $data,
    ];
    return response()->json($response, $code);
}

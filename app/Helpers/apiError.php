<?php

function apiError(
    $error,
    $code,
) {
    $response = [
        'success' => false,
        'error' => $error,
    ];
    return response()->json($response, $code);
}

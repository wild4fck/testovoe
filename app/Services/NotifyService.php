<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;

/**
 * Class NotifyService
 * @package App\Http\Controllers
 */
class NotifyService {
    /**
     * @param string $title
     * @param string $body
     * @param array $custom
     * @return JsonResponse
     */
    public static function notify(string $title, string $body, array $custom = []) {
        $notifyArray = array_merge([
            'title' => $title,
            'text' => $body,
        ], $custom);

        return response()->json($notifyArray);
    }
}

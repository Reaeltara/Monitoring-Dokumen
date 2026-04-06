<?php

namespace App\Http\Controllers;

use App\Services\WablasService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class WablasController extends Controller
{
    public function test(Request $request, WablasService $wablas): JsonResponse
    {
        $payload = $request->validate([
            'phone' => ['required', 'string'],
            'message' => ['required', 'string', 'max:1024'],
        ]);

        $result = $wablas->sendText($payload['phone'], $payload['message'], [
            'flag' => 'instant',
        ]);

        return response()->json($result);
    }
}

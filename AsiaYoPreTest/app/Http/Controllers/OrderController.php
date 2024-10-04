<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreOrderRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class OrderController extends Controller
{

    public function store(StoreOrderRequest $request): JsonResponse
    {
        $validated = $request->validated();

        return response()->json([
            'id' => $validated['id'],
            'name' => $validated['name'],
            'address' => $validated['address'],
            'price' => $validated['price'],
            'currency' => $validated['currency'],
        ], 201);
    }
}

<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Client;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ClientController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $clients = Client::query()
            ->when($request->filled('q'), function ($query) use ($request) {
                $term = '%'.$request->string('q')->trim().'%';
                $query->where(function ($nested) use ($term) {
                    $nested->where('name', 'like', $term)
                        ->orWhere('company', 'like', $term)
                        ->orWhere('email', 'like', $term);
                });
            })
            ->orderBy('name')
            ->paginate(20)
            ->withQueryString();

        return response()->json($clients);
    }
}

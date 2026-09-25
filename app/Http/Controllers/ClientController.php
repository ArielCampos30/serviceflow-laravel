<?php

namespace App\Http\Controllers;

use App\Models\Client;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ClientController extends Controller
{
    public function index(Request $request): View
    {
        $clients = Client::query()
            ->when($request->filled('q'), fn ($q) => $q->where(function ($query) use ($request) {
                $term = '%'.$request->string('q')->trim().'%';
                $query->where('name', 'like', $term)->orWhere('company', 'like', $term)->orWhere('email', 'like', $term);
            }))
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('clients.index', compact('clients'));
    }

    public function create(): View
    {
        return view('clients.form', ['client' => new Client]);
    }

    public function store(Request $request): RedirectResponse
    {
        Client::create($this->validated($request));

        return redirect()->route('clients.index')->with('success', 'Cliente creado correctamente.');
    }

    public function edit(Client $client): View
    {
        return view('clients.form', compact('client'));
    }

    public function update(Request $request, Client $client): RedirectResponse
    {
        $client->update($this->validated($request));

        return redirect()->route('clients.index')->with('success', 'Cliente actualizado.');
    }

    public function destroy(Client $client): RedirectResponse
    {
        abort_if($client->workOrders()->exists(), 422, 'No se puede eliminar un cliente con órdenes asociadas.');
        $client->delete();

        return redirect()->route('clients.index')->with('success', 'Cliente eliminado.');
    }

    private function validated(Request $request): array
    {
        return $request->validate([
            'name' => ['required', 'string', 'max:120'],
            'company' => ['nullable', 'string', 'max:120'],
            'email' => ['nullable', 'email', 'max:160'],
            'phone' => ['nullable', 'string', 'max:40'],
            'status' => ['required', 'in:active,inactive,lead'],
            'notes' => ['nullable', 'string', 'max:2000'],
        ]);
    }
}

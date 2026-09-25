<?php

namespace Database\Seeders;

use App\Models\Client;
use App\Models\Service;
use App\Models\User;
use App\Models\WorkOrder;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use RuntimeException;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $demoPassword = env('DEMO_ADMIN_PASSWORD');

        if (! is_string($demoPassword) || trim($demoPassword) === '') {
            throw new RuntimeException('Definí DEMO_ADMIN_PASSWORD antes de ejecutar los seeders.');
        }

        $admin = User::updateOrCreate(
            ['email' => 'admin@serviceflow.test'],
            ['name' => 'Ariel Admin', 'role' => 'admin', 'password' => Hash::make($demoPassword)]
        );

        $operator = User::updateOrCreate(
            ['email' => 'operador@serviceflow.test'],
            ['name' => 'Operador Demo', 'role' => 'operator', 'password' => Hash::make($demoPassword)]
        );

        $services = collect([
            ['name' => 'Mantenimiento preventivo', 'description' => 'Visita técnica programada y checklist general.', 'base_price' => 85000],
            ['name' => 'Instalación', 'description' => 'Instalación y puesta en marcha de equipamiento.', 'base_price' => 145000],
            ['name' => 'Reparación urgente', 'description' => 'Diagnóstico y reparación prioritaria.', 'base_price' => 120000],
            ['name' => 'Asesoría técnica', 'description' => 'Relevamiento y recomendaciones para el cliente.', 'base_price' => 65000],
        ])->map(fn ($data) => Service::updateOrCreate(['name' => $data['name']], $data));

        $clients = collect([
            ['name' => 'Mariana López', 'company' => 'Estudio Norte', 'email' => 'mariana@example.com', 'phone' => '+54 351 555 0101', 'status' => 'active'],
            ['name' => 'Carlos Méndez', 'company' => 'Méndez Retail', 'email' => 'carlos@example.com', 'phone' => '+54 3548 555 0110', 'status' => 'active'],
            ['name' => 'Lucía Pereyra', 'company' => 'Pereyra Arquitectura', 'email' => 'lucia@example.com', 'phone' => '+54 351 555 0122', 'status' => 'active'],
            ['name' => 'Santiago Ruiz', 'company' => 'Ruiz Servicios', 'email' => 'santiago@example.com', 'phone' => '+54 3548 555 0130', 'status' => 'lead'],
            ['name' => 'Florencia Vega', 'company' => 'FV Espacios', 'email' => 'florencia@example.com', 'phone' => '+54 351 555 0144', 'status' => 'active'],
        ])->map(fn ($data) => Client::updateOrCreate(['email' => $data['email']], $data));

        $orders = [
            [0,0,'Chequeo trimestral sede central','scheduled','medium',2,95000,$operator->id],
            [1,2,'Reparación equipo depósito','in_progress','high',0,135000,$operator->id],
            [2,1,'Instalación nueva oficina','new','medium',5,180000,$admin->id],
            [3,3,'Relevamiento técnico inicial','new','low',7,65000,$operator->id],
            [4,0,'Mantenimiento preventivo anual','completed','medium',-8,90000,$operator->id],
            [0,3,'Asesoría para ampliación','completed','low',-15,70000,$admin->id],
            [2,2,'Corrección urgente en instalación','scheduled','high',1,125000,$operator->id],
            [4,1,'Instalación equipamiento adicional','in_progress','medium',3,160000,$admin->id],
        ];

        foreach ($orders as $i => [$client, $service, $title, $status, $priority, $days, $total, $assigned]) {
            WorkOrder::updateOrCreate(
                ['title' => $title],
                [
                    'client_id' => $clients[$client]->id,
                    'service_id' => $services[$service]->id,
                    'assigned_to' => $assigned,
                    'description' => 'Orden de demostración creada para mostrar el flujo de trabajo de ServiceFlow.',
                    'status' => $status,
                    'priority' => $priority,
                    'scheduled_for' => now()->addDays($days)->setTime(10, 0),
                    'total' => $total,
                ]
            );
        }
    }
}

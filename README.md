# ServiceFlow — Laravel 13

ServiceFlow es un **proyecto demostrativo de portfolio** para empresas de servicios. Simula un sistema interno donde un equipo puede administrar clientes, servicios y órdenes de trabajo desde un panel responsive.

> No fue desarrollado para un cliente. Se creó como demostración técnica para portfolio freelance.

## Demo pública

- URL: https://serviceflow-laravel-demo.onrender.com
- Usuario: `admin@serviceflow.test`
- Contraseña: `ServiceFlowDemo!26`

La demo usa datos ficticios y puede reiniciarse cuando el servicio vuelve a desplegarse.

## Funcionalidades

- Autenticación con sesión.
- Roles `Administrador` y `Operador`.
- Dashboard con métricas operativas.
- Gestión de clientes con búsqueda y estados.
- Catálogo de servicios.
- Órdenes de trabajo con prioridad, estado, responsable, fecha y total.
- Filtros por estado, prioridad y texto.
- Permisos: sólo administradores gestionan clientes y servicios; ambos roles gestionan órdenes.
- Validaciones del lado servidor y protección CSRF de Laravel.
- Seeders con datos demostrativos.
- Diseño responsive sin depender de un framework CSS externo.
- Tests de autenticación, permisos y creación de órdenes.

## Stack

- PHP 8.3+
- Laravel 13
- Eloquent ORM
- Blade
- SQLite para demo / compatible con MySQL y PostgreSQL
- HTML + CSS + JavaScript
- PHPUnit

## Instalación local

```bash
composer install
cp .env.example .env
php artisan key:generate
touch database/database.sqlite
# Definí DEMO_ADMIN_PASSWORD en .env antes del seed
php artisan migrate --seed
php artisan serve
```

Abrir `http://127.0.0.1:8000`.

### Usuarios demo

Los seeders crean los usuarios `admin@serviceflow.test` y `operador@serviceflow.test`. En la demo pública se usa la contraseña `ServiceFlowDemo!26`; en otros entornos puede reemplazarse mediante `DEMO_ADMIN_PASSWORD`.

## Alcance de portfolio

Este proyecto busca demostrar competencias aplicables a trabajos freelance de:

- PHP / Laravel
- CRUD y paneles administrativos
- MySQL / PostgreSQL
- autenticación y roles
- sistemas internos para empresas
- formularios y validaciones
- gestión de clientes y órdenes
- arquitectura MVC

## API REST demostrativa

La API utiliza un token Bearer configurado por entorno mediante `SERVICEFLOW_API_TOKEN`.

Endpoints principales:

- `GET /api/v1/clients`
- `GET /api/v1/services`
- `GET /api/v1/orders`
- `GET /api/v1/orders/{id}`
- `POST /api/v1/orders`
- `PUT /api/v1/orders/{id}`

Ejemplo de cabecera:

```http
Authorization: Bearer <SERVICEFLOW_API_TOKEN>
```

## Próximos bloques previstos

- Historial de cambios de órdenes.
- Exportación CSV.
- Demo pública desplegada mediante Docker/Render.

## Licencia

MIT.

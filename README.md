# ServiceFlow — Laravel 13

ServiceFlow es un **proyecto demostrativo de portfolio** para empresas de servicios. Simula un sistema interno donde un equipo puede administrar clientes, servicios y órdenes de trabajo desde un panel responsive.

> No fue desarrollado para un cliente. Se creó como demostración técnica para portfolio freelance.

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

Los seeders crean los usuarios `admin@serviceflow.test` y `operador@serviceflow.test`. La contraseña se toma de `DEMO_ADMIN_PASSWORD` y no se guarda en el repositorio.

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

## Próximos bloques previstos

- API REST con autenticación (siguiente bloque).
- Historial de cambios de órdenes.
- Exportación CSV.
- Deploy público de demostración.

## Licencia

MIT.

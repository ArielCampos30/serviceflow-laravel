<?php

use Illuminate\Support\Facades\Artisan;

Artisan::command('serviceflow:about', function () {
    $this->info('ServiceFlow Laravel portfolio demo');
})->purpose('Show ServiceFlow project information');

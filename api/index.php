<?php

require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';

/*
|--------------------------------------------------------------------------
| Vercel Serverless Fix
|--------------------------------------------------------------------------
| Vercel hanya mengizinkan penulisan file di folder /tmp. 
| Kita arahkan storage Laravel ke sana agar tidak error saat compile view.
*/
$storagePath = '/tmp/storage/framework/views';
if (!is_dir($storagePath)) {
    mkdir($storagePath, 0755, true);
}

// Set path storage ke /tmp
$app->useStoragePath('/tmp/storage');

// Penting: Beritahu Laravel di mana letak folder view yang baru dicompile
config(['view.compiled' => $storagePath]);
// ------------------------------------------------------------------------

$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);

$response = $kernel->handle(
    $request = Illuminate\Http\Request::capture()
);

$response->send();

$kernel->terminate($request, $response);
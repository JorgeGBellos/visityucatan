<?php

use Illuminate\Foundation\Application;
use Illuminate\Http\Request;

define('LARAVEL_START', microtime(true));

/*
|--------------------------------------------------------------------------
| Hostinger shared-hosting front controller
|--------------------------------------------------------------------------
|
| Document root stays at public_html/. Laravel lives in public_html/visityucatan/
| (Git auto-deploy target). Public assets (images, videos, build) stay at
| public_html/ so heavy media is not redeployed with every push.
|
*/

$laravelRoot = __DIR__.'/visityucatan';

if (file_exists($maintenance = $laravelRoot.'/storage/framework/maintenance.php')) {
    require $maintenance;
}

require $laravelRoot.'/vendor/autoload.php';

/** @var Application $app */
$app = require_once $laravelRoot.'/bootstrap/app.php';

$app->usePublicPath(__DIR__);

$app->handleRequest(Request::capture());

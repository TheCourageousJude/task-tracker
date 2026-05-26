<?php

/**
 * public/index.php — Front Controller (Router)
 *
 * This is the ONLY file exposed to the web.
 * Every URL request comes here first.
 * We parse the URL, match a route, and call the right controller method.
 */

session_start();

// Load environment variables and database connection
require_once __DIR__ . '/../config/database.php';
loadEnv(__DIR__ . '/../.env');

// Load controllers
require_once __DIR__ . '/../controllers/AuthController.php';
require_once __DIR__ . '/../controllers/TaskController.php';

// Parse the current URL path and HTTP method
$uri    = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$method = $_SERVER['REQUEST_METHOD'];

// ── ROUTE TABLE ──────────────────────────────────────────────────────────────
// Order matters: specific routes must come before pattern-matched routes

if ($uri === '/' && $method === 'GET') {
    (new TaskController)->index();

} elseif ($uri === '/login') {
    (new AuthController)->login();

} elseif ($uri === '/register') {
    (new AuthController)->register();

} elseif ($uri === '/logout' && $method === 'POST') {
    (new AuthController)->logout();

} elseif ($uri === '/tasks/create' && $method === 'GET') {
    (new TaskController)->create();

} elseif ($uri === '/tasks/store' && $method === 'POST') {
    (new TaskController)->store();

} elseif (preg_match('#^/tasks/(\d+)/edit$#', $uri, $m) && $method === 'GET') {
    (new TaskController)->edit((int) $m[1]);

} elseif (preg_match('#^/tasks/(\d+)/update$#', $uri, $m) && $method === 'POST') {
    (new TaskController)->update((int) $m[1]);

} elseif (preg_match('#^/tasks/(\d+)/delete$#', $uri, $m) && $method === 'POST') {
    (new TaskController)->delete((int) $m[1]);

} elseif (preg_match('#^/tasks/(\d+)/complete$#', $uri, $m) && $method === 'POST') {
    (new TaskController)->complete((int) $m[1]);

} else {
    http_response_code(404);
    echo '<!DOCTYPE html><html><body style="font-family:sans-serif;text-align:center;padding:4rem">
          <h1>404 — Page Not Found</h1><a href="/">Go back to dashboard</a></body></html>';
}

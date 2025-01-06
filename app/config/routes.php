<?php
// routes.php
use app\controllers\RoutesController;
use flight\Engine;
use flight\net\Router;

/**
 * @var Router $router
 * @var Engine $app
 */

// Start the session before handling any routes
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Existing routes
$router->get('/', [RoutesController::class, 'index']);
$router->get("/admin", [RoutesController::class, 'admin']);
$router->get("/depot", [RoutesController::class, 'depot']);
$router->post("/submit-depot", [RoutesController::class, 'submitDepot']);
$router->get("/form", [RoutesController::class, 'form']);
$router->post("/submit-form", [RoutesController::class, 'submitForm']);
$router->get("/login", [RoutesController::class, 'login']);
$router->post("/submit-login", [RoutesController::class, 'submitLogin']);
$router->get("/logOut", [RoutesController::class, 'logOut']);
$router->get("/signIn", [RoutesController::class, 'signIn']);
$router->post("/submit-signIn", [RoutesController::class, 'submitSignIn']);
$router->post("/result", [RoutesController::class, 'result']);
$router->get("/insert/depot/@index", [RoutesController::class, 'insertDepot']);

// New API routes
$router->get("/api/random-gift/@category", [RoutesController::class, 'getRandomGiftByCategory']);
$router->post("/api/validate-gifts", [RoutesController::class, 'validateGiftsApi']);
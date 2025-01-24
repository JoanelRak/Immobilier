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

$router->get('/home',  [RoutesController::class, 'index'] );
$router->get("/login", [RoutesController::class, 'login']);
$router->post("/submit-login", [RoutesController::class, 'submitLogin']);
$router->get("/logOut", [RoutesController::class, 'logOut']);
$router->get("/signIn", [RoutesController::class, 'signIn']);
$router->post("/submit-signIn", [RoutesController::class, 'submitSignIn']);


$router->get("/property/@idProperty", [RoutesController::class, 'property']);
$router->post("/book-property/@idProperty", [RoutesController::class, 'bookProperty']);


$router->get("/reservations", [RoutesController::class, "reservations"]);
$router->get("/profile", [RoutesController::class, "profile"]);

$router->get("/admin", [RoutesController::class, 'adminHabitations']);
$router->post("/admin/habitations/add", [RoutesController::class, 'addHabitation']);
$router->get("/upload-images", [RoutesController::class, 'upload']);
$router->post("/admin/habitations/update", [RoutesController::class, 'updateHabitation']);
$router->post("/admin/habitations/delete", [RoutesController::class, 'deleteHabitation']);
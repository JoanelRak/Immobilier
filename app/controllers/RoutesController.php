<?php

namespace app\controllers;

use app\models\admin\AdminGet;
use app\models\admin\AdminInsert;
use app\models\admin\SpecificQuery;
use app\models\Connection;
use app\components\ErrorHandler;
use Flight;
use flight\Engine;

class RoutesController
{
    private AdminInsert $adminInsert;
    private AdminGet $adminGet;
    private SpecificQuery $specificQuery;
    private Connection $connection;
    private string $BASE_URL;

    public function __construct(Engine $engine)
    {
        $this->BASE_URL = Flight::has("flight.base_url") ? Flight::get("flight.base_url") : '/';

        try {
            $this->connection = Flight::connection();
            $this->adminInsert = new AdminInsert($this->connection);
            $this->adminGet = new AdminGet($this->connection);
            $this->specificQuery = new SpecificQuery($this->connection);
        } catch (\Exception $e) {
            ErrorHandler::setError("Connection error: " . $e->getMessage());
            $this->redirectTo('/error');
        }
    }

    private function redirectTo($path)
    {
        // Normalize path by removing leading and trailing slashes
        $path = trim($path, '/');

        // Redirect using Flight's method
        Flight::redirect($path);
    }


    private function handleErrorAndRedirect($errorMessage, $redirectPath)
    {
        ErrorHandler::setError($errorMessage);
        $this->redirectTo($redirectPath);
    }

    private function renderView($main, $additionalData = [])
    {
        $defaultData = [
            'header' => 'header',
            'footer' => 'footer',
            'message' => ErrorHandler::getError()
        ];
        $data = array_merge($defaultData, $additionalData);
        $data['main'] = $main;

        Flight::render("index", $data);
    }

    private function checkIfLoggedIn()
    {
        if (!isset($_SESSION["user"])) {
            $this->handleErrorAndRedirect("You need to log in to access this page", '/login');
        }
    }

    public function error()
    {
        $this->renderView('error');
    }

    public function admin()
    {
        $data = [
            'currentPage' => 'admin',
            'all_depots' => $_SESSION['depots'] ?? [],
            'commission' => $_SESSION['commission'] ?? 0
        ];
        $this->renderView('admin', $data);
    }

    public function index()
    {
        $habitations = isset($_GET["search"])
            ? $this->adminGet->getAllHabitations($_GET["search"])
            : $this->adminGet->getAllHabitations();

        $this->renderView('home_main', [
            'currentPage' => 'home',
            'habitations' => $habitations
        ]);
    }

    public function login()
    {
        $this->renderView('login', ['currentPage' => 'login']);
    }

    public function submitLogin()
    {
        try {
            $name = trim($_POST["name"] ?? '');
            $password = trim($_POST["password"] ?? '');

            if (empty($name) || empty($password)) {
                $this->handleErrorAndRedirect("Please enter both username and password", 'login');
                return;
            }

            $userGet = $this->adminGet->getUser($name, $password);
            if (!is_array($userGet)) {
                $this->handleErrorAndRedirect("Invalid username or password", 'login');
                return;
            }

            $_SESSION['user'] = [
                'id_user' => $userGet[0]["id"],
                'name' => $userGet[0]["nom"],
                'password' => $userGet[0]["mdp"],
                'age' => $userGet[0]["age"],
            ];

            $this->redirectTo('');
        } catch (\Exception $e) {
            $this->handleErrorAndRedirect("Login error: " . $e->getMessage(), 'login');
        }
    }

    public function signIn()
    {
        $this->renderView('signIn', ['currentPage' => 'register']);
    }

    public function submitSignIn()
    {
        try {
            $name = trim($_POST['name'] ?? '');
            $password = trim($_POST['password'] ?? '');
            $age = filter_input(INPUT_POST, 'age', FILTER_VALIDATE_INT);

            if (empty($name) || empty($password) || !$age) {
                $this->handleErrorAndRedirect("All fields are required", 'signIn');
                return;
            }

            $user = [
                ':nom' => $name,
                ':mdp' => $password,
                ':age' => $age
            ];

            $result = $this->adminInsert->insertUser($user);
            if ($result === -1) {
                $this->handleErrorAndRedirect("Failed to create account", 'signIn');
                return;
            }

            $userGet = $this->adminGet->getUser($user[":nom"], $user[":mdp"]);
            if (!is_array($userGet)) {
                $this->handleErrorAndRedirect("Error accessing new account", 'signIn');
                return;
            }

            $_SESSION['user'] = [
                'id_user' => $userGet[0]["id"],
                'name' => $userGet[0]["nom"],
                'password' => $userGet[0]["mdp"],
                'age' => $userGet[0]["age"],
            ];

            $this->redirectTo('');
        } catch (\Exception $e) {
            $this->handleErrorAndRedirect("Registration error: " . $e->getMessage(), 'signIn');
        }
    }

    public function logOut()
    {
        try {
            if (session_status() === PHP_SESSION_ACTIVE) {
                session_unset();
            }
            $this->redirectTo('/');
        } catch (\Exception $e) {
            $this->handleErrorAndRedirect("Logout error: " . $e->getMessage(), '/');
        }
    }

    public function property($idProperty)
    {
        $property = $this->adminGet->getHabitationById($idProperty);
        $this->renderView('propriete', [
            'habitation' => $property
        ]);
    }

    public function reservations()
    {
        $this->checkIfLoggedIn();
        $reservations = $this->adminGet->getAllReservations();
        $this->renderView('reservations', [
            'currentPage' => 'reservations',
            'reservations' => $reservations
        ]);
    }
}

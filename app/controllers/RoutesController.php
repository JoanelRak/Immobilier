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

    public function __construct(Engine $engine)
    {
        try {
            $this->connection = Flight::connection();
            $this->adminInsert = new AdminInsert($this->connection);
            $this->adminGet = new AdminGet($this->connection);
            $this->specificQuery = new SpecificQuery($this->connection);
        } catch (\Exception $e) {
            ErrorHandler::setError("Connection error: " . $e->getMessage());
            Flight::redirect('/error');
        }
    }

    public function error()
    {
        $data = [
            'header' => 'header',
            'main' => 'error',
            'footer' => 'footer',
            'message' => ErrorHandler::getError()
        ];
        Flight::render("index", $data);
    }

    public function admin()
    {
        if (!isset($_SESSION['depots'])) {
            ErrorHandler::setError("No deposits available");
            Flight::redirect('/');
            return;
        }

        $data = [
            'header' => 'header',
            'main' => 'admin',
            'footer' => 'footer',
            'all_depots' => $_SESSION['depots'],
            'message' => ErrorHandler::getError()
        ];
        Flight::render("index", $data);
    }

    public function index()
    {
        $data = [
            'header' => 'header',
            'main' => 'home_main',
            'footer' => 'footer',
            'message' => ErrorHandler::getError()
        ];
        Flight::render("index", $data);
    }

    public function depot()
    {
        $data = [
            'header' => 'header',
            'main' => 'depot',
            'footer' => 'footer',
            'message' => ErrorHandler::getError()
        ];
        Flight::render("index", $data);
    }

    public function submitDepot()
    {
        if (!isset($_SESSION['user'])) {
            ErrorHandler::setError("Please login first");
            Flight::redirect('/login');
            return;
        }

        $montantDepot = filter_input(INPUT_POST, 'montant', FILTER_VALIDATE_FLOAT);
        if ($montantDepot === false || $montantDepot === null) {
            ErrorHandler::setError("Invalid deposit amount");
            Flight::redirect('/depot');
            return;
        }

        $user = $_SESSION['user'];
        $_SESSION['depots'][] = [
            'id_user' => $user['id_user'],
            'montant' => $montantDepot
        ];
        Flight::redirect('/');
    }

    public function insertDepot($index)
    {
        try {
            if (!isset($_SESSION['depots'][$index])) {
                ErrorHandler::setError("Deposit not found");
                Flight::redirect('/');
                return;
            }

            $depot = $_SESSION['depots'][$index];
            $result = $this->adminInsert->insertDepot($depot);

            if ($result === null) {
                ErrorHandler::setError("Failed to save deposit");
                Flight::redirect('/');
                return;
            }

            unset($_SESSION['depots'][$index]);
            Flight::redirect("/");
        } catch (\Exception $e) {
            ErrorHandler::setError("Error processing deposit: " . $e->getMessage());
            Flight::redirect('/');
        }
    }

    public function form()
    {
        $data = [
            'header' => 'header',
            'main' => 'form',
            'footer' => 'footer',
            'message' => ErrorHandler::getError()
        ];
        Flight::render("index", $data);
    }

    public function submitForm() {
        try {
            $number_men = filter_input(INPUT_POST, 'men', FILTER_VALIDATE_INT);
            $number_women = filter_input(INPUT_POST, 'women', FILTER_VALIDATE_INT);

            if ($number_men === false || $number_women === false) {
                ErrorHandler::setError("Please enter valid numbers");
                Flight::redirect('/form');
                return;
            }

            // Store in session
            $_SESSION['cadeaux'] = $this->specificQuery->getRandomCadeaux($number_men, $number_women);

            // Pass session data to view
            $data = [
                'header' => 'header',
                'main' => 'cadeau',
                'footer' => 'footer',
                'message' => ErrorHandler::getError(),
                'cadeaux' => $_SESSION['cadeaux'] // Add this line to pass the data
            ];
            Flight::render("index", $data);
        } catch (\Exception $e) {
            ErrorHandler::setError("Error getting gifts: " . $e->getMessage());
            Flight::redirect('/form');
        }
    }
    public function getRandomGiftByCategory($category) {
        try {
            $gift = $this->specificQuery->getRandomCadeauxByCategorie($category);
            Flight::json([
                'success' => true,
                'gift' => $gift
            ]);
        } catch (\Exception $e) {
            Flight::json([
                'success' => false,
                'error' => $e->getMessage()
            ], 500);
        }
    }
    public function validateGiftsApi() {
        $data = json_decode(Flight::request()->getBody(), true);
        $userId = $_SESSION['user_id'] ?? null;
        $selectedGifts = $data['gifts'] ?? [];

        if (!$userId || empty($selectedGifts)) {
            Flight::json([
                'success' => false,
                'error' => 'Invalid request data'
            ], 400);
            return;
        }

        $isValid = $this->specificQuery->validateGifts($userId, $selectedGifts);

        Flight::json([
            'success' => true,
            'isValid' => $isValid
        ]);
    }

    public function login()
    {
        $data = [
            'header' => 'header',
            'main' => 'login',
            'footer' => 'footer',
            'message' => ErrorHandler::getError()
        ];
        Flight::render("index", $data);
    }

    public function submitLogin()
    {
        try {
            $name = trim($_POST["name"] ?? '');
            $password = trim($_POST["password"] ?? '');

            if (empty($name) || empty($password)) {
                ErrorHandler::setError("Please enter both username and password");
                Flight::redirect('/login');
                return;
            }

            $userGet = $this->adminGet->getUser($name, $password);
            if (!is_array($userGet)) {
                ErrorHandler::setError("Invalid username or password");
                Flight::redirect('/login');
                return;
            }

            $_SESSION['user'] = [
                'id_user' => $userGet[0]["id"],
                'name' => $userGet[0]["nom"],
                'password' => $userGet[0]["mdp"],
                'age' => $userGet[0]["age"],
            ];

            Flight::redirect("/");
        } catch (\Exception $e) {
            ErrorHandler::setError("Login error: " . $e->getMessage());
            Flight::redirect('/login');
        }
    }

    public function signIn()
    {
        $data = [
            'header' => 'header',
            'main' => 'signIn',
            'footer' => 'footer',
            'message' => ErrorHandler::getError()
        ];
        Flight::render("index", $data);
    }

    public function submitSignIn()
    {
        try {
            $name = trim($_POST['name'] ?? '');
            $password = trim($_POST['password'] ?? '');
            $age = filter_input(INPUT_POST, 'age', FILTER_VALIDATE_INT);

            if (empty($name) || empty($password) || !$age) {
                ErrorHandler::setError("All fields are required");
                Flight::redirect('/signIn');
                return;
            }

            $user = [
                ':nom' => $name,
                ':mdp' => $password,
                ':age' => $age
            ];

            $result = $this->adminInsert->insertUser($user);
            if ($result === -1) {
                ErrorHandler::setError("Failed to create account");
                Flight::redirect('/signIn');
                return;
            }

            $userGet = $this->adminGet->getUser($user[":nom"], $user[":mdp"]);
            if (!is_array($userGet)) {
                ErrorHandler::setError("Error accessing new account");
                Flight::redirect('/signIn');
                return;
            }

            $_SESSION['user'] = [
                'id_user' => $userGet[0]["id"],
                'name' => $userGet[0]["nom"],
                'password' => $userGet[0]["mdp"],
                'age' => $userGet[0]["age"],
            ];

            Flight::redirect("/");
        } catch (\Exception $e) {
            ErrorHandler::setError("Registration error: " . $e->getMessage());
            Flight::redirect('/signIn');
        }
    }

    public function logOut()
    {
        try {
            if (session_status() === PHP_SESSION_ACTIVE) {
                session_unset();
            }
            Flight::redirect("/");
        } catch (\Exception $e) {
            ErrorHandler::setError("Logout error: " . $e->getMessage());
            Flight::redirect('/');
        }
    }
}
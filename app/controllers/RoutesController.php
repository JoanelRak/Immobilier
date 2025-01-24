<?php

namespace app\controllers;

use app\models\admin\AdminGet;
use app\models\admin\AdminInsert;
use app\models\admin\SpecificQuery;
use app\models\Connection;
use app\components\ErrorHandler;
use DateTime;
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
            $name = trim($_POST["nom"] ?? '');
            $password = trim($_POST["mdp"] ?? '');

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
                'email' => $userGet[0]["email"],
                'numTel' => $userGet[0]["numTel"],
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
            $name = trim($_POST['nom'] ?? '');
            $email = trim($_POST['email'] ?? '');
            $password = trim($_POST['mdp'] ?? '');
            $numTel = $_POST['numTel'] ?? '';

            if (empty($name) || empty($password) || empty($email) || empty($numTel)) {
                $this->handleErrorAndRedirect("All fields are required", 'signIn');
                return;
            }

            $user = [
                ':nom' => $name,
                ':mdp' => $password,
                ':email' => $email,
                ':numTel' => $numTel
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
                'email' => $userGet[0]["email"],
                'numTel' => $userGet[0]["numTel"],
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
        $property["img_url"] = $this->adminGet->getAllImgOfHabitation($idProperty);
        $this->renderView('propriete', [
            'habitation' => $property,
            "currentPage" => ""
        ]);
    }

    public function reservations()
    {
        $this->checkIfLoggedIn();
        $idUser = $_SESSION["user"]["id_user"];
        $reservations = $this->adminGet->getAllReservations($idUser);
        $this->renderView('reservations', [
            'currentPage' => 'reservations',
            'reservations' => $reservations
        ]);
    }

    public function bookProperty($idProperty) {
        try {
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {

                $dateArrivee = $_POST['date_arrivee'];
                $dateDepart = $_POST['date_depart'];
                $idClient = $_SESSION['user']['id_user'];
                $idHabitation = $idProperty;

                if (empty($dateArrivee) || empty($dateDepart)) {
                    $this->handleErrorAndRedirect("Les dates d'arrivée et de départ sont requises.", "property/$idProperty");
                    return;
                }

                $dateArriveeObj = DateTime::createFromFormat('Y-m-d\TH:i', $dateArrivee);
                $dateDepartObj = DateTime::createFromFormat('Y-m-d\TH:i', $dateDepart);

                if (!$dateArriveeObj || !$dateDepartObj) {
                    $this->handleErrorAndRedirect("Format de date invalide.", "property/$idProperty");
                    return;
                }

                if ($dateArriveeObj >= $dateDepartObj) {
                    $this->handleErrorAndRedirect("La date d'arrivée doit être antérieure à la date de départ.", "property/$idProperty");
                    return;
                }

                $params = [
                ':id_client' => $idClient,
                ':id_habitation' => $idHabitation,
                ':date_arrivee' => $dateArrivee,
                ':date_depart' => $dateDepart
                ];

                $result = $this->adminInsert->insertReservation($params);
                if ($result === -1) {
                    $this->handleErrorAndRedirect("Failed to book", "property/$idProperty");
                    return;
                }

                $property = $this->adminGet->getHabitationById($idProperty);
                $property["img_url"] = $this->adminGet->getAllImgOfHabitation($idProperty);
                $this->renderView('propriete', [
                    'habitation' => $property,
                    "currentPage" => "",
                    "success" => "Propriete a ete reserve"
                ]);
            } else {
                $this->handleErrorAndRedirect("Méthode non autorisée.", "property/$idProperty");
                return;
            }
        } catch (\Exception $e) {
            $this->handleErrorAndRedirect("Failed to book: " . $e->getMessage(), "property/$idProperty");
        }
    }

    public function profile() {
        $this->checkIfLoggedIn();
        $this->renderView('profile', [
            'currentPage' => 'profile'
        ]);
    }
    public function adminHabitations()
    {
        $types = $this->specificQuery->getAllTypes();
        $habitations = $this->adminGet->getAllHabitations();

        $editing = false;
        if (isset($_GET['edit'])) {
            $editing = $this->adminGet->getHabitationById((int)$_GET['edit']);
        }

        $this->renderView('admin', [
            'currentPage' => 'admin',
            'types' => $types, // Add a default empty array
            'habitations' => $habitations,
            'editing' => $editing // This is already set to false if not found
        ]);
    }

    public function addHabitation()
    {

        try {
            $params = [
                ':id_type' => $_POST['id_type'],
                ':nombre_chambre' => $_POST['nombre_chambre'],
                ':loyer' => $_POST['loyer'],
                ':quartier' => $_POST['quartier'],
                ':designation' => $_POST['designation']
            ];

            $result = $this->adminInsert->insertHabitation($params);

            if ($result === -1) {
                $this->handleErrorAndRedirect("Failed to add habitation", '/admin/habitations');
                return;
            }

            $this->redirectTo('/admin');
        } catch (\Exception $e) {
            $this->handleErrorAndRedirect("Error adding habitation: " . $e->getMessage(), '/admin/habitations');
        }
    }

    public function updateHabitation()
    {

        try {
            $params = [
                ':id' => $_POST['id'],
                ':id_type' => $_POST['id_type'],
                ':nombre_chambre' => $_POST['nombre_chambre'],
                ':loyer' => $_POST['loyer'],
                ':quartier' => $_POST['quartier'],
                ':designation' => $_POST['designation']
            ];

            $result = $this->adminInsert->updateHabitation($params);

            if ($result === -1) {
                $this->handleErrorAndRedirect("Failed to update habitation", '/admin/habitations');
                return;
            }

            $this->redirectTo('/admin');
        } catch (\Exception $e) {
            $this->handleErrorAndRedirect("Error updating habitation: " . $e->getMessage(), '/admin/habitations');
        }
    }

    public function deleteHabitation()
    {

        try {
            $params = [
                ':id' => $_POST['id']
            ];

            $result = $this->adminInsert->deleteHabitation($params);

            if ($result === -1) {
                $this->handleErrorAndRedirect("Failed to delete habitation", '/admin/habitations');
                return;
            }

            $this->redirectTo('/admin');
        } catch (\Exception $e) {
            $this->handleErrorAndRedirect("Error deleting habitation: " . $e->getMessage(), '/admin/habitations');
        }
    }

}

<?php

namespace app\models\admin;

use app\models\Connection;

class AdminGet
{
    private Connection $DBH;

    public function __construct(Connection $DBH)
    {
        $this->DBH = $DBH;
    }

    // Get all users
    public function getAllUsers()
    {
        try {
            return $this->DBH->fetchQuery("SELECT * FROM Immobilier_client");
        } catch (\Exception $e) {
            throw new \RuntimeException("Error fetching all users: " . $e->getMessage());
        }
    }

    // Get a single user by name and password
    public function getUser($nom, $password)
    {
        try {
            $query = "SELECT * FROM Immobilier_client WHERE nom = :nom AND mdp = :mdp";
            $params = [':nom' => $nom, ':mdp' => $password];
            $result = $this->DBH->fetchQueryWithParams($query, $params);
            return $result ?: false;
        } catch (\Exception $e) {
            throw new \RuntimeException("Error fetching user: " . $e->getMessage());
        }
    }

    public function getAllHabitations ( string $search = null) {
        try {
            $query = "SELECT * FROM Immobilier_habitation ";
            $params = [];
            if ($search != null) {
                $query .= " WHERE designation like :search";
                $params [] = [':search' => $search];
            }
            return $this->DBH->fetchQueryWithParams($query, $params) ?: false;
        }catch (\Exception $e) {
            throw new \RuntimeException("Error fetching : " . $e->getMessage(). $query);
        }
    }
    public function getHabitationById (int $id) {
        try {
            $query = "SELECT * FROM Immobilier_habitation WHERE id = :id";
            $params = [':id' => $id];
            return $this->DBH->fetchQueryWithParams($query, $params) ?: false;
        }catch (\Exception $e) {
            throw new \RuntimeException("Error fetching : " . $e->getMessage(). $query);
        }
    }
    public function getAllReservations ($idUser) {
        try {
            $query = "SELECT * FROM Immobilier_reservation WHERE id_client = :id";
            $params = [':id' => $idUser];
            return $this->DBH->fetchQueryWithParams($query, $params) ?: false;
        }catch (\Exception $e) {
            throw new \RuntimeException("Error fetching : " . $e->getMessage(). $query);
        }
    }

}

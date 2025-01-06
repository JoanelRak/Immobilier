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
            return $this->DBH->fetchQuery("SELECT * FROM noel_users");
        } catch (\Exception $e) {
            throw new \RuntimeException("Error fetching all users: " . $e->getMessage());
        }
    }

    // Get a single user by name and password
    public function getUser($nom, $password)
    {
        try {
            $query = "SELECT * FROM noel_users WHERE nom = :nom AND mdp = :mdp";
            $params = [':nom' => $nom, ':mdp' => $password];
            $result = $this->DBH->fetchQueryWithParams($query, $params);
            return $result ?: false;
        } catch (\Exception $e) {
            throw new \RuntimeException("Error fetching user: " . $e->getMessage());
        }
    }

    // Get all depots
    public function getAllDepots()
    {
        try {
            return $this->DBH->fetchQuery("SELECT * FROM noel_depot");
        } catch (\Exception $e) {
            throw new \RuntimeException("Error fetching depots: " . $e->getMessage());
        }
    }

    // Get depots by user ID
    public function getAllDepotsById($id)
    {
        try {
            $query = "SELECT * FROM noel_depot WHERE id_user = :id_user";
            $params = [':id_user' => $id];
            return $this->DBH->fetchQueryWithParams($query, $params);
        } catch (\Exception $e) {
            throw new \RuntimeException("Error fetching depots for user ID $id: " . $e->getMessage());
        }
    }

    // Get all categories
    public function getAllCategories()
    {
        try {
            return $this->DBH->fetchQuery("SELECT * FROM noel_categorie_cadeau");
        } catch (\Exception $e) {
            throw new \RuntimeException("Error fetching categories: " . $e->getMessage());
        }
    }

    // Get all gifts
    public function getAllCadeaux()
    {
        try {
            return $this->DBH->fetchQuery("SELECT * FROM noel_cadeau");
        } catch (\Exception $e) {
            throw new \RuntimeException("Error fetching gifts: " . $e->getMessage());
        }
    }

    // Get gift by ID
    public function getCadeauById($id)
    {
        try {
            $query = "SELECT * FROM noel_cadeau WHERE id = :id";
            $params = [':id' => $id];
            $result = $this->DBH->fetchQueryWithParams($query, $params);
            return $result ?: false;
        } catch (\Exception $e) {
            throw new \RuntimeException("Error fetching gift with ID $id: " . $e->getMessage());
        }
    }

    public function getAllCadeauxByCategorie($categorie)
    {
        return $this->DBH->fetchQuery("SELECT * FROM noel_cadeau WHERE id_categorie = $categorie");
    }

    public function getAllCadeauxByEtoile($etoile)
    {
        return $this->DBH->fetchQuery("SELECT * FROM noel_cadeau WHERE etoile = $etoile");
    }



}

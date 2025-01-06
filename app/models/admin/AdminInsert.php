<?php

namespace app\models\admin;

use app\models\Connection;

class AdminInsert
{
    private Connection $DBH;

    public function __construct(Connection $DBH)
    {
        $this->DBH = $DBH;
    }

    // Insert a new user
    public function insertUser($params)
    {
        try {
            $query = "INSERT INTO noel_users (nom, mdp, age) VALUES (:nom, :mdp, :age)";
            return $this->DBH->updateQueryWithParameters($query, $params);
        } catch (\Exception $e) {
            throw new \RuntimeException("Error inserting user: " . $e->getMessage());
        }
    }

    // Insert a new depot
    public function insertDepot($params)
    {
        try {
            $query = "INSERT INTO noel_depot (id_user, montant) VALUES (:id_user, :montant)";
            return $this->DBH->updateQueryWithParameters($query, $params);
        } catch (\Exception $e) {
            throw new \RuntimeException("Error inserting depot: " . $e->getMessage());
        }
    }

    // Insert a new category
    public function insertCategorieCadeau($params)
    {
        try {
            $query = "INSERT INTO noel_categorie_cadeau (nom) VALUES (:nom)";
            return $this->DBH->updateQueryWithParameters($query, $params);
        } catch (\Exception $e) {
            throw new \RuntimeException("Error inserting category: " . $e->getMessage());
        }
    }

    // Insert a new gift
    public function insertCadeau($params)
    {
        try {
            $query = "
                INSERT INTO noel_cadeau (id_categorie, description_cadeau, prix, image, etoile) 
                VALUES (:id_categorie, :description_cadeau, :prix, :image, :etoile)
            ";
            return $this->DBH->updateQueryWithParameters($query, $params);
        } catch (\Exception $e) {
            throw new \RuntimeException("Error inserting gift: " . $e->getMessage());
        }
    }
}

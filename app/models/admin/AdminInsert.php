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
    public function insertUser($params): int
    {
        try {
            $query = "INSERT INTO Immobilier_client (nom, email, mdp, numTel)
        VALUES (:nom, :email , :mdp, :numTel);
        SELECT LAST_INSERT_ID();";
            return $this->DBH->fetchQueryWithParams($query, $params)[0];
        } catch (\Exception $e) {
            throw new \RuntimeException("Error inserting user: " . $e->getMessage());
        }
    }

    public function insertHabitation($params)
    {
        try {
            $query = "INSERT INTO Immobilier_habitation 
                (id_type, nombre_chambre, loyer, quartier, designation) 
                VALUES 
                (:id_type, :nombre_chambre, :loyer, :quartier, :designation);
        SELECT LAST_INSERT_ID();";
            return $this->DBH->fetchQueryWithParams($query, $params)[0];
        } catch (\Exception $e) {
            throw new \RuntimeException("Error inserting habitation: " . $e->getMessage());
        }
    }

    // Insert a new depot

}

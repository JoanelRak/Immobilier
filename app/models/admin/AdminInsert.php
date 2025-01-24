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
            $query = "INSERT INTO Immobilier_client (nom, email, mdp, numTel)
        VALUES (:nom, :email , :mdp, :numTel);
        SELECT LAST_INSERT_ID();";
            return $this->DBH->fetchQueryWithParams($query, $params);
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
            return $this->DBH->fetchQueryWithParams($query, $params);
        } catch (\Exception $e) {
            throw new \RuntimeException("Error inserting habitation: " . $e->getMessage());
        }
    }

    public function insertReservation($params)
    {
        try {
            $query = "INSERT INTO Immobilier_reservation 
            (id_client, id_habitation, date_arrivee, date_depart) 
            VALUES 
            (:id_client, :id_habitation, :date_arrivee, :date_depart);
        SELECT LAST_INSERT_ID();";
            return $this->DBH->fetchQueryWithParams($query, $params);
        } catch (\Exception $e) {
            throw new \RuntimeException("Error inserting reservation: " . $e->getMessage());
        }
    }
}

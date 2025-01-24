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

    public function getAllHabitations(string $search = null)
    {
        try {
            // Requête pour sélectionner les habitations avec une image aléatoire et le nom du type
            $query = "SELECT h.*, 
                            t.designation AS type_name,
                            (SELECT img.img_url 
                            FROM Immobilier_img img 
                            WHERE img.id_habitation = h.id 
                            ORDER BY RAND() 
                            LIMIT 1) AS img_url
                    FROM Immobilier_habitation h
                    JOIN Immobilier_type t ON h.id_type = t.id";


            // Ajouter une condition pour la recherche si nécessaire
            if ($search != null) {
                $query .= " WHERE h.designation LIKE '%$search%'";
            }

            // Exécuter la requête avec les paramètres
            return $this->DBH->fetchQueryWithParams($query, array()) ?: false;
        } catch (\Exception $e) {
            // Gérer les erreurs
            throw new \RuntimeException("Error fetching: " . $e->getMessage() . $query);
        }
    }


    public function getHabitationById (int $id) {
        try {
            $query = "SELECT h.*, t.designation AS type_name
                    FROM Immobilier_habitation h
                    JOIN Immobilier_type t ON h.id_type = t.id 
                    WHERE h.id = :id";
            $params = [':id' => $id];
            return $this->DBH->fetchQueryWithParams($query, $params)[0] ?: false;
        }catch (\Exception $e) {
            throw new \RuntimeException("Error fetching : " . $e->getMessage(). $query);
        }
    }

    public function getAllImgOfHabitation (int $id) {
        try {
            $query = "SELECT * FROM Immobilier_img WHERE id_habitation = :id_habitation";
            $params = [':id_habitation' => $id];
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

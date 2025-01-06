<?php

namespace app\models\admin;

use app\models\Connection;

class SpecificQuery
{
    private Connection $DBH;

    public function __construct(Connection $DBH)
    {
        $this->DBH = $DBH;
    }

    public function getRandomCadeaux($limitGarcon, $limitFille)
    {
        $queryFille = "
            SELECT c.*
            FROM noel_cadeau c
            INNER JOIN noel_categorie_cadeau cc ON c.id_categorie = cc.id
            WHERE cc.nom = 'Fille'
            ORDER BY RAND()
            LIMIT $limitFille
        ";

        $queryGarcon = "
            SELECT c.*
            FROM noel_cadeau c
            INNER JOIN noel_categorie_cadeau cc ON c.id_categorie = cc.id
            WHERE cc.nom = 'Garçon'
            ORDER BY RAND()
            LIMIT $limitGarcon
        ";

        $queryNeutre = "
            SELECT c.*
            FROM noel_cadeau c
            INNER JOIN noel_categorie_cadeau cc ON c.id_categorie = cc.id
            WHERE cc.nom = 'Neutre'
            ORDER BY RAND()
        ";

        $cadeauxFille = $this->DBH->fetchQuery($queryFille);
        $cadeauxGarcon = $this->DBH->fetchQuery($queryGarcon);
        $cadeauxNeutre = $this->DBH->fetchQuery($queryNeutre);

        $manqueFille = $limitFille - count($cadeauxFille);
        $manqueGarcon = $limitGarcon - count($cadeauxGarcon);

        $cadeauxCompensation = [];
        if ($manqueFille > 0 || $manqueGarcon > 0) {
            $cadeauxCompensation = array_slice($cadeauxNeutre, 0, $manqueFille + $manqueGarcon);
        }

        return ["women" => $cadeauxFille, "men" => $cadeauxGarcon, "neutre" => $cadeauxCompensation];
    }

    public function getRandomCadeauxByCategorie($categorie)
    {
        return $this->DBH->fetchQueryWithParams(
            "SELECT * FROM noel_cadeau WHERE id_categorie = :category ORDER BY RAND() LIMIT 1",
            [":category" => $categorie]
        )[0];
    }

    public function validateGifts($userId, $selectedGifts)
    {
        $totalDepot = $this->DBH->fetchQueryWithParams(
            "SELECT SUM(montant) as total_depot FROM noel_depot WHERE id_user = :id_user",
            [":id_user" => $userId]
        )["total_depot"];

        $totalCost = 0;
        foreach ($selectedGifts as $gift) {
            $totalCost += $gift['prix'];
        }

        return $totalCost <= $totalDepot;
    }

}
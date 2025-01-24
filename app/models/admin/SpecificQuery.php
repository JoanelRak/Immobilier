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

    public function getAllTypes()
    {
        try {
            return $this->DBH->fetchQuery("SELECT * FROM Immobilier_type");
        } catch (\Exception $e) {
            throw new \RuntimeException("Error fetching types: " . $e->getMessage());
        }
    }


}
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


}
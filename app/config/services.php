<?php

use app\models\clients\AnouncementModel;
use app\models\Connection;
use flight\Engine;
use flight\database\PdoWrapper;
use flight\debug\database\PdoQueryCapture;
use Tracy\Debugger;

/**
 * @var array $config This comes from the returned array at the bottom of the config.php file
 * @var Engine $app
 */

// MySQL DSN
$dsn = 'mysql:host=' . $config['database']['host'] . ';dbname=' . $config['database']['dbname'] . ';charset=utf8mb4';

// Choose PDO wrapper based on debug mode
$pdoClass = Debugger::$showBar === true ? PdoQueryCapture::class : PdoWrapper::class;

// Correctly map the db method
Flight::register('db', $pdoClass, [ $dsn, $config['database']['user'] ?? null, $config['database']['password'] ?? null ]);

Flight::map('connection', function () {
    return new Connection(Flight::db());
});

Flight::map('anouncementModel', function () {
    return new AnouncementModel(Flight::connection());
});
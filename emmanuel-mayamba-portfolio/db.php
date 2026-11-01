<?php
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

function db(): mysqli {
    static $connection;
    if (!$connection) {
        $config = require __DIR__ . '/config.php';
        $connection = new mysqli($config['host'], $config['username'], $config['password'], $config['database'], $config['port']);
        $connection->set_charset('utf8mb4');
        $connection->query("SET time_zone = '+00:00'");
    }
    return $connection;
}

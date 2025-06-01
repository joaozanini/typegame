<?php
require_once __DIR__ . '../../../vendor/autoload.php';

function getMongoDB()
{
    $config = require 'applicationProperties.php';

    $url      = $config['mongodb']['url'];
    $dbName   = $config['mongodb']['database'];
    $options  = $config['mongodb']['options'] ?? [];

    $client = new MongoDB\Client($url, $options);

    echo "<script>alert('conectado');</script>";
    return $client->selectDatabase($dbName);
}

<?php
require 'vendor/autoload.php'; // Autoload do Composer

function getMongoDB()
{
    $config = require 'applicationProprierties';

    $url      = $config['mongodb']['url'];
    $dbName   = $config['mongodb']['database'];
    $options  = $config['mongodb']['options'] ?? [];

    $client = new MongoDB\Client($url, $options);

    return $client->selectDatabase($dbName);
}

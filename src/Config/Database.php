<?php

$applicationproperties = parse_ini_file("application.properties");

$host = $applicationproperties['db.host'];
$port = $applicationproperties['db.port'];
$dbname = $applicationproperties['db.name'];
$user = $applicationproperties['db.user'];
$password = $applicationproperties['db.password'];

$conn = new mysqli($host, $user, $password, $dbname, $port);

if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}
echo "Connected successfully";
?>

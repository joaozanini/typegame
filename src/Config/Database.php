<?php

function db_connect() {
  $applicationproperties = parse_ini_file("applicationProperties.ini");

  $host = $applicationproperties['db.host'];
  $port = $applicationproperties['db.port'];
  $dbname = $applicationproperties['db.name'];
  $user = $applicationproperties['db.user'];
  $password = $applicationproperties['db.password'];

  $conn = new mysqli($host, $user, $password, $dbname, $port);

  if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
  }

  return $conn;
}

?>

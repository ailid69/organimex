<?php
define('DB_SERVER', '192.168.0.2');
define('DB_USERNAME', 'webuser');    // DB username
define('DB_PASSWORD', 'PJOJUFDU');    // DB password
define('DB_DATABASE', 'orgamigos');    // DB database

$connection = new mysqli(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_DATABASE);
//var_dump($connection);
if ($connection->connect_errno) {
    echo "Echec lors de la connexion à MySQL : (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
}

?>
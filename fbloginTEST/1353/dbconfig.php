<?php
define('DB_SERVER', 'localhost');
define('DB_USERNAME', 'webuser');    // DB username
define('DB_PASSWORD', 'PJOJUFDU');    // DB password
define('DB_DATABASE', 'orgamigos');      // DB name
$connection = mysql_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD) or die( "Unable to connect");
$database = mysql_select_db(DB_DATABASE) or die( "Unable to select database");
?>
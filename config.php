<?php 

require_once __DIR__ . '/vendor/autoload.php';
/*-------------------------------------------------------------------------------------------------
	TO BE SET ACCORDING TO THE ENVIRONMENT
-------------------------------------------------------------------------------------------------*/
	ini_set("display_errors", 1);				// COMMENT IN PRODUCTION
	define("WEBSITE", "http://ailid.ddns.net");	// WEBSITE ROOT USED FOR REDIRECTIONS
/* Connection string to the DataBase */
	define("USERNAME","webuser");
	define("PASSWORD","PJOJUFDU");
	define("HOST","192.168.0.2");
	define("DBNAME","ORGAMIGOS");
/* ------------------------- FACEBOOK INTEGRATION ----------------------- */		
	define("APP_ID" , "1465837763458763"); // Replace {app-id} with your Facebok app id
	define("APP_SECRET", "6b10eb5ee969eda762b07b478f2414c7");
	define("LOGIN_URL", "http://ailid.ddns.net/fb-callback.php");
/* ------------------------- GOOGE MAPS INTEGRATION ----------------------- */	
	define("GOOGLE_API_KEY",'AIzaSyD0zrXf_apGXTWv5otJz1fT6qc7l2JmQJc');
/* ------------------------- PHP SESSION ENDS AFTER THIS AMOUNT OF SECONDS OF INACTIVITY ----------------------- */	
	define("SESSION_TIMEOUT",3600);
/* ------------------------- EMAIL SETTINGS ----------------------- */	
	define("SMTP_HOST","smtp.gmail.com");
	define("SMTP_PORT",465);	
	define("SMTP_USER","orgamigos.mx@gmail.com");
	define("SMTP_PASS","PJOJUFDU");
	define("SMTP_FROM","orgamigos.mx@gmail.com");
	define("SMTP_REPLYTO","orgamigos.mx@gmail.com");
/* ------------------------- DEBUG HELP TO DISPLAY DATE OF LAST GIT COMMIT ----------------------- */	
	define("GITPATH","/volume1/web/orgamigos");
// *****************************************************************************

	session_start(); // Start or resume php session
	$now = time();
	if (isset($_SESSION['discard_after']) && $now > $_SESSION['discard_after']) {
	// If the seesion has expired we create a new one
		session_unset();
		session_destroy();
		session_start();
	}
	// The expiration time of the session is set to X secs from now
	$_SESSION['discard_after'] = $now + SESSION_TIMEOUT;

	/* $db is the object to access database */
	/*$db;
    $options = array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8'); 
    try { 
		$db = new PDO('mysql:host='.HOST.';dbname='.DBNAME.';charset=utf8', USERNAME, PASSWORD, $options); 
	} 
	catch(PDOException $ex){ 
		die("Failed to connect to the database: " . $ex->getMessage());
	} 
	
	$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
    $db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC); 
	*/

	
?>
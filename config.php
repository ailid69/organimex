<?php 
ini_set("display_errors", 1);
require_once __DIR__ . '/vendor/autoload.php';
/*-------------------------------------------------------------------------------------------------
	SECTION A PARAMETRER EN FONCTION DE L'ENVIRONNEMENT 
	Ce fichier  : 
		-sert à créer le lien vers la base de données
		-sert à stocker des variables de l'application
		-contient des fonctions utilisées par d'autres parties de l'application
-------------------------------------------------------------------------------------------------*/

	/* ini_set("display_errors", 1); doit être commenté en PRODUCTION */
	//ini_set("display_errors", 1);
	/* Variables de connexion à la base mySQL */
		define("USERNAME","webuser");
		define("PASSWORD","PJOJUFDU");
		define("HOST","192.168.0.2");
		define("DBNAME","ORGAMIGOS");
		
		define("APP_ID" , "1465837763458763"); // Replace {app-id} with your Facebok app id
		define("APP_SECRET", "6b10eb5ee969eda762b07b478f2414c7");
		define("LOGIN_URL", "http://ailid.ddns.net/fb-callback.php");
/* ------------------------- SECTION A PARAMETRE EN FONCTION DE L'ENVIRONNEMENT ----------------------- */	
		define("WEBSITE", "http://ailid.ddns.net");   // WEBSITE ROOT USED FOR REDIRECTIONS
		define("GOOGLE_API_KEY",'AIzaSyD0zrXf_apGXTWv5otJz1fT6qc7l2JmQJc');
		session_start(); // Démarrage de la session php 
		/*echo '***** AFTER SESSION START  *****<br><br>';
		print_r($_SESSION);
		echo '<br><br>***** ************************** *****<br><br>';
		echo '***<br> Session started ***';*/
		$now = time();
		if (isset($_SESSION['discard_after']) && $now > $_SESSION['discard_after']) {
	//La session a expirée, on en crée une nouvelle
		/*session_unset();
		echo '***<br> Session unset ***';
		session_destroy();
		echo '***<br> Session destroyed ***';
		session_start();
		echo '***<br> Session started ***';
	}*/

// La durée de vie de la session est étendue d'une heure
	$_SESSION['discard_after'] = $now + 3600;
	/*echo '***<br> Session extended +1h ***';*/
	}
	
// ------------------------------------

	
	
	/* $db permet d'accèder à la base de données*/
	$db;
    $options = array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8'); 
    try { 
		$db = new PDO('mysql:host='.HOST.';dbname='.DBNAME.';charset=utf8', USERNAME, PASSWORD, $options); 
	} 
	catch(PDOException $ex){ 
		die("Failed to connect to the database: " . $ex->getMessage());
	} 
	
	$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
    $db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC); 
	
function checkUser($id,$email, $db) {
		$query = "SELECT UID FROM users WHERE fbid= " . $id;
		//echo $query;
		
		try{
			$stmt = $db->prepare($query); 
			$stmt->execute(); 
			$result = $stmt->rowCount();
			
	//echo $result;
			if ($result==0) { // User exists already in the DB with a FBID	
				$query = "SELECT UID FROM users WHERE email=" . $db->quote($email);
			//	echo $query;
				$stmt = $db->prepare($query); 
				$stmt->execute(); 
				$result = $stmt->rowCount();
			//	echo $result;
				if ($result==0) { // 		
					return (array("fbid"=>$id,"ismember"=>false, "isFB"=>false, "error"=>false, "info"=> "User " & $id & " is not registered as a member, can't find his email or Facebook id/"));
					exit;
				} else {   // User exists, with this email but account not linked with Facebook
					return (array("fbid"=>$id,"ismember"=>true, "isFB"=>false, "error"=>false, "info"=> "User " & $id & " is not registered as a member with account linked to facebook BUT has an account with same email, ask user to link with Facebook."));
					exit;
				}
						
			}
			else {   // Is already a member with FB account linked	
				return (array("fbid"=>$id,"ismember"=>true, "isFB"=>true, "error"=>false,"info"=> "User " & $id & " is already registered as a member with account linked to Facebook"));
				exit;
			}
		}
		catch(PDOException $ex){ die("Failed to run query: " . $ex->getMessage()); } 
	}
	
?>
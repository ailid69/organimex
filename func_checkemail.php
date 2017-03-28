<?php
 require_once 'config.php';
/*-------------------------------------------------------------------------------------------------
	Permet de vérifier dynamiquement dans un formulaire si un email est déjà utilisé
	Retourne un code HTTP 200 si le nom d'utilisateur est libre
	Retourne un code HTTP 400 si le nom d'utilisateur n'est pas libre
	Si le paramètre id est spécifié dans l'URL alors on exclu l'email de l'utilisateur de la recherche 
	(dans le cas ou l'utilisateur modifie ses propres informations, l'email existe déjà mais ce n'est pas un problème)
-------------------------------------------------------------------------------------------------*/		
/*echo 'POST TON POST = ' . var_dump($_POST) . '<br><br>';
echo 'POST TON REQUEST = ' . var_dump($_REQUEST). '<br><br>';
echo 'POST TON GET = ' .  var_dump($_GET). '<br><br>';
echo 'POST TON SERVER = ' . var_dump($_SERVER). '<br><br>';*/
if (!empty($_GET['uemail'])){
	$email = $db->quote($_GET['uemail']);
	$query = "SELECT UID FROM users WHERE email = {$email};";
	
	try{ 
            $stmt = $db->prepare($query); 
            $stmt->execute(); 
			$result = $stmt->rowCount();
        } 
        catch(PDOException $ex){ die("Failed to run query: " . $ex->getMessage()); }  
    if($result == 0)
    {
        header("HTTP/1.1 200 OK");
    }
    else
    {
        header("HTTP/1.1 400 EMAIL ALREADY USED");
    }
}
	else
{
   header("HTTP/1.1 500 ERROR");
}

?>
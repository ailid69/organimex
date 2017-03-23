<?php
 require_once 'config.php';
/*-------------------------------------------------------------------------------------------------
	Permet de creer un utilisateur
	Retourne un code HTTP 200 si l'utilisateur a ete cree
	Retourne un code HTTP 400 si l'utilisateur n'a ete cree
	
-------------------------------------------------------------------------------------------------*/		


echo 'POST TON POST = ' . var_dump($_POST) . '<br><br>';
echo 'POST TON REQUEST = ' . var_dump($_REQUEST). '<br><br>';
echo 'POST TON GET = ' .  var_dump($_GET). '<br><br>';
echo 'POST TON SERVER = ' . var_dump($_SERVER). '<br><br>';

if (!empty($_POST['email']) && !empty($_POST['password']) && !empty($_POST['firstname']) && !empty($_POST['lastname']) ){
	$myemail = $_POST['email'];
	$mypassword = $_POST['password'];
	$myfirstname = $_POST['firstname'];
	$mylastname = $_POST['lastname'];
	$myfbid = $_POST['fbid'];
	$query = " 
            INSERT INTO users ( 
                fbid,
				firstname,
				lastname,
				email,
                password, 
                salt 
            ) VALUES ( 
                :fbid, 
				:firstname,
				:lastname,
				:email,
                :password, 
                :salt
            ) 
        "; 
		
		/*-------------------------------------------------------------------------------------------------
			Mesures de sécurité pour calculer le mot de passe à stocker en base
		-------------------------------------------------------------------------------------------------*/		
        
		
		$salt = dechex(mt_rand(0, 2147483647)) . dechex(mt_rand(0, 2147483647)); 
        $password = hash('sha256', mypassword . $salt); 
        for($round = 0; $round < 65536; $round++){ $password = hash('sha256', $mypassword . $salt); } 
        
        try {  
            $stmt = $db->prepare($query); 
			$stmt->bindValue(':fbid', $myfbid, PDO::PARAM_INT);
			$stmt->bindValue(':firstname', $myfirstname, PDO::PARAM_INT);
			$stmt->bindValue(':lastname', $mylastname, PDO::PARAM_INT);
			$stmt->bindValue(':email', $myemail, PDO::PARAM_INT);
			$stmt->bindValue(':password', $password, PDO::PARAM_INT);
			$stmt->bindValue(':salt', $salt, PDO::PARAM_INT);
     
			$result = $stmt->execute(); 
			header("HTTP/1.1 200 OK");
		}
		catch(PDOException $ex){ 
			header("HTTP/1.1 400 " . $ex->getMessage());
		}

        
    }
    else
    {
        header("HTTP/1.1 500 PARAMETERS MISSING");
    }

	
?>
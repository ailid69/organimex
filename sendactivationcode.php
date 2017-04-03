<?php 

require_once 'class.user.php';


$user = new USER();
$email = $_GET['email'];

try{
	$stmt = $user->runQuery("SELECT UID, tokenCode FROM users WHERE email=:email LIMIT 1");
	$stmt->execute(array(":email"=>$email));
	$row = $stmt->fetch(PDO::FETCH_ASSOC); 
	if($stmt->rowCount() == 1){
		$user->send_activation_email ($email,$row['UID'],$row['tokenCode']);
		$user->redirect('index.php?codesent');
	}
	else {
		$user->redirect('index.php?emailnotfound&email=' . $email);
	}
}
catch(PDOException $ex){
			$err =  $ex->getMessage();
			$this->redirect("login.php?dberror&error=" .$err);
		}
?>
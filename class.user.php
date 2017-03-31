<?php

require_once 'dbconfig.php';
require_once 'dbconfig.php';


class USER{ 

	private $conn;
 
	public function __construct(){
		$database = new Database();
		$db = $database->dbConnection();
		$this->conn = $db;
    }
 
	public function runQuery($sql){
		$stmt = $this->conn->prepare($sql);
		return $stmt;
	}
 
	 public function lastID()
	 {
	  $stmt = $this->conn->lastInsertId();
	  return $stmt;
	 }
	 
	public function register($email,$fname,$lname,$upass,$code,$fbid){
	
		try{       
			$password = password_hash($upass,PASSWORD_DEFAULT);
			$stmt = $this->conn->prepare("INSERT INTO users(email,firstName,lastName,password,tokenCode,fbid) 
														VALUES(:user_mail, :user_fname, :user_lname, :user_pass,:active_code,:user_fbid)");
			$stmt->bindparam(":user_mail",$email);
			$stmt->bindparam(":user_fname",$fname);
			$stmt->bindparam(":user_lname",$lname);
			$stmt->bindparam(":user_pass",$password);
			$stmt->bindparam(":active_code",$code);
			$stmt->bindparam(":user_fbid",$fbid);
			$stmt->execute(); 
		
			return $stmt;
			
			}catch(PDOException $ex){
				$err =  $ex->getMessage();
				$this->redirect("login.php?dberror&error=" .$err);
			}
	}
	 public function loginFB($email,$fbid){

		 try
		  {	
		   $stmt = $this->conn->prepare("SELECT UID, isVerified FROM users WHERE email=:email_id AND fbid=:fb_id");
		   $stmt->execute(array(":email_id"=>$email,"fb_id"=>$fbid));
			$userRow=$stmt->fetch(PDO::FETCH_ASSOC);
			if($stmt->rowCount() == 1){
				
				if($userRow['isVerified']=="Y"){	 
					$_SESSION['userSession'] = $userRow['UID'];
					$_SESSION['userName'] = $userRow['firstName'] . ' ' . $userRow['lastName'] ;
					$this->redirect("home.php");
					return true;
				}
				else{
					$this->redirect("index.php?inactive");
					exit;
				}
			}			
			else{
				$this->redirect("index.php?wronguser");
				exit;
			}  
		}
		catch(PDOException $ex){
			$err =  $ex->getMessage();
			$this->redirect("login.php?dberror&error=" .$err);
		}
	 }
	 public function login($email,$upass){
		try{
			$stmt = $this->conn->prepare("SELECT UID, firstName, lastName, password, isVerified FROM users WHERE email=:email_id");
			$stmt->execute(array(":email_id"=>$email));
			$userRow=$stmt->fetch(PDO::FETCH_ASSOC);
			
			if($stmt->rowCount() == 1) {
				print_r($userRow);die;
				if($userRow['isVerified']=="Y"){
					if(password_verify($upass, $userRow['password'])){
						$_SESSION['userSession'] = $userRow['UID'];
						$_SESSION['userName'] = $userRow['firstName'] . ' ' . $userRow['lastName'] ;
						$this->redirect("home");
						return true;
					}
					else{
						$this->redirect("login.php?wrongpass");
						exit;
					}
				}
				else{
					$this->redirect("login.php?inactive");
					exit;
				} 
			}
			else{
				$this->redirect("login.php?wronguser");
				exit;
			}  
		}
		catch(PDOException $ex){
		   $err =  $ex->getMessage();
		   $this->redirect("login.php?dberror&error=" .$err);
		}
	}
	 
	 public function linkFB($email,$fbid){
		try
		{ 
			$stmt = $this->conn->prepare("UPDATE users SET fbid=:user_fbid WHERE email=:user_email");
			$stmt->bindparam(":user_email",$email);
			$stmt->bindparam(":user_fbid",$fbid);
			$stmt->execute(); 
			return $stmt;
		}
		catch(PDOException $ex){
		   $err =  $ex->getMessage();
		   $this->redirect("login.php?dberror&error=" .$err);
		 }
	 }
	 
	 public function is_logged_in(){
		if(isset($_SESSION['userSession'])){
			return true;
		}
	 }
	 
	public function redirect($url){
		header("Location: $url");
	}
	 
	public function logout(){
		session_unset();
		session_destroy();
	  //$_SESSION['userSession'] = false;
	}
	public function checkUser($id,$email) {
		$query = "SELECT UID FROM users WHERE fbid= " . $id;
		//echo $query;
		
		try{
			$stmt = $this->conn->prepare($query); 
			$stmt->execute(); 
			$result = $stmt->rowCount();
			
	//echo $result;
			if ($result==0) { // User exists already in the DB with a FBID	
				$query = "SELECT UID FROM users WHERE email=" . $this->conn->quote($email);
			//	echo $query;
				$stmt = $this->conn->prepare($query); 
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
		catch(PDOException $ex){ 
		
			$err =  $ex->getMessage();
			$this->redirect("login.php?dberror&error=" .$err);
		} 
	}
	public function send_mail($email,$message,$subject){      
		require_once('PHPMailer/PHPMailerAutoload.php');
		$mail = new PHPMailer();
		$mail->IsSMTP(); 
		$mail->IsHTML(true); 
		$mail->CharSet = 'UTF-8';
		$mail->SMTPDebug  = 0;                     
		$mail->SMTPAuth   = true;                  
		$mail->SMTPSecure = "ssl";                 
		$mail->Host       = SMTP_HOST;      
		$mail->Port       = SMTP_PORT;             
		$mail->AddAddress($email);
		$mail->Username=SMTP_USER;  
		$mail->Password=SMTP_PASS;            
		$mail->SetFrom(SMTP_FROM,'Org@migos');
		$mail->AddReplyTo(SMTP_REPLYTO,'Org@migos');
		$mail->Subject    = $subject;
		$mail->MsgHTML($message);
		$mail->Send();
	  //var_dump($mail->ErrorInfo);
	} 
}
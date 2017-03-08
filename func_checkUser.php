<?php
include 'dbconfig.php';

    if (isset($_POST['id']) && isset($_POST['email'])) {
        checkUser($_POST['id'],$_POST['email'],$connection);
	}
	else {
		echo json_encode(array("fbid"=>$_POST['id'],"fbemail"=>$_POST['email'],"error"=>"true","description"=>"Needs a Facebook id as an entry parameter/"));
	}
    
	function checkUser($id,$email, $con) {
		$query = "SELECT * FROM Users WHERE fuid='$id'";
		$result = $con->query($query);
		$check = $result->num_rows;
	
		if (empty($check)) { // User exists already in the DB with a FBID	
		
			$query = "SELECT * FROM Users WHERE email='$email'" ;
			$result = $con->query($query);
			$check = $result->num_rows;
			if (empty($check)) { // 		
				echo json_encode(array("fbid"=>$id,"ismember"=>"false", "isFB"=>"false", "error"=>false, "info"=> "User " & $id & " is not registered as a member, can't find his email or Facebook id/"));
			} else {   // User exists, with this email but account not linked with Facebook
				echo json_encode(array("fbid"=>$id,"ismember"=>"true", "isFB"=>"false", "error"=>"false", "info"=> "User " & $id & " is not registered as a member with account linked to facebook BUT has an account with same email, ask user to link with Facebook."));
			}
					
		} else {   // Is already a member with FB account linked	
		
			echo json_encode(array("fbid"=>$id,"ismember"=>"true", "isFB"=>"true", "error"=>"false","info"=> "User " & $id & " is already registered as a member with account linked to Facebook"));
		}
	}

?>
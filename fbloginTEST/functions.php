<?php
require 'dbconfig.php';
function checkuser($fuid,$ffname,$femail){
    $query = "SELECT * FROM Users WHERE uid='$fuid'";
	$result = $connection->query($query);
	$check = $result->num_rows;
	
	if (empty($check)) { // if new user . Insert a new record		
		$query = "INSERT INTO Users (Fuid,Ffname,Femail) VALUES ('$fuid','$ffname','$femail')";
		$connection->query($query);	
	} else {   // If Returned user . update the user record		
		$query = "UPDATE Users SET Ffname='$ffname', Femail='$femail' where Fuid='$fuid'";
		$connection->query($query);	
	}
}?>

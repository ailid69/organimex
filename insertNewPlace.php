<?php 
require_once 'config.php';

// Gets data from URL parameters.
$name = $_GET['name'];
$address = $_GET['address'];
$lat = $_GET['lat'];
$lng = $_GET['lng'];
$type = $_GET['type'];

// Inserts new row with place data.

$query = " 
            INSERT INTO ecocasa ( 
                id, name, address, lat, lng, type
            ) VALUES ( 
                :myid, 
				:myname,
				:myaddress,
				:mylat,
                :mylng, 
                :mytype
            ) 
        "; 		 
		 
try {  
            $stmt = $db->prepare($query); 
			$stmt->bindValue(':myid', $id, PDO::PARAM_INT);
			$stmt->bindValue(':myname', $name, PDO::PARAM_INT);
			$stmt->bindValue(':myaddress', $address, PDO::PARAM_INT);
			$stmt->bindValue(':mylat', $lat, PDO::PARAM_INT);
			$stmt->bindValue(':mylng', $lng, PDO::PARAM_INT);
			$stmt->bindValue(':mytype', $type, PDO::PARAM_INT);
     
			$result = $stmt->execute(); 
			header("HTTP/1.1 200 OK");
		}
		catch(PDOException $ex){ 
			header("HTTP/1.1 400 " . $ex->getMessage());
		}
	

?>
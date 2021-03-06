<?php
require_once 'config.php';
require_once 'class.user.php';

$user = new USER();
// Start XML file, create parent node

$dom = new DOMDocument("1.0");
$node = $dom->createElement("markers");
$parnode = $dom->appendChild($node);

// Opens a connection to a MySQL server
$query = "SELECT * FROM `ecocasa`";
try{
		$stmt = $user->runQuery($query); 
        $stmt->execute(); 		
}
catch(PDOException $ex){ 
			header("HTTP/1.1 400 " . $ex->getMessage());
			die ('Hubó un problema con los datos, perdon ...');
		}
header("Content-type: text/xml");

// Iterate through the rows, adding XML nodes for each
while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
 // Add to XML document node
  $node = $dom->createElement("marker");
  $newnode = $parnode->appendChild($node);
  $newnode->setAttribute("name",$row['name']);
  $newnode->setAttribute("address", $row['address']);
  $newnode->setAttribute("lat", $row['lat']);
  $newnode->setAttribute("lng", $row['lng']);
  $newnode->setAttribute("status", $row['status']);
  
}
echo $dom->saveXML();

?>
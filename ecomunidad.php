<?php 
require_once 'config.php';
require_once 'class.user.php';

$user_home = new USER();

if(!$user_home->is_logged_in())
{
 $user_home->redirect('index.php');
}
try{
	$stmt = $user_home->runQuery('SELECT UID, name, frequency, day, status, DATE_FORMAT(start_time, "%H:%i") as `start`, DATE_FORMAT(end_time, "%H:%i") as `end` FROM  `ecocasa`  WHERE UID=:uid');
	$stmt->execute(array(":uid"=>$_GET['id']));
	$row = $stmt->fetch(PDO::FETCH_ASSOC);
}
catch(PDOException $ex){
	$user->redirect('index.php?dberror');
}

function dia_de_venta ($f, $d, $s, $e){
	$txt = "Ventas cada ";
	switch ($f){
		case "weekly" : 
			$txt =  $txt . "semana ";
			break;
		case "biweekly" : 
			$txt =  $txt . "dos semana ";
			break;
		case "monthly" : 
			$txt =  $txt . "mes ";
			break;
	}
	$txt =  $txt . "los ";
	
	switch ($d){
		case 1 : 
			$txt =  $txt . "lunes ";
			break;
		case 2 : 
			$txt =  $txt . "martes ";
			break;
		case 3 : 
			$txt =  $txt . "miercoles ";
			break;
		case 4 : 
			$txt =  $txt . "jueves ";
			break;
		case 5 : 
			$txt =  $txt . "viernes ";
			break;
		case 6 : 
			$txt =  $txt . "sabado ";
			break;
		case 7 : 
			$txt =  $txt . "domingo ";
			break;
	}
	$txt =  $txt . "de " . $s . " a " . $e ;
	return $txt;
	
}
?>

<!doctype html>
<html lang="es">
    
<head>
	<meta charset="utf-8" />
	<link rel="apple-touch-icon" sizes="76x76" href="img/apple-icon.png">
	<link rel="icon" type="image/png" href="img/favicon-16x16.png">	

	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
	<title>Org@migos - <?php echo $row['name']; ?></title>
	<meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0' name='viewport' />
	<meta name="viewport" content="width=device-width" />

	<link href="bootstrap3/css/bootstrap.css" rel="stylesheet" />
	<link href="bootstrap3/css/font-awesome.css" rel="stylesheet" />

	<link href="assets/css/gsdk.css" rel="stylesheet" />   
	<link href="assets/css/demo.css" rel="stylesheet" /> 
	<link href="css/orgamigos.css" rel="stylesheet" />
	<link href="css/bootstrap-social.css" rel="stylesheet" />
	<!--     Font Awesome     -->
	<link href="http://netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css" rel="stylesheet">
	<link href='http://fonts.googleapis.com/css?family=Grand+Hotel' rel='stylesheet' type='text/css'>
</head>

<body>
	<?php include 'handle_notification.php'; ?>
	<?php include 'home-nav.php'; ?>
	<div class="container leftnav-margin">
		<div class="eco-container brown-4-bg">
		<h1 class="text-center">
			<?php echo $row['name']; ?>
			<small class="subtitle">
				<?php 
					if ($row['status'] == 'opened' || $row['status'] == 'demo' ) {
						echo dia_de_venta($row['frequency'],$row['day'],$row['start'],$row['end']); 
					}
					elseif ($row['status'] == 'project'){
						echo ('Este lugar todavia esta en constucción, ayudanos a encontrar productores y consumidores para abrir ventas los mas pronto que puede');					
					} 
				?> 
			</small>
		</h1>
		</div>
	</div>

<!--	
<div class="main eco-main eco-color" >
	<div class="container eco-container brown-4-bg" >
		<img src="/img/blur6.jpg" alt="rounded Image" class="img-rounded center-block eco-img"> 
	</div>
</div>	
	
<div class="main eco-main eco-color" >
	<div id="4href1"></div>
    <div class="container eco-container brown-2-bg >
	
	   <h1 class="text-center">¡ Bienvenido !<small class="subtitle">Es súper simple !</small></h1>
       
	   <img src="/img/circle4.png" alt="Circle Image" class="img-circle center-block eco-circleimg">

	   <h2 class="text-center">¿ Como vas ?</h2>
     </div>	
</div>	
-->	
	   
		

	<!--?php include 'footer.php'; ?-->
	<?php include 'footer.php'; ?>
</body>
<script src="assets/js/jquery.min.js" type="text/javascript"></script>
	<script src="bootstrap3/js/bootstrap.js" type="text/javascript"></script>
	<!--script src="assets/js/validator.min.js" type="text/javascript"></script-->

</html>
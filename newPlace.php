<?php 
require_once 'config.php';
?>
<!doctype html>
<html lang="es">
<head>
	<meta charset="utf-8" />
	<link rel="apple-touch-icon" sizes="76x76" href="img/apple-icon.png">
	<link rel="icon" type="image/png" href="img/favicon-16x16.png">	
	
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
	<title>Org@migos - Abrir un lugar para organizar ecoventas</title>

	<meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0' name='viewport' />
    <meta name="viewport" content="width=device-width" />
	
    <link href="bootstrap3/css/bootstrap.css" rel="stylesheet" />
    <link href="bootstrap3/css/font-awesome.css" rel="stylesheet" />
    
	<!--link href="jasny-bootstrap/css/jasny-bootstrap.css" rel="stylesheet" /!--> 
	
	<link href="assets/css/gsdk.css" rel="stylesheet" />   
    <link href="assets/css/demo.css" rel="stylesheet" > 
	<link href="css/orgamigos.css" rel="stylesheet" />   
    <!--     Font Awesome     -->
    <link href="http://netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css" rel="stylesheet">
    <link href='http://fonts.googleapis.com/css?family=Grand+Hotel' rel='stylesheet' type='text/css'>
  
	<style type="text/css">
      #map {
        height: 80%;
      }
	  html, body {
        height: 100%;
        margin: 0;
        padding: 0;
      }
    </style>
  
</head>

<body>
 <?php $isHome = false; include 'header.php'; ?>
	
		
		
<div class="main eco-main" style="eco-color" >
	<div class="container eco-container" id="section1" style="padding-top : 100px;" >
	   <h1 class="text-center">Abrir un lugar para organizar ecoventas<small class="subtitle">Es súper simple !</small></h1>
       
	   <img src="/img/circle1.png" alt="Circle Image" class="img-circle center-block eco-circleimg">

	   <h2 class="text-center">¿ Donde esta ?</h2>
       
		
			<form hidden data-toggle="validator" role="form" method="POST" id="gmap_form" onSubmit="saveData()"> 	
				<div class="row">
					<div class="col-sm-8 col-sm-offset-2">
						<div class="form-group has-feedback">
							<label for="inputName">Nombre del lugar</label>
							<div class="input-group">
								<span class="input-group-addon"><i class="glyphicon glyphicon-tags"></i></span>
								<input
									type="text" class="form-control" 
									id="inputName" 
									name="name"
									placeholder="Nombre del lugar" 	
									required
									data-error="Tienes que entrar un nonre para este lugar"						
								>
								<span class="glyphicon form-control-feedback" aria-hidden="true"></span>
							</div>
							<div class="help-block with-errors"></div>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-sm-8 col-sm-offset-2">
						<div class="form-group has-feedback">
							<label for="inputAddress">Direccíon (corrija o completala con mas informacíon, numero de calle, entrecalles etc.)</label>
							<div class="input-group">
								<span class="input-group-addon"><i class="glyphicon glyphicon-envelope"></i></span>
								<input
									type="text" class="form-control" 
									id="inputAddress" 
									name="address"
									placeholder="Direción del lugar" 	
									required
									data-error="La dirección es incorecta o vacía"						
								>
								<span class="glyphicon form-control-feedback" aria-hidden="true"></span>
							</div>
							<div class="help-block with-errors"></div>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-sm-8 col-sm-offset-2">
						<div class="form-group">
							<label class="radio ct-azzure">
								<input type="radio" name="inputType" data-toggle="radio" id="optionsRadios1" value="abierto" disabled>
								 <i></i>Abierto
							</label>

							<label class="radio ct-green">
								<input type="radio" name="inputType" data-toggle="radio" id="optionsRadios2" value="proyecto" checked>
									<i></i>En proyecto
							</label>
							<label class="radio ct-orange">
								<input type="radio" name="inputType" data-toggle="radio" id="optionsRadios3" value="cerrado" disabled>
									<i></i>Cerrado
							</label>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-sm-8 col-sm-offset-2">
						<button type="submit" class="btn btn btn-primary" id="btn_submit">
							Registrar
						</button>
					</div>
				</div>
	</div>
</div>
<div hidden id="message">
	<div class="alert alert-success">
        <div class="container">
        ¡ El nuevo eco-lugar esta registrado ! 
		</div>
    </div>
</div>
<div id="map"></div>


<?php include 'footer.php'; ?>

</body>

    <script src="jquery/jquery-1.10.2.js" type="text/javascript"></script>
	<script src="assets/js/jquery-ui-1.10.4.custom.min.js" type="text/javascript"></script>

	<script src="bootstrap3/js/bootstrap.js" type="text/javascript"></script>
	<script src="jasny-bootstrap/js/jasny-bootstrap.js" type="text/javascript"></script>
	
	
	<script src="assets/js/gsdk-checkbox.js"></script>
	<script src="assets/js/gsdk-radio.js"></script>
	<script src="assets/js/gsdk-bootstrapswitch.js"></script>
	<script src="assets/js/get-shit-done.js"></script>
	
    <!-- The blurry effect on backgroun d image on scroll
	<script src="assets/js/custom.js"></script>
	!-->

	<script src="js/gmapsNewcasa.js"></script>
	<script async defer src="https://maps.googleapis.com/maps/api/js?key=<?php echo GOOGLE_API_KEY ?>&callback=initMap"></script>

</html>

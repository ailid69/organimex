<?php
require_once 'config.php';
require_once 'class.user.php';

$user = new USER();

if($user->is_logged_in()!=""){
	$user->redirect('home.php');
}

if(isset($_POST['btn-submit']))
{
 $email = $_POST['txtemail'];
 
 $stmt = $user->runQuery("SELECT UID, firstName FROM users WHERE email=:email LIMIT 1");
 $stmt->execute(array(":email"=>$email));
 $row = $stmt->fetch(PDO::FETCH_ASSOC); 
 if($stmt->rowCount() == 1)
 {
  $id = base64_encode($row['UID']);
  $code = md5(uniqid(rand()));
  
  $stmt = $user->runQuery("UPDATE users SET tokenCode=:token WHERE email=:email");
  $stmt->execute(array(":token"=>$code,"email"=>$email));
  
  $message= "
       Hola , " . $row['firstName'] . "
       <br /><br />
	   Recibimos una pedida para reinicializar tu contraseña, 
       si lo quieres hacer, click en el enlace que sigue, sinon puedes ignorar este mensage.
       <br /><br />
     
       <a href=' " . WEBSITE . "/resetpass.php?id= " . $id . "&code=" . $code . "'>Click en en enlace para reinicialiar tu contraseña</a>
       <br /><br />
       Gracia :)
       ";
  $subject = "Org@migos - Reinicializar tu contraseña";
  
  $user->send_mail($email,$message,$subject);
  $user->redirect('index.php?forgetpass&email=' . $email );
 }
 else
 {
	$user->redirect('forgetpass.php?emailnotfound&email=' . $email );
 }
}
?>

<!doctype html>
<html lang="es">
<head>
<meta charset="utf-8" />
	<link rel="apple-touch-icon" sizes="76x76" href="img/apple-icon.png">
	<link rel="icon" type="image/png" href="img/favicon-16x16.png">	
	
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
	<title>Org@migos - ¿ Olvidaste tu contraseña ?</title>

	<meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0' name='viewport' />
    <meta name="viewport" content="width=device-width" />
	
    <link href="bootstrap3/css/bootstrap.css" rel="stylesheet" />
    <link href="bootstrap3/css/font-awesome.css" rel="stylesheet" />
     
	<link href="assets/css/gsdk.css" rel="stylesheet" />   
    <link href="assets/css/demo.css" rel="stylesheet" /> 
	
	<link href="css/login.css" rel="stylesheet" />
	<link href="css/orgamigos.css" rel="stylesheet" />
	<link href="css/bootstrap-social.css" rel="stylesheet" />
    <!--     Font Awesome     -->
    <link href="http://netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css" rel="stylesheet">
    <link href='http://fonts.googleapis.com/css?family=Grand+Hotel' rel='stylesheet' type='text/css'>
</head>
<body>
<?php include 'handle_notification.php'; ?>
<?php include 'header.php'; ?>

	<!--div class="main eco-main" id="registerForm" style="background-image:url('img/bg-forgotpass.jpg');
		background-color : transparent;
    width:100%;
    background-repeat:no-repeat;
    background-size:cover;
    background-position: center center;"-->
	
	<div class="main eco-main">
		<div id="myCarousel" class="carousel container slide">
			<div class="carousel-inner">
					<div class="active item item-1"></div>
					<div class="item item-2"></div>
					<div class="item item-3"></div>
					<div class="item item-4"></div>
					<div class="item item-5"></div>
					<div class="item item-6"></div>
			</div>
			<a class="left carousel-control" href="#myCarousel" role="button" data-slide="prev">
				<span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
				<span class="sr-only">Previous</span>
			</a>
			<a class="right carousel-control" href="#myCarousel" role="button" data-slide="next">
				<span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
				<span class="sr-only">Next</span>
			</a>
		</div>

	
		<div class="container eco-container" id="section1" style="padding-top:100px; padding-bottom:50px; background-color : transparent;">
			<div class = "eco-panel rounded-panel xl-panel white-bg ">
				<div class="container-fluid">
					
						<h1 class="text-center">
							¿ Olvidaste tu contraseña ?<br>
							<small class="subtitle white">
								No hay problema, lo arreglamos
							</small>
						</h1>	
				 
				</div>		

			<form data-toggle="validator" role="form" method="POST" id="forgetpassform"> 	
				<div class="row">
					<div class="col-xs-12 col-sm-12 col-md-12">
						<div class="form-group has-feedback">
							<label for="inputUserEmail">Email</label>
							<div class="input-group">
								<span class="input-group-addon"><i class="glyphicon glyphicon-envelope"></i></span>
								<input
									type="email" class="form-control" 
									id="inputUserEmail" 
									name="txtemail"
									placeholder="Dirección de correo electroníco" 	
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
					<div class="col-xs-12 col-sm-12 col-md-12">
						<button class="btn btn-block btn-primary btn-fill" type="submit" name="btn-submit">
							Generar una nueva contraseña
						</button>
					</div>
				</div>
			</form>
			</div>
		</div>
	</div>
<?php include 'footer.php'; ?>	
</body>
	<script src="assets/js/jquery.min.js" type="text/javascript"></script>
	<script src="bootstrap3/js/bootstrap.js" type="text/javascript"></script>
	<script src="assets/js/validator.min.js" type="text/javascript"></script>
	<script type="text/javascript">
	  $(document).ready(function() {
		$('.carousel').carousel({interval: 7000});
	  });
	</script>
</html>


        
			
			
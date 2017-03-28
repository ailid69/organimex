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
  $id = base64_encode($row['userID']);
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

	<div class="main eco-main blue-1-bg" id="registerForm">
		<div class="container eco-container" style="padding-top:100px; padding-bottom:50px;">
		    <div class="row">
			<div class="col-sm-10 col-sm-offset-1">
				<h1 class="text-center">
					¿ Olvidaste tu contraseña ?<br>
					<small class="subtitle white">
						No hay problema, lo arreglamos
					</small>
				</h1>	
			</div>
		</div>		
			
		<div class="eco-panel rounded-panel large-panel white-bg">
			<form data-toggle="validator" role="form" method="POST" id="forgetpassform"> 	
				<div class="row">
					<div class="col-sm-8 col-sm-offset-2">
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
					<div class="col-sm-8 col-sm-offset-2">
						<button class="btn btn-danger btn-primary" type="submit" name="btn-submit">
							Generar una nueva contraseña
						</button>
					</div>
				</div>
			</form>
		</div>
	</div>
</body>
	<script src="assets/js/jquery.min.js" type="text/javascript"></script>
	<script src="bootstrap3/js/bootstrap.js" type="text/javascript"></script>
	<script src="assets/js/validator.min.js" type="text/javascript"></script>
</html>


        
			
			
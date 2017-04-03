<?php
require_once 'class.user.php';
$user = new USER();

if(empty($_GET['id']) && empty($_GET['code'])){
	$user->redirect('index.php');
}

if(isset($_GET['id']) && isset($_GET['code']))
{
	$id = base64_decode($_GET['id']);
	$code = $_GET['code'];
	try{
		$stmt = $user->runQuery("SELECT * FROM users WHERE UID=:uid AND tokenCode=:token");
		$stmt->execute(array(":uid"=>$id,":token"=>$code));
		$rows = $stmt->fetch(PDO::FETCH_ASSOC);

		if($stmt->rowCount() == 1){
			if(isset($_POST['btn-reset-pass'])){
				$pass = $_POST['pass'];
				$cpass = $_POST['confirm-pass'];
				if($cpass!==$pass){
					$user->redirect('resetpass.php?passnomatch');
				}
				else{
					$cpass =  password_hash($pass,PASSWORD_DEFAULT);
					$stmt = $user->runQuery("UPDATE users SET password=:upass WHERE UID=:uid");
					$stmt->execute(array(":upass"=>$cpass,":uid"=>$rows['UID']));
					$user->redirect('login.php?passreset');
				} 
			}
			else{
				//exit;
			}
		}
	}catch(PDOException $ex){
		$err =  $ex->getMessage();
		$user->redirect("login.php?dberror&error=" .$err);
	} 
}
?>
<!DOCTYPE html>
<html>
  <head>
	<meta charset="utf-8" />
	<link rel="apple-touch-icon" sizes="76x76" href="img/apple-icon.png">
	<link rel="icon" type="image/png" href="img/favicon-16x16.png">	
	
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
	<title>Org@migos - Reinicializar contraseña</title>

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


	<div class="main eco-main" id="registerForm" style="background-image:url('img/bg-resetpass.jpg');
		background-color : transparent;
    width:100%;
    background-repeat:no-repeat;
    background-size:cover;
    background-position: center center;">
		<div class="container eco-container" id="section1" style="padding-top:100px; padding-bottom:50px; background-color : transparent;">
			<div class = "eco-panel rounded-panel large-panel white-bg ">
				<div class="container-fluid">
					<h1 class="text-center ">
						¡ Hola </strong>  <?php echo $rows['firstName'] ?> ! 
						<small class="subtitle white">
							Aqui vas a poder reinicializar tu contraseña.<br>
						</small>
					</h1>	
					<form data-toggle="validator" role="form" method="POST" id="forgetpassform"> 	
						<div class="eco-row">
							<div class="col-xs-12 col-sm-12 col-md-12">
								<div class="form-group has-feedback">			
									<div class="input-group">
										<span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
										<input 
										id="inputUserPassword" 
										type="password" 
										class="form-control" 
										data-minlength="6" 
										name="pass" 
										placeholder="Nueva contraseña" 
										data-error="Este campo no puede ser vacío"
										data-minlength-error="Le falta caracteros"
										required >
										<span class="glyphicon form-control-feedback" aria-hidden="true"></span>
									</div>
									<div class="help-block with-errors">Son 6 caracters minimo</div>
								</div>				  
							</div>
						</div>
						
						<div class="eco-row">				
							<div class="col-xs-12 col-sm-12 col-md-12">
								<div class="form-group has-feedback">
									<div class="input-group">
										<span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
										<input 
											type="password" 
											class="form-control" 
											id="inputUserPasswordCheck" 
											name = "confirm-pass"
											placeholder="Confirma la contraseña"
											required
											data-error="Este campo no puede ser vacío"
											data-match="#inputUserPassword" 
											data-match-error="La contraseña es diferente, checalo bien" 				
										>
										<span class="glyphicon form-control-feedback" aria-hidden="true"></span>
									</div>				
									<div class="help-block with-errors"></div>
								</div>
							</div>
						</div>
						<div class="eco-row">
							<div class="col-xs-12 col-sm-12 col-md-12">
								<button class="btn btn-block btn-primary btn-fill" type="submit" name="btn-reset-pass">
									Reinicializar tu contraseña
								</button>
							</div>
						</div>
					</form>
				</div>	
			</div>
		</div>
	</div>
</body>					
					
					
	<script src="assets/js/jquery.min.js" type="text/javascript"></script>
	<script src="bootstrap3/js/bootstrap.js" type="text/javascript"></script>
	<script src="assets/js/validator.min.js" type="text/javascript"></script>
</html>


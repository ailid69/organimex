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
 
 $stmt = $user->runQuery("SELECT * FROM users WHERE UID=:uid AND tokenCode=:token");
 $stmt->execute(array(":uid"=>$id,":token"=>$code));
 $rows = $stmt->fetch(PDO::FETCH_ASSOC);
 
 if($stmt->rowCount() == 1)
 {
  if(isset($_POST['btn-reset-pass']))
  {
   $pass = $_POST['pass'];
   $cpass = $_POST['confirm-pass'];
   
   if($cpass!==$pass)
   {
    $msg = "<div class='alert alert-block'>
      <button class='close' data-dismiss='alert'>&times;</button>
      <strong>Sorry!</strong>  Password Doesn't match. 
      </div>";
   }
   else
   {
    $stmt = $user->runQuery("UPDATE tbl_users SET userPass=:upass WHERE userID=:uid");
    $stmt->execute(array(":upass"=>$cpass,":uid"=>$rows['userID']));
    
    $msg = "<div class='alert alert-success'>
      <button class='close' data-dismiss='alert'>&times;</button>
      Password Changed.
      </div>";
    header("refresh:5;index.php");
   }
  } 
 }
 else
 {
  exit;
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


	<div class="main eco-main blue-2-bg" id="registerForm">
		<div class="container eco-container" style="padding-top:100px; padding-bottom:50px;">
		    <div class="row">
				<div class="col-sm-10 col-sm-offset-1">
					<h1 class="text-center">
						 <strong>¡ Hola !</strong>  <?php echo $rows['firstName'] ?> 
						<small class="subtitle white">
							Aqui vas a poder reinicializar tu contraseña.<br>
						</small>
					</h1>	
				</div>
			</div>		
			
			<div class="eco-panel rounded-panel large-panel white-bg">
				<form data-toggle="validator" role="form" method="POST" id="forgetpassform"> 	
					<div class="row">
						<div class="col-sm-8 col-sm-offset-2">
							<div class="form-group has-feedback">
							<label for="inputUserPassword">Entra tu nueva contraseña</label>
								<div class="input-group">
									<span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
									<input 
									id="inputUserPassword" 
									type="password" 
									class="form-control" 
									data-minlength="6" 
									name="upass" 
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
					
				<div class="row">
					<div class="col-sm-8 col-sm-offset-2">
						<div class="form-group has-feedback">
							<label for="inputUserPasswordCheck">Repetir la contraseña</label>
							<div class="input-group">
								<span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
								<input 
									type="password" 
									class="form-control" 
									id="inputUserPasswordCheck" 
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
			</div>	
		</div>
	</div>
</body>					
					
					
	<script src="assets/js/jquery.min.js" type="text/javascript"></script>
	<script src="bootstrap3/js/bootstrap.js" type="text/javascript"></script>
	<script src="assets/js/validator.min.js" type="text/javascript"></script>
</html>






   
       <form class="form-signin" method="post">
       <h3 class="form-signin-heading">Reinicializar contraseña</h3><hr />
       <input type="password" class="input-block-level" placeholder="New Password" name="pass" required />
       <input type="password" class="input-block-level" placeholder="Confirm New Password" name="confirm-pass" required />
      <hr />
        <button class="btn btn-large btn-primary" type="submit" name="btn-reset-pass">Reset Your Password</button>
        
      </form>

    </div> <!-- /container -->

  </body>
</html>
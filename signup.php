<?php 
	require_once 'config.php';
	require_once __DIR__ . '/vendor/autoload.php';
	require_once 'class.user.php';

	// for Facebook callback
	$_SESSION['from_page']='signup.php';

	$reg_user = new USER();
	// if the user is already logged-in, redirect him to his home member page 
	if($reg_user->is_logged_in()!=""){
		$reg_user->redirect('home.php');
	}
	
	$fb = new Facebook\Facebook([
		'app_id' => APP_ID,
		'app_secret' => APP_SECRET,
		'default_graph_version' => 'v2.8',
		'persistent_data_handler'=>'session'
	]);

	$helper = $fb->getRedirectLoginHelper();
	$permissions = ['email']; // Optional permissions
	$loginUrl = $helper->getLoginUrl(LOGIN_URL, $permissions);

	// User can be asked if he wants to login rather than signup, if answered yes, redirect to login page 
	if(isset($_POST['btn-login'])){
		$reg_user->redirect('login.php');
	}
	elseif(isset($_POST['btn-signup'])){
		 $ufname = trim($_POST['ufname']);
		 $ulname = trim($_POST['ulname']);
		 $uemail = trim($_POST['uemail']);
		 $upass = trim($_POST['upass']);
		 $ufbid = trim($_POST['ufbid']);
		 $code = md5(uniqid(rand()));
		 
		 $stmt = $reg_user->runQuery("SELECT * FROM users WHERE email=:email_id OR (fbid <> NULL AND fbid=:fb_id) ");
		 $stmt->execute(array(":email_id"=>$uemail,"fb_id"=>$ufbid));
		 $row = $stmt->fetch(PDO::FETCH_ASSOC);
		 
		 if($stmt->rowCount() > 0){
			$reg_user->redirect('signup.php?emailalreadyused&email=' . $uemail);
		}
		else{
			if($reg_user->register($uemail,$ufname,$ulname,$upass,$code,$ufbid)){   
				$id = $reg_user->lastID();  
				$reg_user->send_activation_email ($uemail,$id,$code);

				// redirect user to index with notification for success
				$reg_user->redirect('index.php?usercreated');
			}
			else {
				$err_show = true;
				$err_msg = "Perdón, hubó un problema con la base de datos al crear tu cuenta. Inéntalo otra vez por favor.";	
			}  
		}
	}

	if (isset($_SESSION['fb_access_token'])){
		try {
	  // Returns a `Facebook\FacebookResponse` object
	  //$response = $fb->get('/me?fields=id,age_range,email,birthday,first_name,gender,last_name,name', $_SESSION['fb_access_token']);

		  $response = $fb->get('/me?fields=id,email,first_name,last_name,name', $_SESSION['fb_access_token']);
		  $user = $response->getGraphUser();

		} catch(Facebook\Exceptions\FacebookResponseException $e) {
		  //echo 'Graph returned an error: ' . $e->getMessage();
			$err_msg = 'Graph returned an error: ' . $e->getMessage();
			$err_show = true;
		  exit;
		} catch(Facebook\Exceptions\FacebookSDKException $e) {
		 // echo 'Facebook SDK returned an error: ' . $e->getMessage();
			$err_msg = 'Facebook SDK returned an error: ' . $e->getMessage();
			$err_show = true;
		  exit;
		}
	
		$resp = $reg_user->checkUser($user['id'],$user['email']);

		if ($resp['ismember']==true && $resp['isFB']==true ){
			// user is currently connected with Facebook
			// user already has an account and is linked with Facebook
			// Redirect to login page
			//$showModal_1=true;
			$reg_user->loginFB($user['email'],$user['id']);
			exit;
		}
		elseif ($resp['ismember']==true && $resp['isFB']==false ){
			// user is currently connected with Facebook
			// user already has an account with same email as Facebook but account is not linked with Facebook
			// show modal to propose options to user to link is account with Facebook AFTER a login 
			$showModal_2=true;
		}
		elseif ($resp['ismember']==false && $resp['isFB']==true ){
			// weird shit - the email is not known in the DataBase but the Facebook ID is?
			// what should we do? Not sure ... better not touch anythbing for now
		}
		elseif ($resp['ismember']==false && $resp['isFB']==false ){
		// everytthing is fine, email and Facebook id are not known in the DataBase.
		// just helping to fill the signup form with data from Facebook 
		// user account will be created and linked to its Facebook profile
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
	<title>Org@migos - Sumaté a la familia !</title>

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

<!-- For Javascript Facebook integration 
	<div id="fb-root"></div>
	<script src="js/facebook.js" type="text/javascript"></script>
!-->
	<?php include 'handle_notification.php'; ?>
	<?php include 'header.php'; ?>


<!--div class="main eco-main" style=" background-image: url('img/bg-signup.jpg'); padding-top:100px; 
	background-color : transparent;
    width:100%;
    background-repeat:no-repeat;
    background-size:cover;
    background-position: center center;"-->
	
<div class="main eco-main" id="loginMain">
	<div id="myCarousel" class="carousel container slide">
		<div class="carousel-inner">
				<div class="item item-1"></div>
				<div class="active item item-2"></div>
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

		<div class="tim-title white">
			<h1 class="text-center">
				Abrir una cuenta<br>
				<small class="subtitle white">La inscripcion es gratuita y sin compromiso!<br>Puedes decidir qué y cuándo compras según tus gustos.</small>
			</h1>
		</div> 
	<!-- div class="container eco-container" id="section3" style="padding-top : 100px;" -->
			<div class="container eco-container">

		<div class = "eco-panel rounded-panel large-panel white-bg ">
				<div class="container-fluid">
				<?php if (isset($_SESSION['fb_access_token'])): ?>
					<h4 class="text-center">Hola <?php echo $user['name'] ?></h4>
					<div class="eco-row">
						<div class="col-xs-12 col-sm-12 col-md-12">
							<img src="https://graph.facebook.com/<?php echo $user['id'] ?>./picture?width=120" alt="Circle Image" class="img-circle img-responsive center-block" width="120" height="120">			
						</div>
					</div>
					<div class="eco-row">
						<div class="col-xs-12 col-sm-12 col-md-12">
							<a id="btn-fb" name="btn-fb" type="submit" class="btn btn-block btn-social btn-facebook center-block" href="logout.php?">
								<span class="fa fa-facebook"></span> Cerrar la conección con Facebook
							</a>
						</div>
					</div>	
				<?php else : ?>
					<div class="eco-row">
						<div class="col-xs-12 col-sm-12 col-md-12">
							<a class="btn btn-block btn-social btn-facebook center-block" href="<?php echo htmlspecialchars($loginUrl) ?>">
								<span class="fa fa-facebook"></span> Iniciar sesión con Facebook
							</a>
						</div>
					</div>
				<?php endif ?>		
				
			<div class="login-or">
				<hr class="hr-or">
				<span class="span-or">sino</span>
			 </div>	
			<form data-toggle="validator" role="form" method="POST" id="registerForm"> 	
				<input 
					type="hidden" class="form-control" 
					id="facebookid" name="ufbid" 
					<?php if (isset($_SESSION['fb_access_token'])) {echo 'value="' . $user['id'] . '"' ;} ?> 
				>
				
						<div class="form-group has-feedback">
							
							<div class="input-group">
								<span class="input-group-addon"><i class="glyphicon glyphicon-envelope"></i></span>
								<input
									type="email" class="form-control" 
									id="inputUserEmail" 
									name="uemail"
									placeholder="Dirección de correo electroníco" 	
									<?php if (isset($_SESSION['fb_access_token'])) {echo 'value="' . $user['email'] . '" readOnly ';}?>
									required
									data-error="La dirección es incorecta o vacía"						
									data-remote="func_checkemail.php"
									data-remote-error="Una cuenta existe ya con este dirección de correo electrónico")
								>
								<span class="glyphicon form-control-feedback" aria-hidden="true"></span>
							</div>
							  <div class="help-block with-errors"></div>
						</div>

						<div class="form-group has-feedback">
							
							<div class="input-group">
								<span class="input-group-addon"><i class="glyphicon glyphicon-envelope"></i></span>
								<input 
									type="email" 							
									class="form-control" id="inputUserEmailCheck" 
									placeholder="Repite la dirección de correo electrónico"
									<?php if (isset($_SESSION['fb_access_token'])) {echo 'value="' . $user['email'] . '" disabled ';}?>					
									required
									data-error="La dirección es incorecta o vacía"
									data-match="#inputUserEmail" 
									data-match-error="El correo es diferente, checalo bien" 
								>	
								<span class="glyphicon form-control-feedback" aria-hidden="true"></span>
							</div>
						<div class="help-block with-errors"></div>
						</div>

				

						<div class="form-group has-feedback">
					
							<div class="input-group">
								<span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
								<input 
								id="inputUserPassword" 
								type="password" 
								class="form-control" 
								data-minlength="6" 
								name="upass" 
								placeholder="Contraseña" 
								data-error="Este campo no puede ser vacío"
								data-minlength-error="Le falta caractéres"
								required >
								<span class="glyphicon form-control-feedback" aria-hidden="true"></span>
							</div>
							<div class="help-block with-errors">Son 6 caractéres mínimo</div>
						</div>				  

					
				
						<div class="form-group has-feedback">
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
		
				<h4>Háblanos un poco de ti</h4>

						<div class="form-group has-feedback">
							<div class="input-group">
								<span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
								<input 
								type="text" 
								class="form-control" 
								id="inputUserFirstName" 
								name="ufname"
								data-error="Este campo no puede ser vacío"
								required 
								placeholder="Nombre(s)" 
								<?php if (isset($_SESSION['fb_access_token'])) {echo 'value="' . $user['first_name'] . '" ';}?>					
								>
								<span class="glyphicon form-control-feedback" aria-hidden="true"></span>
							</div>
							
							<div class="help-block with-errors"></div>
						</div>

	
						<div class="form-group has-feedback">				
							<div class="input-group">
								<span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
								<input 
									type="text" 
									class="form-control" 
									id="inputUserLastName" 
									name="ulname"
									data-error="Este campo no puede ser vacío" 
									placeholder="Apellido(s)" 
											<?php if (isset($_SESSION['fb_access_token'])) {echo 'value="' . $user['last_name']. '" ' ;}?>	
									required
								>				
								<span class="glyphicon form-control-feedback" aria-hidden="true"></span>
							</div>
							<div class="help-block with-errors"></div>
						</div>
						<button type="submit" class="btn btn-blockg btn-primary " id="btn-signup" name="btn-signup">
						Enviar
						</button>

	
			</form>	
			
<div class="panel-group" id="accordion">
	<div class="panel panel-default">
		<div class="panel-heading">
			<h4 class="panel-title">
				<a data-toggle="collapse" href="#collapse1">
					* Que hacemos con Facebook?
				</a>
			</h4>
		</div>
		<div id="collapse1" class="panel-collapse in" style="height: auto;">
			<div class="panel-body">
				<p class="text-muted" style=" font-size: 14px; line-height: 1;">
					Solo utilizamos Facebook para facilitarte la vida, nunca para utilizar tus datos personales.<br>
					Te permite crear tu cuenta más rapido porque recuperamos (SOLO) tu nombre, apellido, email y foto de perfil<br>
					Si tu cuenta org@migos esta ligada con tu cuenta Facebook, solo necesitas estar conectado al Face para entrar a nuestra plataforma.<br>
					Necesitas ingresar támbien una contraseña para tu cuenta org@migos para que puedas támbien entrar a la plataforma sin tu cuenta Facebook.
				</p>
			</div>
		</div>
	</div>
</div>
		
</div>		
</div>
</div>	
<!-- Modal - When a user wants to register with Facebook but an account is already there with the same email -->
<!--div class="modal fade" id="modal_1" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">	
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Una cuenta ya existe con este email</h4>
      </div>
      <div class="modal-body">
		<p> Si eres el prioprietario de este dirrecíon de correo electrónico 
			puedes liar tu cuenta <strong>Org@migos</strong> con tu cuenta Facebook para facilitar la conección.
			<br>Pero primero tienes que iniciar una sesión con tu email y contraseña
		</p>
		</div>
      <div class="modal-footer">
	  <form id="mymod1form" role="form" method="POST" action="login.php">
		<button type="submit" class="btn btn-default">Iniciar sesión</button>
	  </form>
      </div>
    </div>
  </div>	
</div-->
	<!-- Modal -->
<div class="modal fade" id="modal_2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">	
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Una cuenta ya existe con este email</h4>
      </div>
      <div class="modal-body">
				<p> Si eres el prioprietario de este dirrecíon de correo electrónico <strong><?php echo $user['email']; ?></strong>
			puedes liar tu cuenta <strong>Org@migos</strong> con tu cuenta Facebook para facilitar la conección.
			<br>Pero primero tienes que iniciar una sesión con tu email y contraseña.
		</p><div class="modal-footer">
        <form id="mymod1form" role="form" method="POST" action="login.php">
		<button type="submit" class="btn btn-info">Iniciar sesión</button></div>
		</form>
    </div>
  </div>	
</div>
</div>

</div>
<?php include 'footer.php'; ?>

</body>

    <!--script src="jquery/jquery-1.10.2.js" type="text/javascript"></script!-->
	<!--script src="assets/js/jquery-ui-1.10.4.custom.min.js" type="text/javascript"></script!-->
	<script src="assets/js/jquery.min.js" type="text/javascript"></script>
	<script src="bootstrap3/js/bootstrap.js" type="text/javascript"></script>
	<script src="assets/js/validator.min.js" type="text/javascript"></script>
	
	<?php
		if(isset($showModal_1) && $showModal_1 == true){
			echo "<script>$('#modal_1').modal('show'); </script>";
		} 
		elseif (isset($showModal_2) && $showModal_2 == true){
			echo "<script>$('#modal_2').modal('show'); </script>";
		}	
	?>	
	<script type="text/javascript">
	  $(document).ready(function() {
		$('.carousel').carousel({interval: 7000});
	  });
	</script>
</html>
<?php 
	/*-------------------------------------------------------------------------------------------------
		Login with Facebook 
		Uses Facebook SDK for JavaScript (see <scripts>)
	-------------------------------------------------------------------------------------------------*/	
	require_once 'functions.php'; 
	require_once __DIR__ . '/vendor/autoload.php';
	
	if (!session_id()) {
		session_start();
	}
	$fb = new Facebook\Facebook([
  'app_id' => '1465837763458763', // Replace {app-id} with your app id
  'app_secret' => '6b10eb5ee969eda762b07b478f2414c7',
  'default_graph_version' => 'v2.8',
  ]);

$helper = $fb->getRedirectLoginHelper();

$permissions = ['email']; // Optional permissions
$loginUrl = $helper->getLoginUrl(WEBSITE . '/fb-config.php', $permissions);

?>

<!doctype html>
<html lang="en">
<head>
<meta charset="utf-8" />
	<link rel="apple-touch-icon" sizes="76x76" href="img/apple-icon.png">
	<link rel="icon" type="image/png" href="img/favicon-16x16.png">	
	
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
	<title>Org@migos - Cortar circuitos de distribuciones</title>

	<meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0' name='viewport' />
    <meta name="viewport" content="width=device-width" />
	
    <link href="bootstrap3/css/bootstrap.css" rel="stylesheet" />
    <link href="bootstrap3/css/font-awesome.css" rel="stylesheet" />
     
	<link href="assets/css/gsdk.css" rel="stylesheet" />   
    <link href="assets/css/demo.css" rel="stylesheet" /> 
	
	<link href="css/login.css" rel="stylesheet" />
	<link href="css/orgamigos.css" rel="stylesheet" />
	
    <!--     Font Awesome     -->
    <link href="http://netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css" rel="stylesheet">
    <link href='http://fonts.googleapis.com/css?family=Grand+Hotel' rel='stylesheet' type='text/css'>
</head>
<body>
<?php include 'header.php'; ?>

	<div class="main" id="registerForm">
		<div class="container tim-container" style="max-width:800px; padding-top:100px; padding-bottom:50px;">
		   <div class="tim-title">
				<h1 class="text-center">
					Por favor ingresate o <a href="join.php">Inscribete</a><br><small class="subtitle">Puedes connectar con Facebook, solo utisamos to correo electronico, nada mas.</small>
				</h1>
			</div> 
			<div class="container-fluid">
	
				<?php if ($_SESSION['FBID']): ?>      <!--  After user login  -->
					<div class="row ">
						<div class="col-sm-2">
							<img src="https://graph.facebook.com/<?php echo $_SESSION['FBID']; ?>/picture?width=120" alt="Circle Image" class="img-circle img-responsive" width="120" height="120">
						</div>
						<div class="col-sm-10">
							
							<div class="row ">
								<div class="col-sm-12">
									<h5>Hola org@migo <?php echo $_SESSION['FULLNAME']; ?></h5>
								</div>
							</div>
							<div class="row ">
								<div class="col-sm-6">
									<a href="join.php" class="btn btn-lg btn-info btn-fill">Abrir una cuenta</a>
								</div>
								<div class="col-sm-6">
									<a href="logout.php" class="btn btn-lg btn-info btn-fill">Desconectar de Facebook</a>
								</div>
							</div>	
						</div>
					</div>

				<?php else: ?>     <!-- Before login --> 
					<div class="row">
						<div class="col-xs-12 col-sm-12 col-md-12">
							<a href="fb-config.php" class="btn btn-lg btn-info btn-fill">Connectarse con Facebook</a>
						</div>
					</div>				
				<?php endif ?>
			</div>
		
			  <div class="login-or">
				<hr class="hr-or">
				<span class="span-or">sino</span>
			  </div>

			  <form role="form">
				<div class="form-group">
				  <label for="inputUsernameEmail">Usario o correo</label>
				  <input type="text" class="form-control" id="inputUsernameEmail">
				</div>
				<div class="form-group">
				  <a class="btn btn-lg btn-info btn-simple" href="#">Olvidaste la contrasena?</a>
				  <label for="inputPassword">Contrasena</label>
				  <input type="password" class="form-control" id="inputPassword">
				</div>
				<div class="checkbox pull-right">
				  <label>
					<input type="checkbox">
					Acuerdate de mi </label>
				</div>
				<button type="submit" class="btn btn btn-primary">
				  Ingresar
				</button>
			  </form>	
		</div>		
	</div>
<?php include 'footer.php'; ?>
</body>

    <script src="jquery/jquery-1.10.2.js" type="text/javascript"></script>
	<script src="assets/js/jquery-ui-1.10.4.custom.min.js" type="text/javascript"></script>

	<script src="bootstrap3/js/bootstrap.js" type="text/javascript"></script>


</html>
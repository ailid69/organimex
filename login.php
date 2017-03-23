<?php 
	/*-------------------------------------------------------------------------------------------------
		Login with Facebook 
		Uses Facebook SDK for JavaScript (see <scripts>)
	-------------------------------------------------------------------------------------------------*/	
	require_once 'config.php';
	require_once __DIR__ . '/vendor/autoload.php';
	

	$fb = new Facebook\Facebook([
		'app_id' => APP_ID, // Replace {app-id} with your app id
		'app_secret' => APP_SECRET,
		'default_graph_version' => 'v2.8',
		 'persistent_data_handler'=>'session'
	]);

$helper = $fb->getRedirectLoginHelper();
$permissions = ['email']; // Optional permissions
$loginUrl = $helper->getLoginUrl(LOGIN_URL, $permissions);

if (isset($_SESSION['fb_access_token'])){
	try {
  // Returns a `Facebook\FacebookResponse` object
  $response = $fb->get('/me?fields=id,age_range,email,birthday,first_name,gender,last_name,name', $_SESSION['fb_access_token']);
  $user = $response->getGraphUser();
  
 // $response = $fb->get('/me?fields=cover', $_SESSION['fb_access_token']);
 // $image = $response->getGraphUser();
  

} catch(Facebook\Exceptions\FacebookResponseException $e) {
  echo 'Graph returned an error: ' . $e->getMessage();
  exit;
} catch(Facebook\Exceptions\FacebookSDKException $e) {
  echo 'Facebook SDK returned an error: ' . $e->getMessage();
  exit;
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
	<title>Org@migos - Cortar circuitos de distribuciones</title>

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
<?php include 'header.php'; ?>

	<div class="main eco-main" id="registerForm">
		<div class="container eco-container" id="section1" style="padding-top:100px; padding-bottom:50px;">
		    <div class="tim-title">
				<h1 class="text-center">
					Iniciar sesión <small class="subtitle">Si no cuentas con nosotros todavia puedes <a href="join.php">abrir una cuenta</a><br></small>
				</h1>
			</div> 
			<div class = "eco-panel rounded-panel small-panel white-bg ">
				<div class="container-fluid">
				<?php if (isset($_SESSION['fb_access_token'])): ?>     <!--  After user login  -->
					<h4 class="text-center">Hola <? echo $user['name'] ?></h4>
						<div class="eco-row">
							<img src="https://graph.facebook.com/<? echo $user['id'] ?>./picture?width=120" alt="Circle Image" class="img-circle img-responsive center-block" width="120" height="120">			
						</div>
						<a class="btn btn-block btn-social btn-facebook center-block" href="logout.php">
							<span class="fa fa-facebook"></span> Cerrar la sesíon con Facebook
						</a>

				<?php else: ?>     <!-- Before login --> 
					<div class="row">
						<div class="col-xs-12 col-sm-12 col-md-12">
							<a class="btn btn-block btn-social btn-facebook center-block" href="<? echo htmlspecialchars($loginUrl) ?>">
						<span class="fa fa-facebook"></span> Iniciar sesión con Facebook
					</a>
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
				  <!--label for="inputUsernameEmail">Correo electrónico</label!-->
				  <input type="text" class="form-control" id="inputUsernameEmail" placeHolder="Correo electrónico">
				</div>
				<div class="form-group">
				  <!--label for="inputPassword">Contraseña</label!-->
				  <input type="password" class="form-control" id="inputPassword" placeHolder="Contraseña">
				</div>
				
				<button type="submit" class="btn  btn-primary btn-fill">
				  Iniciar sesión
				</button>
		
				<button href="#fakelink" class="btn btn-sm btn-primary btn-round">Olvidaste tu contraseña?</button>

			  </form>	
			</div>
		</div>
	</div>

<?php include 'footer.php'; ?>
</body>

    <script src="jquery/jquery-1.10.2.js" type="text/javascript"></script>
	<script src="assets/js/jquery-ui-1.10.4.custom.min.js" type="text/javascript"></script>

	<script src="bootstrap3/js/bootstrap.js" type="text/javascript"></script>
	<script src="assets/js/gsdk-checkbox.js"></script>

</html>
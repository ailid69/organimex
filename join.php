<?php 
	/*-------------------------------------------------------------------------------------------------
		Login with Facebook 
		Uses Facebook SDK for JavaScript (see <scripts>)
	-------------------------------------------------------------------------------------------------*/	
	require_once 'config.php';
	require_once __DIR__ . '/vendor/autoload.php';
	/*
	echo '<div style="padding-top: 200px;">***** SESSION BEFORE ANY FACEBOOK SHIT *****><br><br>';
	print_r($_SESSION);
	echo '<br><br>***** ************************** *****<br><br>';
	*/
	$fb = new Facebook\Facebook([
		'app_id' => APP_ID, // Replace {app-id} with your app id
		'app_secret' => APP_SECRET,
		'default_graph_version' => 'v2.8',
		 'persistent_data_handler'=>'session'
	]);

$helper = $fb->getRedirectLoginHelper();
$permissions = ['email']; // Optional permissions
$loginUrl = $helper->getLoginUrl(LOGIN_URL, $permissions);
/*
echo '***** SESSION AFTER GETLOGIN URL *****<br><br>';
print_r($_SESSION);
echo '<br><br>***** ************************** *****<br><br>';
*/
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

$resp = checkUser($user['id'],$user['email'],$db);
print_r($resp);
if ($resp['ismember']==true && $resp['isFB']==true ){
	// user is currently connected with Facebook
	// user already has an account and is linked with Facebook
	// show modal to propose options to user [start session from Facebook login or unlink account and facebook}	
	$showModal_1=true;	
}
if ($resp['ismember']==true && $resp['isFB']==false ){
	// user is currently connected with Facebook
	// user already has an account with same email as Facebook but account is not linked with Facebook
	// show modal to propose options to user to link is account with Facebook
	$showModal_2=true;
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
	<title>Org@migos - Forma parte de la familia !</title>

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
<!-- For Javascript insertion -
	<div id="fb-root"></div>
-->
<script>
	/*window.fbAsyncInit = function() {
    FB.init({
      appId      : '1465837763458763',
      xfbml      : true,
      version    : 'v2.8'
    });
    FB.AppEvents.logPageView();
	refreshFB();
  };


  (function(d, s, id){
     var js, fjs = d.getElementsByTagName(s)[0];
     if (d.getElementById(id)) {return;}
     js = d.createElement(s); js.id = id;
     js.src = "//connect.facebook.net/es_LA/sdk.js";
     fjs.parentNode.insertBefore(js, fjs);
   }(document, 'script', 'facebook-jssdk'));
   */
	/*function disableRegisterForm(){
		var form = document.getElementById("registerForm");
		var elements = form.elements;
		for (var i = 0, len = elements.length; i < len; ++i) {
			elements[i].readOnly = true;
		}
		document.getElementById("btn_submit").disabled = true;
		document.getElementById("btn_login").disabled = true;
   }*/   
	/*function enableRegisterForm(){
		var form = document.getElementById("registerForm");
		
		var elements = form.elements;
		for (var i = 0, len = elements.length; i < len; ++i) {
			elements[i].readOnly = false;
		}
		document.getElementById("btn_submit").disabled = false;
		document.getElementById("btn_login").disabled = false;
   }*/
	/*function refreshFB(){
		console.log('-- Get Status From FaceBook ---');
		
		FB.getLoginStatus(function(response) {
		
		console.log(response);
		
		if (response.status === 'connected') {
			console.log('CONNECTED');
		// the user is logged in and has authenticated your
		// app, and response.authResponse supplies
		// the user's ID, a valid access token, a signed
		// request, and the time the access token 
		// and signed request each expire
		
		var uid = response.authResponse.userID;
		var accessToken = response.authResponse.accessToken;
		FB.api('/me', {fields: 'last_name,first_name,email,name'}, function(response) {
			console.log(response);
			var checkUser = $.ajax({
					url: 'func_checkuser.php',
					method: 'POST',
					data: {id:uid,email:response.email},
					
					success: function(data) {
						
						console.log('raw data from FB ' + data); // Inspect this in your console
						obj = JSON.parse(data);
						console.log('json data obj : ' + obj); // Inspect this in your console
						if ((obj.ismember === "true") && (obj.isFB === "true")){
							// user is currently connected with Facebook
							// user already has an account and is linked with Facebook
							// disable the whole form 
							// show alert <div> to propose options to user [start session from Facebook login or unlink account and facebook}
							console.log('*** isMember AND isFB ***');
							
							//document.getElementById('with_FB_link').hidden=false;
							//document.getElementById('with_no_FB_link').hidden=true;
							
							disableRegisterForm();
							$('#myModal1').modal('show');
		
						}
						
						else if ((obj.ismember === "true") && (obj.isFB === "false")){
							// user is currently connected with Facebook
							// user already has an account with same email as Facebook but account is not linked with Facebook
							// disable the whole form 
							// show alert <div> to propose options to user to link is account with Facebook
							console.log('*** isMember AND NOT isFB ***');
							//document.getElementById('with_FB_link').hidden=true;
							//document.getElementById('with_no_FB_link').hidden=false;
							disableRegisterForm();
							$('#myModal').modal('show');
						}
						else {
							// user is currently connected with Facebook and has no account here (no email, no facebookid matching)
							console.log('*** NOT isMember***');
							//document.getElementById('with_FB_link').hidden=true;
							//document.getElementById('with_no_FB_link').hidden=true;
							enableRegisterForm();
						}
				}
						
				});
			
				console.log('Check User = ' + checkUser);
				document.getElementById('inputUserFirstName').value = response.first_name;
				document.getElementById('inputUserLastName').value = response.last_name;
				document.getElementById('inputUserEmail').value = response.email;
				document.getElementById('inputUserEmailCheck').value = response.email;
				document.getElementById('facebookid').value = response.id;
				document.getElementById('inputUserEmail').disabled=true;
				document.getElementById('inputUserEmailCheck').disabled=true;
				
				document.getElementById('fbWelcome').hidden=false;
				document.getElementById('fbWelcome').innerHTML='<h4 class="text-center">Hola <strong> ' + response.name + '</strong></h4>';
				document.getElementById('fbPhoto').hidden=false;
				document.getElementById('fbPhoto').innerHTML='<img src="https://graph.facebook.com/' + response.id + '/picture?width=120" alt="Circle Image" class="img-circle img-responsive center-block" width="120" height="120">';				
			});
			
		} else if (response.status === 'not_authorized') {
			// the user is logged in to Facebook, 
			// but has not authenticated your app
			console.log('THE APP IS NOT AUTHORIZED');
			//document.getElementById('with_no_FB_link').hidden=true;
			//document.getElementById('with_FB_link').hidden=true;
			document.getElementById('inputUserFirstName').value = '';
			document.getElementById('inputUserLastName').value = '';
			document.getElementById('inputUserEmail').value = '';
			document.getElementById('inputUserEmailCheck').value = ''
			document.getElementById('inputUserEmail').disabled=false;
			document.getElementById('inputUserEmailCheck').disabled=false;
			
			document.getElementById('fbPhoto').hidden=true;
			document.getElementById('fbWelcome').hidden=true;
			document.getElementById('fbPhoto').innerHTMML='';
			document.getElementById('fbWelcome').innerHTML='';
			enableRegisterForm();
  } else {
    // the user isn't logged in to Facebook.
			console.log('NOT LOGGED TO FACEBOOK');
			//document.getElementById('with_no_FB_link').hidden=true;
			//document.getElementById('with_FB_link').hidden=true;
			
			document.getElementById('inputUserFirstName').value = '';
			document.getElementById('inputUserLastName').value = '';
			document.getElementById('inputUserEmail').value = '';
			document.getElementById('inputUserEmailCheck').value = ''
			document.getElementById('inputUserEmail').disabled=false;
			document.getElementById('inputUserEmailCheck').disabled=false;
			
			document.getElementById('fbPhoto').hidden=true;
			document.getElementById('fbWelcome').hidden=true;
			document.getElementById('fbPhoto').innerHTMML='';
			document.getElementById('fbWelcome').innerHTML='';
			enableRegisterForm();
  }
 });
 }
   */
	function adduser(){
	
		console.log('Calling JS function adduser()');
		event.preventDefault();
		//console.log('event.preventDefault()');
		var myemail = $("#inputUserEmail").val();
		var mypassword = $("#inputUserPassword").val();
		var myfirstname = $("#inputUserFirstName").val();
		var mylastname =$("#inputUserLastName").val();
		var myfbid =$("#facebookid").val();
		console.log('variables assigned, now Ajax');
		console.log('MYEMAIL' + myemail);
		console.log('MYPASSWORD' + mypassword);
		console.log('myfirstname' + myfirstname);
		var addUser = $.ajax({
			url: 'func_adduser.php',		
			method : 'POST',
			data:
			{
				email: myemail,
				password : mypassword,
				firstname: myfirstname,
				lastname : mylastname,
				fbid : myfbid,

			},
			
			success: function(response)
			{
				console.log('success');	
				console.log(response);
document.getElementById('myModalLabel').innerHTML = 'El usario esta registrado';
$('#myModal').modal('show');			
			}, 
			error: function(response)
			{
				console.log('error');
				console.log(response);

				$('#myModal').modal('show');	

			document.getElementById('myModalLabel').innerHTML = 'Un error ha ocurido ...';		
			}, 
		});
		console.log('Out of Ajax');
	
	}
</script>


<?php include 'header.php'; ?>

<div class="eco-main eco-color" style="eco-color">
	<div class="container eco-container" id="section3" style="padding-top : 100px;" >
		<div class="row">
			<div class="col-sm-10 col-sm-offset-1">
				<h1 class="text-center">
					Abrir una cuenta<br>
					<small class="subtitle">
						La inscripcion es gratuita y sin compromiso!<br>Puedes decidir que y cuando compras segun tus envidas.
					</small>
				</h1>	
			</div>
		</div>				
		<div class="eco-panel rounded-panel large-panel green-1-bg ">
			<div class="panel-heading">
				<h3 class="text-center">Registrarse con Facebook (o no*)</h3>
			</div>
			<div class="panel-body">	
			<?php if (isset($_SESSION['fb_access_token'])): ?>
					<h4 class="text-center">Hola <? echo $user['name'] ?></h4>
						<div class="eco-row">
							<img src="https://graph.facebook.com/<? echo $user['id'] ?>./picture?width=120" alt="Circle Image" class="img-circle img-responsive center-block" width="120" height="120">			
						</div>
						<a class="btn btn-block btn-social btn-facebook center-block" href="logout.php">
							<span class="fa fa-facebook"></span> Cerrar la sesíon con Facebook
						</a>	
								
			<?php else : ?>
			
					<a class="btn btn-block btn-social btn-facebook center-block" href="<? echo htmlspecialchars($loginUrl) ?>">
						<span class="fa fa-facebook"></span> Iniciar sesión con Facebook
					</a>
	
			<?php endif ?>		
		</div>	
	</div>


		<div class="space-15"></div>
	<!--
		<div hidden class="alert alert-info"  id="with_FB_link">
			<div class = "row">
				<div class="col-sm-12">
					<strong>Oye, ya tienes una cuenta connosotros!</strong> Que quieres hacer?
				</div>
			</div>
			<div class="row">
				<div class="col-sm-2">
					<a href="logout.php" class="btn btn-sm btn-info btn-fill">Conectarte</a>
				</div>
				<div class="col-sm-2">
					<a href="logout.php" class="btn btn-sm btn-info btn-fill">Desliar tu cuenta org@migo de tu cuenta Facebook</a>
				</div>
			</div>
		</div>
		!-->
	
		<!-- div hidden class="eco-panel rounded-panel small-panel green-1-bg" id="with_no_FB_link">
			<div class="panel-body">
				<p><strong>Oye, quieres liar tu cuenta <i>org@migo</i> con tu cuenta Facebook?</strong> Asi sera mas facil conectarte</p>
			</div>
			<div class="panel-footer green-1-bg">
				<div class="row">
					<div class="col-lg-6">
						<a href="logout.php" class="btn btn-primary btn-info btn-fill">Si</a> 
					</div>
					<div class="col-lg-6">
						<a href="logout.php" class="btn btn-primary btn-info btn-fill">No</a>
					</div>
				</div>
			</div>
		</div>
		!-->

		
	<div class="space-15"></div>
	
	<div class = "eco-panel rounded-panel large-panel white-bg">
		<form data-toggle="validator" role="form" method="POST" id="registerForm" onSubmit="adduser()"> 	
			<input type="hidden" class="form-control" id="facebookid" name="facebookid">
			<div class="row">
				<div class="col-sm-8 col-sm-offset-2">
					<div class="form-group has-feedback">
						<label for="inputUserEmail">Email</label>
						<div class="input-group">
							<span class="input-group-addon"><i class="glyphicon glyphicon-envelope"></i></span>
							<input
								type="email" class="form-control" 
								id="inputUserEmail" 
								name="email"
								placeholder="Dirección de correo electroníco" 	
								<?php if (isset($_SESSION['fb_access_token'])) {echo 'value="' . $user['email'] . '" disabled ';}?>
								required
								data-error="La dirección es incorecta o vacía"						
								data-remote="func_checkemail.php"
								data-remote-error="Una cuenta existe ya con este dirección de correo electrónico")
							>
							<span class="glyphicon form-control-feedback" aria-hidden="true"></span>
						</div>
						  <div class="help-block with-errors"></div>
					</div>
				</div>
			</div>
			<div class="row" >
				<div class="col-sm-8 col-sm-offset-2">
					<div class="form-group has-feedback">
						<label for="inputUserEmailCheck">Repetir el email</label>
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
				</div>
			</div>
			
			<div class="row">
				<div class="col-sm-8 col-sm-offset-2">
					<div class="form-group has-feedback">
					<label for="inputUserPassword">Contraseña</label>
						<div class="input-group">
							<span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
							<input 
							id="inputUserPassword" 
							type="password" 
							class="form-control" 
							data-minlength="6" 
							name="password" 
							placeholder="Contraseña" 
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
			<h4>Hablanos un poco de ti</h4>
			<div class="row">
				<div class="col-sm-8 col-sm-offset-2">
					<div class="form-group has-feedback">
						<label for="inputUserFirstName">Nombre(s)</label>
						<div class="input-group">
							<span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
							<input 
							type="text" 
							class="form-control" 
							id="inputUserFirstName" 
							data-error="Este campo no puede ser vacío"
							required 
							placeholder="Nombre(s)" 
							<?php if (isset($_SESSION['fb_access_token'])) {echo 'value="' . $user['first_name'] ;}?>					
							<span class="glyphicon form-control-feedback" aria-hidden="true"></span>
						</div>
						
						<div class="help-block with-errors"></div>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-sm-8 col-sm-offset-2">	
					<div class="form-group has-feedback">				
						<label for="inputUserLastName">Appelido(s)</label>
						<div class="input-group">
							<span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
							<input 
								type="text" 
								class="form-control" 
								id="inputUserLastName" 
								data-error="Este campo no puede ser vacío" 
								placeholder="Apellido(s)" 
										<?php if (isset($_SESSION['fb_access_token'])) {echo 'value="' . $user['last_name'] ;}?>	
								required
							>				
							<span class="glyphicon form-control-feedback" aria-hidden="true"></span>
						</div>
						<div class="help-block with-errors"></div>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-sm-4 col-sm-offset-2">

					<button type="submit" class="btn btn btn-primary" id="btn_submit">
					Enviar
					</button>
				</div>

				<div class="col-sm-4 col-sm-offset-2">
					<button type="submit" class="btn btn btn-primary btn-simple" id="btn_login" data-disable>
					Conectarse
					</button>
				</div>
			</div>
		</form>	
	</div>
</div>

<!-- Modal -->
<div class="modal fade" id="modal_1" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">	
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel"></h4>
      </div>
      <div class="modal-body">
				<p><strong>Oye, quieres liar tu cuenta <i>org@migo</i> con tu cuenta Facebook?</strong> Asi sera mas facil conectarte</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal" href="join.php">Si</button>
        <button type="button" class="btn btn-primary" data-dismiss="modal" href="join.php" >No</button>
      </div>
    </div>
  </div>	
</div>
	<!-- Modal -->
<div class="modal fade" id="modal_2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">	
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel"></h4>
      </div>
      <div class="modal-body">
				<p><strong>Oye, ya tienes una cuenta connosotros y esta liada con tu Facebook!</strong> Que quieres hacer?</div></p>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal" href="join.php">Conectarte</button>
        <button type="button" class="btn btn-primary" data-dismiss="modal" href="join.php" >Desliar tu cuenta de Facebook</button>
      </div>
    </div>
  </div>	
</div>

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
					Solo utilisamos Facebook para facilitarte la vida, nunca para utilisar tus datos personales.<br>
					Te permite crear tu cuenta mas rapido porque recuperamos (SOLO) tu nombre, apellido, email y foto de perfil<br>
					Si tu cuenta org@migos esta liada con tu cuenta Facebook, solo necesitas estar conectado al Face para entrar a nuestra plataforma.<br>
					Necesitas ingresar tambien una contraseña para tu cuenta org@migos para que puedas tambien entrar a la plataforma sin tu cuenta Facebook.
				</p>
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
</html>
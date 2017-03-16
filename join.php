<?php 
	/*-------------------------------------------------------------------------------------------------
		Login with Facebook 
		Uses Facebook SDK for JavaScript (see <scripts>)
	-------------------------------------------------------------------------------------------------*/	
	require_once 'functions.php'; 

?>
<!doctype html>
<html lang="en">
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
    <!--     Font Awesome     -->
    <link href="http://netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css" rel="stylesheet">
    <link href='http://fonts.googleapis.com/css?family=Grand+Hotel' rel='stylesheet' type='text/css'>
</head>
<body>

<div id="fb-root"></div>
<script>
  window.fbAsyncInit = function() {
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
   
	function disableRegisterForm(){
		var form = document.getElementById("registerForm");
		var elements = form.elements;
		for (var i = 0, len = elements.length; i < len; ++i) {
			elements[i].readOnly = true;
		}
		document.getElementById("btn_submit").disabled = true;
		document.getElementById("btn_login").disabled = true;
   }
   
   function enableRegisterForm(){
		var form = document.getElementById("registerForm");
		
		var elements = form.elements;
		for (var i = 0, len = elements.length; i < len; ++i) {
			elements[i].readOnly = false;
		}
		document.getElementById("btn_submit").disabled = false;
		document.getElementById("btn_login").disabled = false;
   }
   
	function refreshFB(){
		console.log('-- refreshFB');
		
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
					url: 'func_checkUser.php',
					type: 'POST',
					data: {id:uid,email:response.email},
					
					success: function(data) {
						
						console.log(data); // Inspect this in your console
						 obj = JSON.parse(data);
;
						if ((obj.ismember === "true") && (obj.isFB === "true")){
							// user is currently connected with Facebook
							// user already has an account and is linked with Facebook
							// disable the whole form 
							// show alert <div> to propose options to user [start session from Facebook login or unlink account and facebook}
							console.log('*** isMember AND isFB ***');
							
							document.getElementById('with_FB_link').hidden=false;
							document.getElementById('with_no_FB_link').hidden=true;
							
							disableRegisterForm();
		
						}
						
						else if ((obj.ismember === "true") && (obj.isFB === "false")){
							// user is currently connected with Facebook
							// user already has an account with same email as Facebook but account is not linked with Facebook
							// disable the whole form 
							// show alert <div> to propose options to user to link is account with Facebook
							console.log('*** isMember AND NOT isFB ***');
							document.getElementById('with_FB_link').hidden=true;
							document.getElementById('with_no_FB_link').hidden=false;
							disableRegisterForm();
						}
						else {
							// user is currently connected with Facebook and has no account here (no email, no facebookid matching)
							console.log('*** NOT isMember***');
							document.getElementById('with_FB_link').hidden=true;
							document.getElementById('with_no_FB_link').hidden=true;
							enableRegisterForm();
						}
				}
						
				});
			
				console.log(checkUser);
				document.getElementById('inputUserFirstName').value = response.first_name;
				document.getElementById('inputUserLastName').value = response.last_name;
				document.getElementById('inputUserEmail').value = response.email;
				document.getElementById('inputUserEmailCheck').value = response.email;
				document.getElementById('inputUserEmail').disabled=true;
				document.getElementById('inputUserEmailCheck').disabled=true;
				
				document.getElementById('fbWelcome').hidden=false;
				document.getElementById('fbWelcome').innerHTML='<h5>Hola org@migo ' + response.name + '</h5>';
				document.getElementById('fbPhoto').hidden=false;
				document.getElementById('fbPhoto').innerHTML='<img src="https://graph.facebook.com/' + response.id + '/picture?width=120" alt="Circle Image" class="img-circle img-responsive" width="120" height="120">';				
			});
			
		} else if (response.status === 'not_authorized') {
			// the user is logged in to Facebook, 
			// but has not authenticated your app
			console.log('NOT AUTHORIZED');
			document.getElementById('with_no_FB_link').hidden=true;
			document.getElementById('with_FB_link').hidden=true;
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
			console.log('NOT LOGGED');
			document.getElementById('with_no_FB_link').hidden=true;
			document.getElementById('with_FB_link').hidden=true;
			
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
   
</script>

<?php include 'header.php'; ?>

<div class="eco-main" style="eco-color" >
	<div class="container eco-container" id="section3" style="padding-top : 100px;" >
		<div class="row">
			<div class="col-sm-10 col-sm-offset-1">
				<h1 class="text-center">
					Abrir una cuenta<br>
					<small class="subtitle">
						La inscripcion es sin compromiso!<br>Puedes decidir que y cuando compras segun tus envias.
					</small>
				</h1>	
			</div>
		</div>				
			<div class="panel panel-primary">
				 <div class="panel-heading">Conecarse co Facebook (o no)</div>
				 <div class="panel-body">
					<div class="row ">
						<div class="col-sm-4" hidden id="fbPhoto"></div>	
						<div class="col-sm-4" hidden id="fbWelcome"></div>
						<div class="col-sm-4">
							<div class="fb-login-button " onlogin="refreshFB()" data-max-rows="1" data-size="xlarge" data-show-faces="false" data-auto-logout-link="true"></div>
						</div>	
					</div>
					<div class="panel-group" id="accordion">
			<div class="panel panel-default">
				<div class="panel-heading">
					<h4 class="panel-title">
						<a data-toggle="collapse" href="#collapse1">
							Que hacemos con Facebook?
						</a>
					</h4>
				</div>
				<div id="collapse1" class="panel-collapse collapse">
					<div class="panel-body">
						<p class="text-muted"  style=" font-size: 14px; line-height: 1;">
							Solo utilisamos Facebook para facilitarte la vida, nunca para utilisar tus datos personales.<br>
							Te permite crear tu cuenta mas rapido porque recuperamos (SOLO) tu nombre, apellido, email y foto de perfil<br>
							Si tu cuenta org@migos esta liada con tu cuenta Facebook, solo necesitas estar conectado al Face para entrar a nuestra plataforma.<br>
							Necesitas ingresar tambien una contraseña para tu cuenta org@migos para que puedas tambien entrar a la plataforma sin tu cuenta Facebook.
						</p>
					</div>
				</div>
			</div>
		</div>	
				</div>
			</div>
	
		<div class="space-15"></div>
		<div class="alert alert-info" hidden id="with_FB_link">
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
		
		<div class="alert alert-info" hidden id="with_no_FB_link">
				<div class = "row">
					<div class="col-sm-12">
						<strong>Oye, quieres liar tu cuenta <i>org@migo</i> con tu cuenta Facebook?</strong> Asi sera mas facil conectarte
					</div>
				</div>
				<div class="row">
					<div class="col-sm-2">
						<a href="logout.php" class="btn btn-primary btn-info btn-fill">Si</a>
					</div>
					<div class="col-sm-2">
						<a href="logout.php" class="btn btn-primary btn-info btn-fill">No</a>
					</div>
				</div>
		</div>
		
		
		
		<div class="space-15"></div>
		<form role="form" id="registerForm"> 
			<div class="row">
				<div class="col-sm-4 col-sm-offset-2">
					<div class="form-group">
						<label for="inputUserFirstName">Nombre(s)</label>
						<div class="input-group">
							<span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
							<input type="text" class="form-control" id="inputUserFirstName" placeholder="Nombre(s)" value="<?php echo $_SESSION['FIRSTNAME'] ?>">  
						</div>
					</div>
				</div>
				<div class="col-sm-4">
					<div class="form-group">
						<label for="inputUserLastName">Appelido(s)</label>
						<div class="input-group">
							<span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
							<input type="text" class="form-control" id="inputUserLastName" placeholder="Apellido(s)" value="<?php echo $_SESSION['LASTNAME'] ?>">		
						</div>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-sm-8 col-sm-offset-2">
					<div class="form-group">
						<label for="inputUserEmail">Email</label>
						<div class="input-group">
							<span class="input-group-addon"><i class="glyphicon glyphicon-envelope"></i></span>
							<input  type="email" class="form-control" id="inputUserEmail" placeholder="Direccion de correo electronico valido" value="<?php echo $_SESSION['EMAIL']; ?>" >
						</div>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-sm-8 col-sm-offset-2">
					<div class="form-group">
						<label for="inputUserEmailCheck">Repetir el email</label>
						<div class="input-group">
							<span class="input-group-addon"><i class="glyphicon glyphicon-envelope"></i></span>
							<input <?php if ($_SESSION['FBID']) { echo "disabled";} ?> type="email" class="form-control" id="inputUserEmailCheck" placeholder="Confirma el email" value="<?php echo $_SESSION['EMAIL']; ?>">
						</div>
					</div>
				</div>
			</div>
			
			<div class="row">
				<div class="col-sm-8 col-sm-offset-2">
					<div class="form-group">
					<label for="inputUserPassword">Contraseña</label>
						<div class="input-group">
							<span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
							<input id="inputUserPassword" type="password" class="form-control" name="password" placeholder="Contraseña">
						</div>
					</div>				  
				</div>
			</div>
				
			<div class="row">
				<div class="col-sm-8 col-sm-offset-2">
					<div class="form-group">
						<label for="inputUserPasswordCheck">Repetir la contraseña</label>
						<div class="input-group">
							<span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
							<input type="password" class="form-control" id="inputUserPasswordCheck" placeholder="Confirma la contraseña">
						</div>
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
					<button type="submit" class="btn btn btn-primary btn-simple" id="btn_login">
					Conectarse
					</button>
				</div>
			</div>
		</form>	
	</div>	
</div>		
<?php include 'footer.php'; ?>
</body>

    <script src="jquery/jquery-1.10.2.js" type="text/javascript"></script>
	<script src="assets/js/jquery-ui-1.10.4.custom.min.js" type="text/javascript"></script>

	<script src="bootstrap3/js/bootstrap.js" type="text/javascript"></script>


</html>
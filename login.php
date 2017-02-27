<?php 
	/*-------------------------------------------------------------------------------------------------
		Login with Facebook 
		Uses Facebook SDK for JavaScript (see <scripts>)
	-------------------------------------------------------------------------------------------------*/	
	/*require_once 'config.php'; */
	require_once __DIR__ . '/vendor/autoload.php';
	
	if (!session_id()) {
		session_start();
	}
	var_dump ($_SESSION);
	$fb = new Facebook\Facebook([
  'app_id' => '1465837763458763', // Replace {app-id} with your app id
  'app_secret' => '6b10eb5ee969eda762b07b478f2414c7',
  'default_graph_version' => 'v2.8',
  ]);
var_dump ($_SESSION);
$helper = $fb->getRedirectLoginHelper();

$permissions = ['email']; // Optional permissions
$loginUrl = $helper->getLoginUrl('http://ailid.synology.me:8888/fb-callback.php', $permissions);

?>

?> 
<!doctype html>
<html lang="en">
<head>
	<meta charset="utf-8" />
	<link rel="apple-touch-icon" sizes="76x76" href="assets/img/apple-icon.png">
	<link rel="icon" type="image/png" href="assets/img/favicon.png">	
	
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
	<title>Orgamigos - Login</title>

	<meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0' name='viewport' />
    <meta name="viewport" content="width=device-width" />
	
    <link href="bootstrap3/css/bootstrap.css" rel="stylesheet" />
	<link href="css/login.css" rel="stylesheet" />  
    
    <!--     Font Awesome     -->
    <link href="bootstrap3/css/font-awesome.css" rel="stylesheet">
    <link href='http://fonts.googleapis.com/css?family=Grand+Hotel' rel='stylesheet' type='text/css'>
</head>
<body>



<div id="fb-root"></div>
 <script>
  // This is called with the results from from FB.getLoginStatus().
  function statusChangeCallback(response) {
    console.log('statusChangeCallback');
    console.log(response);
    // The response object is returned with a status field that lets the
    // app know the current login status of the person.
    // Full docs on the response object can be found in the documentation
    // for FB.getLoginStatus().
    if (response.status === 'connected') {
      // Logged into your app and Facebook.
      testAPI();
    } else if (response.status === 'not_authorized') {
      // The person is logged into Facebook, but not your app.
      document.getElementById('status').innerHTML = 'Please log ' +
        'into this app.';
    } else {
      // The person is not logged into Facebook, so we're not sure if
      // they are logged into this app or not.
      document.getElementById('status').innerHTML = 'Please log ' +
        'into Facebook.';
    }
  }

  // This function is called when someone finishes with the Login
  // Button.  See the onlogin handler attached to it in the sample
  // code below.
  function checkLoginState() {
    FB.getLoginStatus(function(response) {
      statusChangeCallback(response);
    });
  }

  window.fbAsyncInit = function() {
  FB.init({
    appId      : '1465837763458763',
    cookie     : true,  // enable cookies to allow the server to access 
                        // the session
    xfbml      : true,  // parse social plugins on this page
    version    : 'v2.8' // use graph api version 2.8
  });

  // Now that we've initialized the JavaScript SDK, we call 
  // FB.getLoginStatus().  This function gets the state of the
  // person visiting this page and can return one of three states to
  // the callback you provide.  They can be:
  //
  // 1. Logged into your app ('connected')
  // 2. Logged into Facebook, but not your app ('not_authorized')
  // 3. Not logged into Facebook and can't tell if they are logged into
  //    your app or not.
  //
  // These three cases are handled in the callback function.

  FB.getLoginStatus(function(response) {
    statusChangeCallback(response);
  });

  };

  // Load the SDK asynchronously
  (function(d, s, id) {
    var js, fjs = d.getElementsByTagName(s)[0];
    if (d.getElementById(id)) return;
    js = d.createElement(s); js.id = id;
    js.src = "//connect.facebook.net/en_US/sdk.js";
    fjs.parentNode.insertBefore(js, fjs);
  }(document, 'script', 'facebook-jssdk'));

  // Here we run a very simple test of the Graph API after login is
  // successful.  See statusChangeCallback() for when this call is made.
  function testAPI() {
    console.log('Welcome!  Fetching your information.... ');
    FB.api('/me', function(response) {
      console.log(response);
	  console.log('Successful login for: ' + response.name);
      document.getElementById('status').innerHTML =
        'Thanks for logging in, ' + response.name + '!';
    });
  }
</script>

</script>

<div class="container">
  <div class="row">

    <div class="main">

      <h3>Por favor ingresate o <a href="#">Inscribete</a></h3>
      <div class="row">
        <div class="col-xs-6 col-sm-6 col-md-6">
			<!--
				Below we include the Login Button social plugin. This button uses
			  the JavaScript SDK to present a graphical Login button that triggers
			  the FB.login() function when clicked.
			-->

<fb:login-button scope="public_profile,email" onlogin="checkLoginState();">
</fb:login-button>

<div id="status">
</div>

		 <!--php
		 if ($_SESSION['fb_access_token'])
		 {	 
			$fb->setDefaultAccessToken($_SESSION['fb_access_token']);

			try {
			  $response = $fb->get('/me');
			  $userNode = $response->getGraphUser();
			} catch(Facebook\Exceptions\FacebookResponseException $e) {
			  // When Graph returns an error
			  echo 'Graph returned an error: ' . $e->getMessage();
			  exit;
			} catch(Facebook\Exceptions\FacebookSDKException $e) {
			  // When validation fails or other local issues
			  echo 'Facebook SDK returned an error: ' . $e->getMessage();
			  exit;
			}

			echo 'Logged in as ' . $userNode->getName();
		 }
		 else
		 {
			echo 'NOT CONNECTED';
		 }
		 ?--> 
		 <!--
		  <a href="<?php echo htmlspecialchars($loginUrl)?>" id="facebook_btn" class="btn btn-lg btn-primary btn-block">Connecta con Facebook</a>
		  <a href="' <?php echo htmlspecialchars($loginUrl)?> '">Log in with Facebook!</a>';
		  <div class="fb-login-button" data-max-rows="1" data-size="large" data-show-faces="false" data-auto-logout-link="true"></div>
        !-->
		</div>
        <div class="col-xs-6 col-sm-6 col-md-6">
          <a href="#" class="btn btn-lg btn-info btn-block">Google</a>
        </div>
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
          <a class="pull-right" href="#">Olvidaste la contrasena?</a>
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
</div>
</body>

    <script src="jquery/jquery-1.10.2.js" type="text/javascript"></script>
	<script src="assets/js/jquery-ui-1.10.4.custom.min.js" type="text/javascript"></script>

	<script src="bootstrap3/js/bootstrap.js" type="text/javascript"></script>


</html>
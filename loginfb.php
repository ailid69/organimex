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

?> 

<!doctype html>
<html lang="en">
<head>
	<meta charset="utf-8" />
	<link rel="apple-touch-icon" sizes="76x76" href="img/apple-icon.png">
	<link rel="icon" type="image/png" href="img/favicon-16x16.png">	
	
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
	<title>OrganiMex - Cortar circuitos de distribuciones</title>

	<meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0' name='viewport' />
    <meta name="viewport" content="width=device-width" />
	
    <link href="bootstrap3/css/bootstrap.css" rel="stylesheet" />
    <link href="bootstrap3/css/font-awesome.css" rel="stylesheet" />
    
	<link href="assets/css/gsdk.css" rel="stylesheet" />   
    <link href="assets/css/demo.css" rel="stylesheet" /> 

    <!--     Font Awesome     -->
    <link href="http://netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css" rel="stylesheet">
    <link href='http://fonts.googleapis.com/css?family=Grand+Hotel' rel='stylesheet' type='text/css'>
  
</head>

<body>

<script>
  window.fbAsyncInit = function() {
    FB.init({
      appId      : '1465837763458763',
      xfbml      : true,
      version    : 'v2.8'
    });
    FB.AppEvents.logPageView();
	FB.getLoginStatus(function(response) {
  if (response.status === 'connected') {
	  alert("conected");
    // the user is logged in and has authenticated your
    // app, and response.authResponse supplies
    // the user's ID, a valid access token, a signed
    // request, and the time the access token 
    // and signed request each expire
    var uid = response.authResponse.userID;
    var accessToken = response.authResponse.accessToken;
  } else if (response.status === 'not_authorized') {
    alert("non auth");
	// the user is logged in to Facebook, 
    // but has not authenticated your app
  } else {
	  alert("not logged");
    // the user isn't logged in to Facebook.
  }
 });
  };
  
  
 
  (function(d, s, id){
     var js, fjs = d.getElementsByTagName(s)[0];
     if (d.getElementById(id)) {return;}
     js = d.createElement(s); js.id = id;
     js.src = "//connect.facebook.net/es_LA/sdk.js";
     fjs.parentNode.insertBefore(js, fjs);
   }(document, 'script', 'facebook-jssdk'));
   
    function checkFacebookLogin() {
    alert('checkFacebookLogin');
	FB.api('/me', function(response) {
        alert("Name: "+ response.name + "\nFirst name: "+ response.first_name + "ID: "+response.id);
    });
   
	};
	
	

</script>

<div id="fb-root"></div>

<?php 
$fb = new Facebook\Facebook([
  'app_id' => '1465837763458763', // Replace {app-id} with your app id
  'app_secret' => '6b10eb5ee969eda762b07b478f2414c7',
  'default_graph_version' => 'v2.8',
  ]);

$helper = $fb->getRedirectLoginHelper();

$permissions = ['email']; // Optional permissions
$loginUrl = $helper->getLoginUrl('http://ailid.synology.me:8888/fb-callback.php', $permissions);

//echo '<a href="' . htmlspecialchars($loginUrl) . '">Log in with Facebook!</a>';

echo '<a href="' . htmlspecialchars($loginUrl) . '">Log in with Facebook!</a>';

?>
<!--
<div class="fb-login-button" data-max-rows="1" data-size="large" data-show-faces="false" data-auto-logout-link="true" onlogin="checkFacebookLogin()" onload="checkFacebookLogin()";></div>
-->

</body>


</html>
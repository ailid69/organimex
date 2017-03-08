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
	'app_id' => '1465837763458763',
	'app_secret' => '6b10eb5ee969eda762b07b478f2414c7',
	'default_graph_version' => 'v2.8',
	]);

$helper = $fb->getRedirectLoginHelper();
$permissions = ['email']; 

try {
 
 $accessToken = $helper->getAccessToken();
 
  var_dump($access_token);
} catch(Facebook\Exceptions\FacebookResponseException $e) {
  // When Graph returns an error
  echo 'Graph returned an error: ' . $e->getMessage();
  exit;
} catch(Facebook\Exceptions\FacebookSDKException $e) {
  // When validation fails or other local issues
  echo 'Facebook SDK returned an error: ' . $e->getMessage();
  exit;
}

if (! isset($accessToken)) {
  $loginUrl = $helper->getLoginUrl(WEBSITE . '/fb-config.php',$permissions);
  
	header("Location: ".$loginUrl);
}

  if ($helper->getError()) {
    header('HTTP/1.0 401 Unauthorized');
    echo "Error: " . $helper->getError() . "\n";
    echo "Error Code: " . $helper->getErrorCode() . "\n";
    echo "Error Reason: " . $helper->getErrorReason() . "\n";
    echo "Error Description: " . $helper->getErrorDescription() . "\n";
	}


// The OAuth 2.0 client handler helps us manage access tokens
$oAuth2Client = $fb->getOAuth2Client();

// Get the access token metadata from /debug_token
//$tokenMetadata = $oAuth2Client->debugToken($accessToken);
//echo '<h3>Metadata</h3>';
//var_dump($tokenMetadata);

// Validation (these will throw FacebookSDKException's when they fail)
//$tokenMetadata->validateAppId('1465837763458763'); // Replace {app-id} with your app id
// If you know the user ID this access token belongs to, you can validate it here
//$tokenMetadata->validateUserId('123');
//$tokenMetadata->validateExpiration();

if (! $accessToken->isLongLived()) {
  // Exchanges a short-lived access token for a long-lived one
  try {
    $accessToken = $oAuth2Client->getLongLivedAccessToken($accessToken);
  } catch (Facebook\Exceptions\FacebookSDKException $e) {
    echo "<p>Error getting long-lived access token: " . $helper->getMessage() . "</p>\n\n";
    exit;
  }

//  echo '<h3>Long-lived</h3>';
//  var_dump($accessToken->getValue());
}



// User is logged in with a long-lived access token.
// You can redirect them to a members-only page.

	$fb->setDefaultAccessToken($accessToken);
// Graph api request for user data
  $response = $fb->get('/me?fields=id,name,first_name,last_name,email');


  // get response
  $graphObject = $response->getGraphObject();
     	$fbid = $graphObject->getProperty('id');              // To Get Facebook ID
 	    $fbfullname = $graphObject->getProperty('name'); // To Get Facebook full name
		$fbfirstname = $graphObject->getProperty('first_name'); // To Get Facebook full name
	    $fblastname = $graphObject->getProperty('last_name'); // To Get Facebook full name
	    
	    $femail = $graphObject->getProperty('email');    // To Get Facebook email ID
	/* ---- Session Variables -----*/
	    $_SESSION['FBTOKEN'] = (string) $accessToken;
		$_SESSION['FBID'] = $fbid;           
        $_SESSION['FULLNAME'] = $fbfullname;
		$_SESSION['FIRSTNAME'] = $fbfirstname;
		$_SESSION['LASTNAME'] = $fblastname;
	    $_SESSION['EMAIL'] =  $femail;
		checkuser($connection,$fbid,$fbfullname,$femail);
var_dump($graphObject);
//header('Location: '. WEBSITE . '/login.php');
header('Location: '. WEBSITE . $_SERVER['REQUEST_URI']);

?> 



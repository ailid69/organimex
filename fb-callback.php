<?php
require_once 'config.php';
require_once __DIR__ . '/vendor/autoload.php';

/*
echo '<br><br> ***** GET BEFORE ANY FACEBOOK SHIT IN THE CALL BACK *****<br><br>';
print_r($_GET);
echo '***** ************************** *****';


echo '<br><br>***** SESSION BEFORE ANY FACEBOOK SHIT IN THE CALL BACK *****<br><br>';
print_r($_SESSION);
echo '***** ************************** *****';
*/

$myredirection = $_SESSION['from_page'] ;

$fb = new Facebook\Facebook([
		'app_id' => APP_ID, // Replace {app-id} with your app id
		'app_secret' => APP_SECRET,
		'default_graph_version' => 'v2.8',
		 'persistent_data_handler'=>'session'
  ]);

$helper = $fb->getRedirectLoginHelper();

try {
  $accessToken = $helper->getAccessToken();
} catch(Facebook\Exceptions\FacebookResponseException $e) {
  // When Graph returns an error
  echo 'Graph returned an error: ' . $e->getMessage();
  exit;
} catch(Facebook\Exceptions\FacebookSDKException $e) {
  // When validation fails or other local issues
  $error =  'Facebook SDK returned an error: ' . $e->getMessage();
  header ('Location: ' . $myredirection . '&fberror?error="' . $error . '"' );
  exit;
}

if (! isset($accessToken)) {
  if ($helper->getError()) {
    /*header('HTTP/1.0 401 Unauthorized');
    echo "Error: " . $helper->getError() . "\n";
    echo "Error Code: " . $helper->getErrorCode() . "\n";
    echo "Error Reason: " . $helper->getErrorReason() . "\n";
    echo "Error Description: " . $helper->getErrorDescription() . "\n";*/
	
	$error =  'Facebook no dío el permiso para conectarte<br>Error: ' . $helper->getError() . '<br>Error Code: ' . $helper->getErrorCode() . '<br>Error Reason: ' . $helper->getErrorReason() .  '<br>Error Description: ' . $helper->getErrorDescription();
	header ('Location: ' . $myredirection . '&fberror?error="' . $error. '"' );
	
  } else {
    //header('HTTP/1.0 400 Bad Request');
    //echo 'Bad request';
	$error =  'Hubó un problema con la conección a Facebook';
	header ('Location: ' . $myredirection . '&fberror?error="' . $error . '"' );
  }
  exit;
}
/*
// Logged in
echo '<h3>Access Token</h3>';
var_dump($accessToken->getValue());
*/
// The OAuth 2.0 client handler helps us manage access tokens
$oAuth2Client = $fb->getOAuth2Client();

// Get the access token metadata from /debug_token
$tokenMetadata = $oAuth2Client->debugToken($accessToken);
/*echo '<h3>Metadata</h3>';
var_dump($tokenMetadata);
*/
// Validation (these will throw FacebookSDKException's when they fail)
$tokenMetadata->validateAppId(APP_ID); // Replace {app-id} with your app id
// If you know the user ID this access token belongs to, you can validate it here
//$tokenMetadata->validateUserId('123');
$tokenMetadata->validateExpiration();

if (! $accessToken->isLongLived()) {
  // Exchanges a short-lived access token for a long-lived one
  try {
    $accessToken = $oAuth2Client->getLongLivedAccessToken($accessToken);
  } catch (Facebook\Exceptions\FacebookSDKException $e) {
    //echo "<p>Error getting long-lived access token: " . $helper->getMessage() . "</p>\n\n";
	
	$error =  'Error getting long-lived access token: ' . $helper->getMessage();
	header ('Location: ' . $myredirection . '&fberror?error="' . $error . '"' );
	
    exit;
  }
/*
  echo '<h3>Long-lived</h3>';
  var_dump($accessToken->getValue());*/
}

$_SESSION['fb_access_token'] = (string) $accessToken;

// User is logged in with a long-lived access token.
// You can redirect them to a members-only page.
//header('Location: https://example.com/members.php');
//header('Location: '. WEBSITE . $_SERVER['REQUEST_URI']);

unset( $_SESSION[ 'from_page' ] );
header ('Location: ' . $myredirection);



?>
<?php
session_start();
// added in v4.0.0
require_once __DIR__ . '/../vendor/autoload.php';

use Facebook\FacebookSession;
use Facebook\FacebookRedirectLoginHelper;
use Facebook\GraphUser;
use Facebook\FacebookRequestException;
echo bite;
$fb = new Facebook\Facebook([
  'app_id' => '1465837763458763', // Replace {app-id} with your app id
  'app_secret' => '6b10eb5ee969eda762b07b478f2414c7',
  'default_graph_version' => 'v2.8',
  ]);
$helper = $fb->getRedirectLoginHelper('http://ailid.synology.me:8888/fbloginTEST/fbconfig.php');
try{ 
 $session = $helper->getAccessToken();
  var_dump($session);
} catch(FacebookRequestException $ex) {
} catch(\Exception $ex) {
}
// see if we have a session
if ( isset( $session ) ) {
  // graph api request for user data
  $response = $fb->get('/me', $session);
  // get response
  $graphObject = $response->getGraphObject();
     	$fbid = $graphObject->getProperty('id');              // To Get Facebook ID
 	    $fbfullname = $graphObject->getProperty('name'); // To Get Facebook full name
	    $femail = $graphObject->getProperty('email');    // To Get Facebook email ID
	/* ---- Session Variables -----*/
	    $_SESSION['FBID'] = $fbid;           
        $_SESSION['FULLNAME'] = $fbfullname;
	    $_SESSION['EMAIL'] =  $femail;
  //checkuser($fuid,$ffname,$femail);
  header("Location: index.php");
} else {
  $loginUrl = $helper->getLoginUrl('http://ailid.synology.me:8888/fbloginTEST/fbconfig.php');
 header("Location: ".$loginUrl);
}
?>
?>
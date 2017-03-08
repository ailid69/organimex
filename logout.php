<?php 
require_once 'functions.php'; 
session_start();
session_unset();
    $_SESSION['FBTOKEN'] = NULL;
	$_SESSION['FBID'] = NULL;
    $_SESSION['FULLNAME'] = NULL;
    $_SESSION['EMAIL'] =  NULL;
	$_SESSION['FBRLH_state']=NULL;
header ('Location: '.$_SERVER['HTTP_REFERER']); 

?>

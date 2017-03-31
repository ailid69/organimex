<?php 
require_once 'config.php'; 
require_once 'class.user.php';
$user = new USER();

/*if(!$user->is_logged_in())*/
{
 $user->logout(); 
 $user->redirect('login.php?logout');
}
/*
if($user->is_logged_in()!="")
{
 $user->logout(); 
 $user->redirect('login.php?logout');
}*/
?>

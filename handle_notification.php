<?php 
require_once 'config.php';
 
$info_show = false;
$info_msg ="";
$err_show = false;
$err_msg="";
 
if (isset($_GET['usercreated'])){ 
	$info_show = true;
	$info_msg ="	<strong>La creación de tu cuenta fue excitosa!</strong>
								<br> Te acabamos de mandar un correo.
								<br>Por favor dale click al enlace de confimación en el correo para terminar con la creacion de tu cuenta. 
							";
 }
elseif (isset($_GET['activationsuccess'])){
	$info_show = true;
	$info_msg ="	<strong>La activación de tu cuenta fue exitosa!</strong>
								<br> Ahora puedes iniciar una sesíon y inscribirte a la eco-casa mas cercana para participar a las proximas ventas.
								<br>Bienvenido!
							";
 }
 
elseif (isset($_GET['logout'])){
	$info_show = true;
	$info_msg ="	<strong>Eres desconectado</strong>		
							";
 }
 
 elseif (isset($_GET['wrongpass'])){
	$err_show = true;
	$err_msg =	"	<strong>La contraseña que entraste no es la buena</strong>
				<br> Intenta conectarte otra vez o sino puedes reinicializar tu contraseña.
			";
 }
 elseif (isset($_GET['wronguser'])){
	$err_show = true;
	$err_msg =	"	<strong>El usario que entraste no es conocido</strong>
				<br> Intenta conectarte de nuevo o sino puedes crear una nueva cuenta.
			";
 }
 
   elseif (isset($_GET['inactive'])){
	$err_show = true;
	$err_msg =	"	<strong>Tu cuenta no esta activada todavía</strong>
				<br> Checka bien to Inbox y click en el enlace para activar tu cuenta. 
				<br> Si no encontraste el correo de activación que te enviamos, verifica en tus Spams o puedes genrar un nuevo correo de activacíon.
			";
 }
 
 elseif (isset($_GET['forgetpass'])){
	$info_show= true;
	$info_msg = "<strong>Enviamos un correo a  " . $_GET['email'] . ".</strong><br>
				Click en el enlace contenido en el correo para generar una nueva contraseña.
				";
  }
   
 elseif (isset($_GET['verifymissingparam'])){
	$err_show = true;
	$err_msg ="	<strong>Algo malo pasó con tu enlace de verificacíon</strong>
								<br> Parece que el enlace de verificación que te envaimos por correo no esta corecto.
								<br>Por favor conectate a tu cuenta y selectiona la opción de reenviar el correo de verificación.
								<br>Disculpa la molestia.							
							"; 
 }
 

 elseif (isset($_GET['alreadyactivated'])){
	$info_show = true;
	$info_msg ="	<strong>Tu cuenta ya esta activada</strong>
								<br>Puedes iniciar una sesíon y inscribirte al la eco-case mas cercana para paratipar a las proximas ventas.
								<br>Bienvenido!

							"; 
 }
 elseif (isset($_GET['tokennotfound'])){
	$err_show = true;
	$err_msg ="	<strong>Algo malo pasó con tu enlace de verificacíon</strong>
								<br> Parece que el enlace de verificación que te envaimos por correo no esta corecto.
								<br>Por favor conectate a tu cuenta y selectiona la opción de reenviar el correo de verificación.
								<br>Disculpa la molestia.		
							"; 
 }
 elseif (isset($_GET['emailalreadyused'])){
	$err_show = true;
	$err_msg ="	<strong>Lo siento !</strong> ya se registró un usario con este email :<strong> " . $_GET['email'] . "</strong><br>Inténtalo con otro.    </div>";
			; 
 }
 elseif (isset($_GET['emailnotfound'])){
	$err_show = true;
	$err_msg ="	<strong>Lo siento pero no encontramos una cuenta registrada con este email <strong> " . $_GET['email'] . "</strong><br>Inténtalo con otro.    </div>";			; 
 }
 
 
if ($info_show == true){
	echo '	<div  class="alert alert-info alert-fixed"  id="myalertinfo" >
				<button type="button" class="close" data-dismiss="alert">&times;</button>'
				. $info_msg . '
			</div>';	
}
if ($err_show == true){
	echo '	<div  class="alert alert-danger alert-fixed"  id="myalerterror" >
				<button type="button" class="close" data-dismiss="alert">&times;</button>'
				. $err_msg . '
			</div>';
}	

 
 
 ?>
<?php
require_once 'class.user.php';
$user = new USER();
if(!$user_home->is_logged_in())
{
 exit;
}

$stmt = $user_home->runQuery("SELECT u.firstName, u.lastName, h.name, h.type, h.UID, u.UID FROM `ecocasa_members` AS asso INNER JOIN `ecocasa` AS h ON h.UID = asso.ecocasaid INNER JOIN `users` AS u ON u.UID = asso.userid WHERE u.UID=:uid");
$stmt->execute(array(":uid"=>$_SESSION['userSession']));
//$row = $stmt->fetch(PDO::FETCH_ASSOC);
$nbHome = $stmt->rowCount();

?>
<div id="navbar-full-top">
<div id="navbar-top">
	<nav class=" navbar navbar-ct-blue navbar-fixed-top" role="navigation">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="container">
				<div class="navbar-header">
					<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navbar-collapse">
						<span class="sr-only">Toggle navigation</span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
					</button>
					<!--a class="navbar-brand" href="index.php">Org@migos</a-->
				</div>

				<!-- Collect the nav links, forms, and other content for toggling -->
				<div class="collapse navbar-collapse" id="navbar-collapse">
					<?php if ($nbHome != 0) { ?>
					<ul class="nav navbar-nav">
						<li class="dropdown">
							  <a href="#" class="dropdown-toggle" data-toggle="dropdown">	
								<span class="glyphicon glyphicon-home" aria-hidden="true"></span>
								<b class="caret"></b>
							  </a>
							  <ul class="dropdown-menu" role="menu" aria-labelledby="homes">
								<?php while ($dbdata = $stmt->fetch(PDO::FETCH_ASSOC)) { ?>
									<li role="presentation"><a role="menuitem" tabindex="-1"><?php echo $dbdata['name'];?></a></li>
								<?php } ?>
							 </ul>
						</li>
					</ul>
					<?php } ?>

					<ul class="nav navbar-nav navbar-right">
						
						
						<div class="btn-group">
							<button class="btn btn-primary btn-fill" type="button" >
								<span class="glyphicon glyphicon-user" aria-hidden="true"></span>
							</button>
							<button class="btn btn-primary btn-fill"" type="button" >
								<?php echo '  ' . $_SESSION['userName'] ?>
							</button>
							<button type="button" class="btn btn-primary btn-fill" dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
								<span class="caret"></span>
								<span class="sr-only">Toggle Dropdown</span>
							 </button>
 

							  <ul class="dropdown-menu" role="menu" aria-labelledby="useroption">
									<li class="dropdown-header" role="presentation" tabindex="-1"><strong><?php echo $_SESSION['userName']; ?></strong></li>
									<li role="presentation"><a role="menuitem" tabindex="-1"><span class="glyphicon glyphicon-user" aria-hidden="true"></span>&nbsp;&nbsp;&nbsp;Identidad</a></li>
									<li role="presentation"><a role="menuitem" tabindex="-1"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>&nbsp;&nbsp;&nbsp;Cuenta</a></li>
									<li role="presentation"><a role="menuitem" tabindex="-1"><span class="glyphicon glyphicon-home" aria-hidden="true"></span>&nbsp;&nbsp;&nbsp;Eco-lugares</a></li>
									<li role="presentation"><a role="menuitem" tabindex="-1"><span class="glyphicon glyphicon-cog" aria-hidden="true"></span>&nbsp;&nbsp;&nbsp;Notificaciones</a></li>
									<li role="presentation"><a role="menuitem" tabindex="-1"><span class="glyphicon glyphicon-list-alt" aria-hidden="true"></span>&nbsp;&nbsp;&nbsp;Facturas</a></li>
									<li role="separator" class="divider"></li>
									<li role="presentation"><a role="menuitem" tabindex="-1" href='logout.php'>Cerrar sesión</a></li>
							 </ul>
						</div>
					</ul>
					
					
					
					
					<!--li><a href="signup.php" class="btn btn-simple btn-default">Abrir una cuenta</a></li>		
					
						<li><a href="login.php" class="btn btn-round btn-default">Iniciar sesión</a></li>		
					</ul-->

				</div><!-- /.navbar-collapse -->
			</div><!-- /.container-fluid -->
        </nav>

               
</div>
</div>
<div id="navbar-full-left">
<div id="navbar-left">
<div class="navbar navbar-inverse navbar-fixed-left">
  <ul class="nav navbar-nav">

<li role="presentation"><a role="menuitem" tabindex="-1">
<span class="leftNavigationLink-content">
	<img src="/assets/images/navigation/icon-producers.svg" alt="">
	<img class="leftNavigationLink-activeImage" src="/assets/images/navigation/icon-producers-active.svg" alt="">
	<span class="leftNavigationLink-text">Productores</span>
</span>
<span class="leftNavigationLink-activeIndicator">
	<svg version="1.1" xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" viewBox="0 0 11 200">
	<polygon fill="#1D1D1B" points="0,0 0,100 0,200 11,200 11,111 0,100 11,89 11,0 "></polygon>
	</svg>
</span>
</a>
</li>
  
      <?php if ($nbHome == 0 ) : ?>
	<li><a href="#">! Bienvenido(a) ¡</a></li>
	<?php else : ?>
	  <li><a href="#">Inicio</a></li>
      <li><a href="#">Venta</a></li>
      <li><a href="#">Productores</a></li>
      <li><a href="#">Fórum de debates</a></li>
	 <?php endif  ?>
  </ul>
</div>
</div>
</div>

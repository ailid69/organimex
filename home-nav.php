<?php
require_once 'class.user.php';
$user = new USER();
if(!$user_home->is_logged_in()){
	$user_home->redirect('login.php');
}

$stmt = $user_home->runQuery("SELECT u.firstName, u.lastName, h.name, h.status, h.UID as homeid, u.UID FROM `ecocasa_members` AS asso INNER JOIN `ecocasa` AS h ON h.UID = asso.ecocasaid INNER JOIN `users` AS u ON u.UID = asso.userid WHERE u.UID=:uid");
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
					<a class="navbar-brand" href="index.php">Org@migos</a>
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
									<li role="presentation"><a href='ecomunidad.php?id=<?php echo $dbdata['homeid'] ?>' role="menuitem" tabindex="-1"><?php echo $dbdata['name'];?></a></li>
								<?php } ?>
							 </ul>
						</li>
					</ul>
					<?php } ?>

					<ul class="nav navbar-nav navbar-right">
						<li class="dropdown">
							<?php if(isset($_SESSION['fbid'])) : ?>
								<a id="fb-drop" href="#" class="dropdown-toggle btn btn-white btn-simple" data-toggle="dropdown">
									<img src="https://graph.facebook.com/<?php echo $_SESSION['fbid'] ?>./picture?width=40" alt="Circle Image" class="img-circle img-responsive center-block" width="40" height="40">			
									<span class="caret"></span>		
								</a>
							<?php else : ?>
								<a href="#" class="dropdown-toggle btn btn-round btn-default" data-toggle="dropdown">
									<span class="glyphicon glyphicon-user" aria-hidden="true"></span>	
									<?php echo $_SESSION['userName'] ?>
									<span class="caret"></span>
								</a>
							<?php endif ?>
							
							<ul class="dropdown-menu" role="menu" aria-labelledby="useroption">
								<li class="dropdown-header" role="presentation" tabindex="-1"><strong><?php echo $_SESSION['userName']; ?></strong></li>
								<li role="presentation"><a role="menuitem" tabindex="-1"><span class="glyphicon glyphicon-user" aria-hidden="true"></span>&nbsp;&nbsp;&nbsp;Identidad</a></li>
								<li role="presentation"><a role="menuitem" tabindex="-1"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>&nbsp;&nbsp;&nbsp;Cuenta</a></li>
								<li role="presentation"><a role="menuitem" tabindex="-1"><span class="glyphicon glyphicon-home" aria-hidden="true"></span>&nbsp;&nbsp;&nbsp;Eco-lugares</a></li>
								<li role="presentation"><a role="menuitem" tabindex="-1"><span class="glyphicon glyphicon-cog" aria-hidden="true"></span>&nbsp;&nbsp;&nbsp;Notificaciones</a></li>
								<li role="presentation"><a role="menuitem" tabindex="-1"><span class="glyphicon glyphicon-list-alt" aria-hidden="true"></span>&nbsp;&nbsp;&nbsp;Facturas</a></li>
								<li role="separator" class="divider"></li>
								<li role="presentation"><a role="menuitem" tabindex="-1" href='logout.php'><span class="glyphicon text-danger  glyphicon-log-out" aria-hidden="true"></span>&nbsp;&nbsp;&nbsp;Cerrar sesión</a></li>
							 </ul>	
						</li>
					</ul>
				</div><!-- /.navbar-collapse -->
			</div><!-- /.container-fluid -->
		</nav>           
	</div>
</div>

<div id="navbar-full-left">
	<div id="navbar-left">
		<div class="navbar navbar-ct-blue navbar-fixed-left">
			<ul class="nav navbar-nav">  
				<?php if ($nbHome == 0 ) : ?>
					<li>
						<a href="#" class="btn btn-round btn-white"> 	
							<img src="/img/icon-5-color.png" alt="">
							<p>Bienvenido</p>
						</a>
					</li>
				<?php else : ?>
					<li>
						<a href="#" class="btn btn-round btn-white"> 	
							<img src="/img/icon-1-color.png" alt="">
							<p>Inicio</p>
						</a>
					 </li>
					<li>
						<a href="#" class="btn btn-round btn-white"> 	
							<img src="/img/icon-2-color.png" alt="">
							<p>Venta</p>
						</a>
					</li>
					<li>
						<a href="#" class="btn btn-round btn-white"> 	
							<img src="/img/icon-3-color.png" alt="">
							<p>Productores</p>
						</a>
					</li>
					<li>
						<a href="#" class="btn btn-round btn-white"> 	
							<img src="/img/icon-4-color.png" alt="">
							<p>Fórum</p>
						</a>
					</li>
				<?php endif  ?>
			</ul>
		</div>
	</div>
</div>

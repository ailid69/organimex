<?php 
require_once 'config.php';
require_once 'class.user.php';

$user_home = new USER();
?> 

<div id="navbar-full">

	<div id="navbar">
    <!--    
        navbar-default can be changed with navbar-ct-blue navbar-ct-azzure navbar-ct-red navbar-ct-green navbar-ct-orange  
        -->
		
		<!-- ONLY HOME PAGE HAS THE TRANSPARENT NAVIGATION AND BLURRED CONTAINTER -->
		<?php if (isset($isHome)) : ?>
		<nav class="navbar-transparent navbar navbar-ct-green navbar-fixed-top" role="navigation">
		<?php else : ?>
		<nav class="navbar navbar-ct-green navbar-fixed-top" role="navigation">
		<?php endif ?>
				
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="container">
				<div class="navbar-header">
					<!--button type="button" class="navbar-toggle" data-toggle="offcanvas" data-target="#bs-example-navbar-collapse-1" data-canvas="body"!-->
					<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
						<span class="sr-only">Toggle navigation</span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
					</button>
					<a class="navbar-brand" href="index.php">Org@migos</a>
				</div>
					
					
				<!-- Collect the nav links, forms, and other content for toggling -->
				<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
				
					<ul class="nav navbar-nav">
						<li><a href="newPlace.php" class="btn btn-round btn-default">Abrir un ecolugar</a></li>
						<li><a href="index.php#4href1" class="btn btn-simple btn-default">Como fonctiona?</a></li>
						<li><a href="serprovedor.php" class="btn btn-simple btn-default">Ofrecer mis productos</a></li>
					</ul>
					<ul class="nav navbar-nav navbar-right">
						<?php if(!$user_home->is_logged_in()) : ?>

						<li class="dropdown">
							<a href="#" class="dropdown-toggle btn btn-round btn-white" data-toggle="dropdown">
								<span class="glyphicon glyphicon-user" aria-hidden="true"></span>
								<b class="caret"></b>
							</a>
							<ul class="dropdown-menu" role="menu" aria-labelledby="dropdownMenu1">
								<li role="presentation">
									<a role="menuitem" tabindex="-1" href="login.php">
										<span class="glyphicon text-success glyphicon-log-in" aria-hidden="true"></span>&nbsp;&nbsp;&nbsp;Iniciar sesión
									</a>
								</li>
								<li role="presentation" class="divider"></li>
								<li role="presentation">
									<a role="menuitem" tabindex="-1" href="signup.php">
										<span class="glyphicon text-success glyphicon-circle-arrow-right" aria-hidden="true"></span>&nbsp;&nbsp;&nbsp;Abrir una cuenta
									</a>
								</li>
							</ul>
						 </li>
						<?php else : ?>
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
							
							<ul class="dropdown-menu" role="menu" aria-labelledby="dropdownMenu1">
								<li role="presentation">
									<a href="home.php" role="menuitem" tabindex="-1">
										<span class="glyphicon text-success glyphicon-circle-arrow-right" aria-hidden="true"></span>&nbsp;&nbsp;&nbsp;Zona de miembros
									</a>
								</li>					
								<li role="presentation" class="divider"></li>
								<li role="presentation">
									<a href="logout.php" role="menuitem" tabindex="-1">
										<span class="glyphicon text-danger glyphicon glyphicon-log-out" aria-hidden="true"></span>&nbsp;&nbsp;&nbsp;Desconectarse
									</a>
								</li>		
							</ul>
						</li>
						<?php endif ?>
					
					
					
					
					<!--li><a href="signup.php" class="btn btn-simple btn-default">Abrir una cuenta</a></li>		
					
						<li><a href="login.php" class="btn btn-round btn-default">Iniciar sesión</a></li>		
					</ul-->

				</div><!-- /.navbar-collapse -->
			</div><!-- /.container-fluid -->
        </nav>
		        <!-- ONLY HOME PAGE HAS THE BLURRED CONTAINER -->
                <?php if($isHome) : ?>

                <div class="ecoblur-container">
						<!--
						<div class="motto">
							<p>Orgamigos</p>
							<h6>Apoyar intercambios locales</h6>
							<h6>Creer mercados efémeros</h6>
							<h6>Conectar directamente los productores a los consumidores</h6>
						
						</div>
						!-->
							<div class="img-src" style="background-image: url('img/bg.jpg')"></div>
						</div>
                </div>
                <?php endif ?>
</div>
</div>
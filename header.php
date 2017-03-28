<div id="navbar-full">

	<div id="navbar">
    <!--    
        navbar-default can be changed with navbar-ct-blue navbar-ct-azzure navbar-ct-red navbar-ct-green navbar-ct-orange  
        -->
		
		<!-- ONLY HOME PAGE HAS THE TRANSPARENT NAVIGATION AND BLURRED CONTAINTER -->
		<?php if ($isHome) : ?>
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
						<li><a href="#4href1" class="btn btn-simple btn-default">Como fonctiona?</a></li>
						<li><a href="serprovedor.php" class="btn btn-simple btn-default">Ser provedor</a></li>
					</ul>
					<ul class="nav navbar-nav navbar-right">
						<li class="dropdown">
						  <a href="#" class="dropdown-toggle" data-toggle="dropdown">
							
							<span class="glyphicon glyphicon-user" aria-hidden="true"></span>
							<b class="caret"></b>
						  </a>


						  <ul class="dropdown-menu" role="menu" aria-labelledby="dropdownMenu1">
							<li role="presentation"><a role="menuitem" tabindex="-1" href="login.php">Iniciar sesión</a></li>
							<li role="presentation"><a role="menuitem" tabindex="-1" href="logout.php">Desconectarse</a></li>
							<li role="presentation" class="divider"></li>
							<li role="presentation"><a role="menuitem" tabindex="-1" href="signup.php">Abrir una cuenta</a></li>
						  </ul>

						</li>
					
					
					
					
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
<div id="navbar-full">

	<div id="navbar">
    <!--    
        navbar-default can be changed with navbar-ct-blue navbar-ct-azzure navbar-ct-red navbar-ct-green navbar-ct-orange  
        -->
		
		<!-- ONLY HOME PAGE HAS THE TRANSPARENT NAVIGATION AND BLURRED CONTAINTER -->
		<?php if (true) : ?>
		<nav class="navbar-transparent navbar navbar-ct-green navbar-fixed-top" role="navigation">
		<?php else : ?>
		<nav class="navbar navbar-ct-green navbar-fixed-top" role="navigation">
		<?php endif ?>
				<?php echo '<H2>isHome=' . $isHome . '</H2>' ?>
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="container">
				<div class="navbar-header">
					<!--button type="button" class="navbar-toggle" data-toggle="offcanvas" data-target="#bs-example-navbar-collapse-1" data-canvas="body"!-->
					<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1"!>
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
						<li><a href="abrir.php" class="btn btn-round btn-default">Abrir un mercado efémero</a></li>
						<li><a href="#4href1" class="btn btn-simple btn-default">Como fonctiona?</a></li>
						<li><a href="serprovedor.php" class="btn btn-simple btn-default">Ser provedor</a></li>
						<li><a href="join.php"class="btn btn-simple btn-default">Inscribirse</a></li>
						<li><a href="login.php" class="btn btn-round btn-default">Ingresar</a></li>
						</ul>		
					</ul>
				</div><!-- /.navbar-collapse -->
			</div><!-- /.container-fluid -->
        </nav>
		        <!-- ONLY HOME PAGE HAS THE BLURRED CONTAINER -->
                <?php if($_SERVER['REQUEST_URI'] ==='/index.php') : ?>
				
				
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
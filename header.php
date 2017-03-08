<div id="navbar-full">
	<div id="navbar">
    <!--    
        navbar-default can be changed with navbar-ct-blue navbar-ct-azzure navbar-ct-red navbar-ct-green navbar-ct-orange  
        -->
		
		<!-- ONLY HOME PAGE HAS THE TRANSPARENT NAVIGATION AND BLURRED CONTAINTER -->
		<?php if($_SERVER['REQUEST_URI'] == '/index.php') : ?>
		<nav class="navbar-transparent navbar navbar-ct-green navbar-fixed-top" role="navigation">
		<?php else : ?>
		<nav class="navbar navbar-ct-green navbar-fixed-top" role="navigation">
		<?php endif ?>
				
        
			<div class="alert alert-success *">
				<div class="container">
					<?php var_dump($_SESSION); ?>
				</div>
			</div>
          
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="container">
				<div class="navbar-header">
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
						<li><a href="abrir.php" class="btn btn-round btn-default">Abrir un mercado efemero</a></li>
						<li><a href="index.php" class="btn btn-simple btn-default">Como fonctiona?</a></li>
						<li><a href="serprovedor.php" class="btn btn-simple btn-default">Ser provedor</a></li>
						</ul>


					<ul class="nav navbar-nav navbar-right">
						<li><a href="join.php">Inscribirse</a></li>
						<li><a href="login.php" class="btn btn-round btn-default">Ingresar</a></li>
					</ul>
				</div><!-- /.navbar-collapse -->
			</div><!-- /.container-fluid -->
        </nav>
		
		<!-- ONLY HOME PAGE HAS THE BLURRED CONTAINER -->
		<?php if($_SERVER['REQUEST_URI'] ==='/index.php') : ?>
		<div class="blurred-container">
			<div class="motto">
				<p>OrganiMex</p>
				<h4>Apoyar intercambios locales</h4>
				<h5>Creer mercados efemeros</h5>
				<h6>Conectar directamente los productores con los consumidores</h6>
			</div>
			<div class="img-src" style="background-image: url('img/bg.jpg')"></div>
		</div>
		<?php endif ?>
	</div>
</div>
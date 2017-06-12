<div class="footer">
    <div class="overlayer">
    <div class="container">
        <div class="row support">
            <div class="col-sm-3">

            </div>
            <div class="col-sm-3">

            </div>
            <div class="col-sm-4">

            </div>
            <div class="col-sm-2">

            </div>
        </div>
        <div class="row">
            <div class="credits">
                 &copy; <script>document.write(new Date().getFullYear())</script> Orgamigos by <a href="mailto:david.aili.mx@gmail.com"> David AÏLI</a>, made with <i class="fa fa-heart heart" alt="love"></i> for a better world.<br>
                           <!-- displays date of last git commit -->
			   <?php 
					// Change To Repo Directory
					chdir(GITPATH);
					// Load 1 Git Logs
					$git_history = [];
					$git_logs = [];
					exec("git log -1", $git_logs);
					// Parse Logs
					$last_hash = null;
					foreach ($git_logs as $line)
					{
						// Clean Line
						$line = trim($line);
						// Proceed If There Are Any Lines
						if (!empty($line))
						{
							if (strpos($line, 'Date') !== false) {
								$date = explode(':', $line, 2);
								$date = trim(end($date));
								$date = date('d/m/Y H:i:s A', strtotime($date));
							}
						}
					}
					print_r('Version from : ' . $date);
					?>
			</div>
        </div>
		


		<!--
		<div class="row">

				<div class="container">
					<p>$_SESSION : <?php var_dump($_SESSION); ?></p>
					<p>$POST : <?php var_dump($_POST); ?></p>
					<p>$_GET : <?php var_dump($_GET); ?></p>
				</div>
		</div-->

    </div>
    </div>
</div>
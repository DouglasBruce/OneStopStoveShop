<?php 
	include 'includes/overall/header.php'; 
?>

<body>

    <?php 
		include 'includes/menu.php'; 
	?>

    <!-- Page Content -->
	<div class="container">
		<div class="row">
			<?php
				if (preg_match ('%^[A-Za-z\.\' \-]{2,30}$%', stripslashes(trim($_POST['name'])))) { 
					$n = $_POST['name']; 
				} else { 
					$n = FALSE; 		
				}
				if (preg_match ('%^[A-Za-z0-9._\-]+@[A-Za-z0-9.-]+\.[A-Za-z]{2,5}$%', stripslashes(trim($_POST['email'])))) { 
					$e = $_POST['email']; 
				} else { 	
					$e = FALSE; 		
				}
				$subject = $_POST['subject'];
				if ($subject=1){
					$subject="General";
					}
				if ($subject=2){
					$subject="Exchanges";
				}
				
				if (preg_match ('%^[A-Za-z0-9\.\' \-]{1,400}$%', stripslashes(trim($_POST['message'])))) { 
					$message = $_POST['message']; 
				} else { 
					$message = FALSE; 		 
				}
				$from = 'From: '; 
				$to = 'onestopstoveshop@gmail.com'; 
				$human = $_POST['human'];
						
				$body = "From: $n\n E-Mail: $e\n Message:\n $message";
					
				if ($e && $n) {
					if ($human == 4) {				 
						if (mail ($to, $subject, $body, $from)) { 
							echo "<div class='container'>
								<div class='row text-center'><p>Your message has been sent!</p>
								</div>
							</div>";
						} else { 
							echo "<div class='container'>
								<div class='row text-center'><p>Something went wrong, go back and try again!</p>
								</div>
							</div>";
						} 
					} else if ($human != 4) {
						echo "<div class='container'>
							<div class='row text-center'><p>You answered the anti-spam question incorrectly!</p>
							</div>
						</div>";
					}
				} else {
					echo "<div class='container'>
						<div class='row text-center'><p>You need to fill in all required fields!</p>
						</div>
					</div>";
				}
			?>
		</div>
	</div>
	<!-- End of Page Content -->
<?php 
	include 'includes/overall/footer.php'; 
?>	
<?php 
	include 'includes/overall/header.php'; 
?>

<body id="contact">

    <?php 
		include 'includes/menu.php'; 
	?>

    <!-- Page Content -->
	<div class="container">
		<div class="row">				
			<div class="text-center">
				<h2>Contact Us</h2>
			</div>
			<div class="col-md-10 col-md-offset-1 padding-top-10 text-center">				
				<h3>Contact Information:</h3>
				<p><span class="glyphicon glyphicon-map-marker"></span> Address: 59 Main Street, Abernethy, Perth & Kinross, PH2 9JB, Scotland</p>
				<p><span class="glyphicon glyphicon-envelope"></span> Please send any mail to the above address</p>
				<p><span class="glyphicon glyphicon-earphone"></span> Contact by Telephone: 01687 996669</p>
				<p><span class="glyphicon glyphicon-time"></span> Office Hours: Mon-Fri: 9am - 5pm</p>
				<p><span class="glyphicon glyphicon-comment"></span> Email us at onestopstoveshop@gmail.com</p>
				<p>Or by clicking <a href="#contactModal" data-toggle="modal">here!</a></p>
				<p>Also you can reach us on our <a href="#">Facebook</a> and <a href="#">Twitter</a> pages.</p>
			</div>					
		</div>
		<!-- Modal -->
		<div class="modal fade" id="contactModal" role="dialog">
			<div class="modal-dialog">
				<!-- Modal content-->
				<div class="modal-content">
					<form class="form-horizontal" action="sendemail.php" method="POST" id="contactemail" name="contactemail">
						<div class="modal-header" >
							<button type="button" class="close" data-dismiss="modal">&times;</button>
							<h4>Contact Form:</h4>
						</div>
						<div class="modal-body">					
							<div class="form-group">
								<label for="name" class="col-lg-2 control-label">Name:</label>
								<div class="col-lg-10">
									<input type="text" class="form-control" id="name" placeholder="Full Name" name="name">
								</div>
							</div>
							<div class="form-group">
								<label for="email" class="col-lg-2 control-label">Email:</label>
								<div class="col-lg-10">
									<input type="email" class="form-control" id="email" placeholder="you@example.com" name="email">
								</div>
							</div>
							<div class="form-group">
								<label for="subject" class="col-lg-2 control-label">Subject:</label>
								<div class="col-lg-10">
									<select class="form-control" id="subject" name="subject">
										<option value="1">General</option>
										<option value="2">Exchanges</option>
									</select>
								</div>
							</div>
							<div class="form-group">
								<label for="textarea" class="col-lg-2 control-label">Message:</label>
								<div class="col-lg-10">
									<textarea class="form-control" rows="4" id="textarea" name="message" maxlength="400" placeholder="Message Can Contain: Upper, Lower Case Letters, Numbers, Spaces, .'- Characters. Max 400 Characters."></textarea>
									<div id="textarea_feedback"></div>
								</div>
							</div>
							<div class="form-group">
								<label for="human" class="col-lg-2 control-label">2+2?</label>
								<div class="col-lg-10">
									<input type="text" class="form-control" id="human" name="human" placeholder="Type Here">
								</div>
							</div>
						</div>
						<div class="modal-footer">
							<a class="btn btn-danger" data-dismiss="modal">
								<span class="glyphicon glyphicon-remove"></span> Cancel
							</a>
							<button type="reset" class="btn btn-warning">
								<span class="glyphicon glyphicon-erase"></span> Clear
							</button>	
							<button class="btn btn-success" type="submit">
								<span class="glyphicon glyphicon-send"></span> Send
							</button>					
						</div>
					</form>
				</div>
				<!-- Modal Content End -->
			</div>
		</div> 
		<!-- Modal End -->
	</div>
	<!-- End of Page Content -->
<?php 
	include 'includes/overall/footer.php'; 
?>		
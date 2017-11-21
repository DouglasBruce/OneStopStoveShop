	<!-- Navigation -->
    <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
        <div class="container">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navbar-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="index.php">Logo</a>
            </div>
            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="navbar-collapse">
                <ul class="nav navbar-nav">
                    <li>
						<a href="index.php">Store</a>
					</li>
					<li>
                        <a href="about.php">About</a>
                    </li>
					<li>
						<a href="contact.php">Contact</a>
					</li>		
					<li>
                        <a href="https://my.setmore.com/shortBookingPage/8ca6bc36-658e-42c1-a124-0e910f76b49f" target="_blank">Services</a>
                    </li>
                </ul>
				<ul class="nav navbar-nav navbar-right">
					<li>
						<a href="index.php?view_cart"><span class="glyphicon glyphicon-shopping-cart"></span> Cart</a>
					</li>
					<?php if($currentuser['userlevel']<2) { ?>
					<li>
						<a href="registration.php"><span class="glyphicon glyphicon-registration-mark"></span> Register</a>
					</li>
					<li>
						<a href="#loginModal" data-toggle="modal"><span class="glyphicon glyphicon-log-in"></span> Login</a>
					</li>
					<?php } ?>
					<?php if($currentuser['userlevel']==2) { ?>
					<li>
						<a href="account.php"><span class="glyphicon glyphicon-user"></span> Account</a>
					</li>
					<?php } ?>
					<?php if($currentuser['userlevel']==3) { ?>
					<li>
						<a href="admin.php"><span class="glyphicon glyphicon-briefcase"></span> Administration</a>
					</li>
					<?php } ?>
					<?php if($currentuser['userlevel']>1) { ?>
					<li>
						<a href="php/logout.php"><span class="glyphicon glyphicon-log-out"></span> Logout</a>
					</li>
					<?php } ?>
				</ul>
            </div>
            <!-- /.navbar-collapse -->
        </div>
        <!-- /.container -->
    </nav>
	<!-- Modal -->
    <div class="modal fade" id="loginModal" role="dialog">
		<div class="modal-dialog">
			<!-- Modal content-->
			<div class="modal-content">
				<div class="modal-header" >
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<h4><span class="glyphicon glyphicon-lock"></span> Login</h4>
				</div>
				<div class="modal-body">
					<form name="loginform" id="loginform" method="post" action="https://comp-hons.uhi.ac.uk/~13007173/OneStopStoveShop/php/processlogin.php">
						<div class="input-group">
							<span class="input-group-addon">
								<span class="glyphicon glyphicon-user"></span>
							</span>
							<input type="text" class="form-control" name="username" id="username" placeholder="Username" size="10" required />
						</div>
						<div class="input-group padding-top-10">
							<span class="input-group-addon">
								<span class="glyphicon glyphicon-lock"></span>
							</span>
							<input type="password" class="form-control" name="userpass1" id="userpass1" placeholder="Password" size="10" required />
						</div>
						<div class="checkbox text-center">
							<label><input type="checkbox" value="">Remember me</label>
						</div>
						<button type="submit" class="btn btn-default btn-success btn-block"><span class="glyphicon glyphicon-off"></span> Login</button>
					</form>
				</div>
				<div class="modal-footer">
				    <button type="submit" class="btn btn-default btn-danger pull-left" data-dismiss="modal"><span class="glyphicon glyphicon-remove"></span> Cancel</button>
					<p>Not a member? <a href="registration.php"><span class="glyphicon glyphicon-registration-mark"></span> Sign Up</a></p>
					<p><a href="#"><span class="glyphicon glyphicon-question-sign"></span> Forgotten your password?</a></p>					
				</div>
			</div>
			<!-- Modal Content End -->
		</div>
    </div> 
	<!-- Modal End -->
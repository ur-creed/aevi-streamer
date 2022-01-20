<nav class="navbar fixed-top navbar-expand-lg navbar-dark bg-transparent">
	<div class="container-fluid">
		<a class="navbar-brand" href="#">
			<img src="images/jara.png" alt="logo design" width="75" height="75">
		</a>
		<button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
			<span class="navbar-toggler-icon"></span>
		</button>
		<div class="collapse navbar-collapse" id="navbarNav">
			<ul class="navbar-nav ms-auto">
				<?php if(empty($_SESSION['AeviWebSession'])) { ?>
					<li class="nav-item" id="SignUp" data-bs-toggle="modal" data-bs-target="#SignUpModal">
						<a class="nav-link" href="#">Sign Up</a>
					</li>
					<li class="nav-item" id="Login" data-bs-toggle="modal" data-bs-target="#LoginModal">
						<a href="#" class="nav-link">Login</a>
					</li>
				<?php } else { ?>
					<li id="ProfileButtonLink" class="nav-item">
						<a class="nav-link" href="profile.php?id='<?php echo $profileId; ?>'"><i class="fas fa-user"> Profile</i></a>
					</li>
					<li id="LogoutButtonLink" class="nav-item">
						<a class="nav-link"><i class="fas fa-sign-out-alt"> Logout</i></a>
					</li>
			    <?php } ?>
			</ul>
		</div>
	</div>
</nav>

<!-- Sign Up Modal-->
<div class="modal fade" id="SignUpModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="SignUpLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="SignUpLabel">Sign Up</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="SignUpForm" method="post" class="row g-3" enctype="multipart/form-data">
                    <div class="col-md-6">
                        <label for="FirstName" class="form-label">First Name</label>
                        <input type="text" class="form-control" id="FirstName" name="first-name" required>
                    </div>
                    <div class="col-md-6">
                        <label for="LastName" class="form-label">Last Name</label>
                        <input type="text" class="form-control" id="LastName" name="last-name" required>
                    </div>
                    <div class="col-md-12">
                        <label for="Email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="Email" name="email" required>
                    </div>
                    <div class="col-md-12">
                        <label for="Password" class="form-label">Password</label>
                        <input type="password" class="form-control" id="Password" name="password" required>
                    </div>
	                <div class="col-md-12">
		                <label for="ConfirmPassword" class="form-label">Confirm Password</label>
		                <input type="password" class="form-control" id="ConfirmPassword" name="confirm-password" required>
	                </div>
                    <div class="col-12">
                        <label for="CommunityName" class="form-label">Community Name</label>
                        <input type="text" class="form-control" id="CommunityName" name="community-name" required>
                    </div>
                    <div class="col-12">
	                    <label for="LogoImage" class="form-label">Logo Image</label>
	                    <input type="file" class="form-control" id="LogoImage" name="logo-image" required>
                    </div>
                    <div class="col-12">
	                    <label for="BackgroundImage" class="form-label">Background Image</label>
	                    <input type="file" class="form-control" id="BackgroundImage" name="background-image" required>
                    </div>
	                <div id="SignUpAlert" class="alert alert-danger" role="alert" hidden>
						<!-- This will be handled by js -->
	                </div>
                </form>
            </div>
	        <div class="modal-footer">
		        <button type="button" class="btn btn-outline-danger" data-bs-dismiss="modal">Cancel</button>
		        <button type="submit" form="SignUpForm" class="btn btn-success">Sign Up</button>
	        </div>
        </div>
<!-- TODO :: ADD THIS BACK -->
<!--	    <div class="spinner-border text-success" role="status">-->
<!--		    <span class="visually-hidden">Loading...</span>-->
<!--	    </div>-->
    </div>
</div>

<!-- Login Modal-->
<div class="modal fade" id="LoginModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="LoginModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="LoginModalLabel">Login</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
	            <form id="LoginForm" class="row g-3">
		            <div class="col-md-12">
			            <label for="LoginEmail" class="form-label">Email</label>
			            <input id="LoginEmail" name="login-email" type="email" class="form-control" required>
		            </div>
		            <div class="col-md-12">
			            <label for="LoginPassword" class="form-label">Password</label>
			            <input id="LoginPassword" name="login-password" type="password" class="form-control"  required>
		            </div>
		            <div id="LoginAlert" class="alert alert-danger" role="alert" hidden>
			            <!-- This will be handled by js -->
		            </div>
	            </form>
            </div>
	        <div class="modal-footer">
		        <button type="button" class="btn btn-outline-danger" data-bs-dismiss="modal">Cancel</button>
		        <button type="submit" form="LoginForm" class="btn btn-success">Login</button>
	        </div>
        </div>
    </div>
</div>





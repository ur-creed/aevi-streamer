<nav class="navbar navbar-expand-lg navbar-dark bg-transparent">
    <div class="container-fluid">
        <a class="navbar-brand" href="#">
            <img src="/aevistreamer/<?php echo $profile['LOGO_IMAGE'] ?>" alt="Streamer Profile Picture" width="120" height="120">
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
	            <li class="nav-item">
		            <a class="nav-link" href="/aevistreamer/index.php"><i class="fas fa-home"> Home</i></a>
	            </li>
	            <li class="nav-item">
		            <a class="nav-link" href="#"><i class="fas fa-shopping-bag"> Merchandise</i></a>
	            </li>
	            <li class="nav-item">
		            <a class="nav-link" href="#Tournaments"><i class="fas fa-gamepad"> Tournaments</i></a>
	            </li>
	            <li class="nav-item">
		            <a class="nav-link" href="#Socials"><i class="fas fa-user-friends"> Socials</i></a>
	            </li>
	            <?php if(!empty($sessionId)) { ?>
		            <li id="MyAccountButtonLink" class="nav-item">
			            <a class="nav-link" href="/aevistreamer/account.php"><i class="fas fa-cog"> Account</i></a>
		            </li>
		            <li id="LogoutButtonLink" class="nav-item">
                        <a class="nav-link"><i class="fas fa-sign-out-alt"> Logout</i></a>
                    </li>
	            <?php } else { ?>
		            <li id="LoginButtonLink" class="nav-item">
			            <a class="nav-link" href="#"><i class="fas"> Login</i></a>
		            </li>
	            <?php } ?>
            </ul>
        </div>
    </div>
</nav>
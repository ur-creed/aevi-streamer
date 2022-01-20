<?php
	session_start();
	
	$hasGoidParam = isset($_REQUEST['goid']);
	$isSession = isset($_SESSION['AeviWebSession']);
	
	if(!$isSession && !$hasGoidParam)
	{
		header('Location: index.php');
	}
	
	// Requires
	require_once 'config.php';
	
	if($isSession) {
		$sessionId = $_SESSION['AeviWebSession'];
		$title = $_SESSION['AeviStreamProfileName'];
		$userId = $_SESSION['AeviStreamUserProfile'];
	} else {
		$userId = $_REQUEST['goid'];
		$sessionId = 'Preview';
		$statement = "SELECT COMMUNITY_NAME FROM USER WHERE ID = '" . $userId . "'";
		$query = $con->query($statement);
		$user = $query->fetch_row();
	}
	
	$statement = "SELECT * FROM PROFILE WHERE USER_ID = '" . $userId . "'";
	$query = $con->query($statement);
	$profile = $query->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<title>AW Stream | <?php echo $title ?></title>
	
	<!-- Bootstrap -->
	<link rel="stylesheet" href="vendor/twbs/bootstrap/dist/css/bootstrap.min.css">
	<link rel="stylesheet" href="vendor/fortawesome/font-awesome/css/all.min.css">
	<link rel="stylesheet" href="css/profile/main.css">
    
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Fugaz+One&display=swap" rel="stylesheet">
    
	<script src="vendor/components/jquery/jquery.min.js"></script>
	<script src="vendor/twbs/bootstrap/dist/js/bootstrap.min.js"></script>
	<script src="js/profile.js"></script>
</head>
<body>
    <?php include 'profile/header.php'; ?>
    <button onclick="topFunction()" id="myBtn" title="Go to top">Top</button>
    
    <script>
        //Get the button
        var mybutton = document.getElementById("myBtn");
        
        // When the user scrolls down 20px from the top of the document, show the button
        window.onscroll = function() {scrollFunction()};
        
        function scrollFunction() {
            if (document.body.scrollTop > 20 || document.documentElement.scrollTop > 20) {
                mybutton.style.display = "block";
            } else {
                mybutton.style.display = "none";
            }
        }
        
        // When the user clicks on the button, scroll to the top of the document
        function topFunction() {
            document.body.scrollTop = 0;
            document.documentElement.scrollTop = 0;
        }
    </script>
    
	<main>
		<section id="CommunityBiography" class="community">
			<h1>Community Bio</h1>
			<?php if(!empty($profile['BIOGRAPHY'])) { ?>
					<div class="community_textarea">
						<!--  -->
						<?php echo $profile['BIOGRAPHY'] ?>
					</div>
			<?php } else { ?>
					<h3>There is currently no community biography</h3>
			<?php } ?>
		</section>
		<section id="Tournaments" class="tournaments">
			<h1>Upcoming Tournaments</h1>
			<?php
				// Gets the tournaments for the current profile.
				$tournamentStatement = "SELECT * FROM TOURNAMENT WHERE PROFILE_ID = '" . $profile['ID'] . "'";
				$tournamentQuery = $con->query($tournamentStatement);
				$hasTournaments = $tournamentQuery->num_rows >= 1;
			?>
	        <div class="container">
	            <div class="row justify-content-lg-center">
		            <?php if(!$hasTournaments) { ?>
			                <!-- TODO :: This text will be grey -->
				            <h2>There are currently no scheduled tournaments</h2>
					<?php } else { ?>
			            <?php while ($tournament = mysqli_fetch_assoc($tournamentQuery)) { ?>
				            <div class="col-lg-3 col-md-6 col-sm-12">
					            <div class="card" style="width: 18rem;">
						            <?php
							            // Gets the tournaments for the current profile.
							            $gameStatement = "SELECT IMAGE FROM GAME WHERE ID = '" . $tournament['GAME_ID'] . "'";
							            $gameQuery = $con->query($gameStatement);
							            $game = $gameQuery->fetch_assoc();
						            ?>
						            <img src="<?php echo $game['IMAGE']; ?>" class="card-img-top" alt="...">
						            <div class="card-body">
							            <h5 class="card-title"><?php echo $tournament['NAME']; ?></h5>
							            <p class="card-text"><?php echo $tournament['DESCRIPTION']; ?></p>
							            <p>Entry Fee: <?php echo $tournament['FEE'] == NULL ? "Free!" : "$" . $tournament['FEE'];  ?></p>
							            <p>Start Date: <?php echo date_format(new DateTime($tournament['START_DATE']), 'm/d/y h:i A');  ?></p>
							            <p>End Date: <?php echo date_format(new DateTime($tournament['END_DATE']), 'm/d/y h:i A'); ?></p>
							            <div class="card-footer">
								            <button type="button" class="btn btn-lg btn-primary" data-bs-toggle="modal" data-bs-target="#registerModal">Register</button>
								            <button type="button" class="btn btn-lg btn-success" data-bs-container="card-body">Submit Score</button>
							            </div>
					            </div>
				            </div>
			            <?php } ?>
		            <?php } ?>
	            </div>
                    <!-- Modal -->
                    <div class="modal fade" id="registerModal" tabindex="-1" aria-labelledby="registerModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="registerModalLabel">Modal title</h5>
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
                                            <label for="ActivisonId" class="form-label">Activison Id</label>
                                            <input type="text" class="form-control" id="ActivisonId" name="activison_id" required>
                                        </div>
                                    </form>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-outline-danger" data-bs-toggle="modal" data-bs-target="#rulesModal">Rules</button>
                                    <button type="button" class="btn btn-primary">Register</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Modal -->
                    <div class="modal fade" id="rulesModal" tabindex="-1" aria-labelledby="rulesModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered modal-lg">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="rulesModalLabel">Tournament Rules</h5>
                                </div>
                                <div class="modal-body">
                                   <p>asdkfalksdjfla;ksdjf;laksdjfl;aksdjf;laskdjfl;aksjdfl;aksjdfl;kasjdfl;kajsdfl;kajsdfl;kajsdl
                                   al;ksdjfl;kasdjfl;askdjf;laksdjfl;aksdjf;laksdjf;lkajsdfl;aksdjfl;aksfasdfasdfasdf
                                       asdfasdfasdfasdfasdfasdfasdfasdfasdfasdfasdfasdfasdfasdfasdf
                                       asdfasdfasdfasdfasdfasdfasdfasdfasdfasdfasdfasdfjdfl;aksdjfl;askdjfal;skdfj
                                   alskdjfkla;sdjflak;sdjfal;ksdjf;alksdjfl;aksdjfl;aksjdfl;kadsjfl;aksdjfa;lksdfjal;sdkfjal;dksfj
                                   </p>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-target="#registerModal" data-bs-dismiss="modal">Close</button>
                                </div>
                            </div>
                        </div>
                    </div>
	        </div>
		</section>
		
		<section id="Socials" class="socials">
			<h1>Check Us Out On:</h1>
	        <ul id="services">
	            <li>
	                <div class="Facebook">
	                    <a href="https://facebook.com/colorlib/">
	                        <i class="fab fa-facebook-f" aria-hidden="true"></i>
	                    </a>
	                </div>
	                <span>Facebook</span>
	            </li>
	            <li>
	                <div class="Twitch">
	                    <a href="https://twitter.com/colorlib/">
	                        <i class="fab fa-twitch" aria-hidden="true"></i>
	                    </a>
	                </div>
	                <span>Twitch</span>
	            </li>
	            <li>
	                <div class="Discord">
	                    <a href="https://www.youtube.com/c/Colorlib">
	                        <i class="fab fa-discord" aria-hidden="true"></i>
	                    </a>
	                </div>
	                <span>Discord</span>
	            </li>
	            <li>
	                <div class="YouTube">
	                    <a href="https://www.linkedin.com/company/colorlib">
	                        <i class="fab fa-youtube" aria-hidden="true"></i>
	                    </a>
	                </div>
	                <span>YouTube</span>
	            </li>
	            <li>
	                <div class="Instagram">
	                    <a href="https://www.instagram.com/">
	                        <i class="fab fa-instagram" aria-hidden="true"></i>
	                    </a>
	                </div>
	                <span>Instagram</span>
	            </li>
	            <li>
	                <div class="Twitter">
	                    <a href="https://twitter.com/?lang=en">
	                        <i class="fab fa-twitter" aria-hidden="true"></i>
	                    </a>
	                </div>
	                <span>Twitter</span>
	            </li>
	        </ul>
		</section>
    </main>
	
	<?php include_once('profile/footer.php'); ?>
 
</body>
</html>
<?php $con->close() ?>
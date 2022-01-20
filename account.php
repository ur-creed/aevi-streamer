<?php
	session_start();
	require_once 'config.php';
	
	if(!isset($_SESSION['AeviWebSession']) && !isset($_SESSION['AeviStreamUserProfile'])) {
		header('Location: index.php');
	}
	
	$id = $_SESSION['AeviStreamUserProfile'];
	$profileStatement = "SELECT * FROM PROFILE WHERE USER_ID = '" . $id . "'";
	$query = $con->query($profileStatement);
	$profile = $query->fetch_assoc();
	
	$userStatement = "SELECT * FROM USER WHERE ID = '" . $id . "'";
	$userQuery = $con->query($userStatement);
	$user = $userQuery->fetch_assoc();
	
	$isStreamerSession = explode('-', $_SESSION['AeviWebSession'])[0] == "streamer";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Account - <?php echo $_SESSION['AeviStreamProfileName'] ?></title>

    <!-- Bootstrap -->
    <link rel="stylesheet" href="vendor/twbs/bootstrap/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="vendor/fortawesome/font-awesome/css/all.min.css">
    <link rel="stylesheet" href="css/account/main.css" type="text/css">

    <!-- JavaScript -->
    <script src="vendor/components/jquery/jquery.min.js"></script>
    <script src="vendor/twbs/bootstrap/dist/js/bootstrap.min.js"></script>
    <script src="vendor/tinymce/tinymce/tinymce.min.js"></script>
    <script src="js/account.js" type="text/javascript"></script>

</head>
<body>
	<!-- Account Navigation -->
	<header>
		<div class="container-fluid">
			<nav class="navbar fixed-top navbar-expand-lg navbar-dark bg-transparent">
				<div class="collapse navbar-collapse" id="navbarNav">
					<ul class="navbar-nav ms-auto">
						<li id="ProfileButtonLink" class="nav-item">
							<a class="nav-link" href="profile.php"><i class="fas fa-user"> Profile</i></a>
						</li>
						<li id="LogoutButtonLink" class="nav-item">
							<a class="nav-link"><i class="fas fa-sign-out-alt"> Logout</i></a>
						</li>
					</ul>
				</div>
			</nav>
		</div>
	</header>
	<button id="TopButton" title="Go to top">Top</button>
	
    <h1>My Account</h1>
	<hr>
	<main>
		<!-- User section -->
		<section class="User">
			<h2>User</h2>
			<div class="container">
				<form>
					<div class="form-group">
						<label for="FirstName" class="form-label">First name</label>
						<input type="text" class="form-control" id="FirstName" name="first-name" value="<?php echo $user['FIRST_NAME'] ?>">
					</div>
					<div class="form-group">
						<label for="LastName" class="form-label">Last name</label>
						<input type="text" class="form-control" id="LastName" name="last-name" value="<?php echo $user['LAST_NAME'] ?>">
					</div>
					<div class="form-group">
						<label for="Email" class="form-label">Email address</label>
						<input type="email" class="form-control" id="Email" name="email" value="<?php echo $user['EMAIL'] ?>">
					</div>
					<div class="form-group">
						<label for="Password" class="form-label">Password</label>
						<input type="password" class="form-control" id="Password" name="password" value="<?php echo $user['PASSWORD'] ?>">
					</div>
					<button type="submit" class="btn btn-outline-primary">Update</button>
				</form>
			</div>
		</section>
		<!-- Checks for a streamer session to show these sections. -->
		<?php if($isStreamerSession) { ?>
			<hr>
			<!-- Profile section -->
			<div class="jumbotron">
				<section class="ImageUpload">
					<h2>Profile</h2>
					<br>
					<form>
						<div class="container">
							<div class="row">
								<div class="col-sm-2 imgUp">
									<div class="imagePreview"><img src="<?php echo $profile['LOGO_IMAGE']; ?>" width="222" height="218"></div>
									<label class="btn btn-primary">
										Upload Logo<input type="file" class="uploadFile img" value="Upload Photo" style="width: 0px;height: 0px;overflow: hidden;">
									</label>
								</div><!-- col-2 -->
							</div><!-- row -->
						</div><!-- container -->
						<br>
						<div class="container">
							<div class="row">
								<div class="col-sm-2 imgUp">
									<div class="imagePreview"><img src="<?php echo $profile['BACKGROUND_IMAGE']; ?>" width="222" height="218"></div>
									<label class="btn btn-primary">
										Upload Background<input type="file" class="uploadFile img" value="Upload Photo" style="width: 0px;height: 0px;overflow: hidden;">
									</label>
								</div><!-- col-2 -->
							</div><!-- row -->
						</div><!-- container -->
						<div class="mb-3">
							<label for="WelcomeMessage" class="form-label">Welcome message</label>
							<input type="text" class="form-control" id="WelcomeMessage" value="<?php echo $profile['TITLE'] ?>">
						</div>
						<div class="mb-3">
							<label for="MerchandiseUrl" class="form-label">Merchandise</label>
							<input type="url" class="form-control" id="MerchandiseUrl" placeholder="Merch URL">
						</div>
						<button type="submit" form="" class="btn btn-outline-primary btn-update-profile">Update</button>
					</form>
				</section>
			</div>
			
			<hr>
			<!-- Community Bio -->
			<section class="CommunityBio">
				<h2>Community Biography</h2>
				<br>
				<div id="CommunityBiographyAlert" class="alert" role="alert" hidden>
					<!-- This will be handled by js -->
				</div>
				<div align="center">
					<form id="CommunityBiographyForm">
						<input type="hidden" name="profile-id" value="<?php echo $profile['ID'] ?>">
						<textarea id="CommunityBiography" name="community-biography" placeholder="Tell everyone what your community is about!">
							<?php echo $profile['BIOGRAPHY']; ?>
						</textarea>
					</form>
				</div>
				<button type="submit" form="CommunityBiographyForm" class="btn btn-outline-primary btn-lg btn-update">Update</button>
			</section>
			<hr>
			<!-- Tournaments -->
			<section class="Tournament">
				<h2>Tournament</h2>
				<div class="container" id="tournamentEdit">
					<div id="TournamentAlert" class="alert" role="alert" hidden>
						<!-- This will be handled by js -->
					</div>
					<div class="grouping">
						<label for="CreateTournament">Create</label>
						<button id="CreateTournament" class="dot dot_add" data-bs-toggle="modal" data-bs-target="#CreateTournamentModal"><i class="fas fa-plus"></i></button>
					</div>
					<!-- Create Tournament Modal-->
					<div class="modal fade" id="CreateTournamentModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="CreateTournamentLabel" aria-hidden="true">
						<div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-lg">
							<div class="modal-content">
								<div class="modal-header">
									<h5 class="modal-title" id="CreateTournamentLabel">Create Tournament</h5>
									<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
								</div>
								<div class="modal-body">
									<form id="CreateTournamentForm" class="row g-3">
										<input type="hidden" name="profile-id" value="<?php echo $profile['ID']; ?>">
										<div class="col-md-12">
											<label for="CreateTournamentName" class="form-label">Name</label><span class="required">*</span>
											<input type="text" id="CreateTournamentName" name="create-tournament-name" class="form-control" placeholder="Solos Mini - or - The Awesome Tournament" required>
										</div>
										<div class="col-md-12">
											<label for="CreateTournamentGame" class="form-label">Choose a Game:</label><span class="required">*</span>
											<?php
												$gameStatement = "SELECT * FROM GAME";
												$gameQuery = $con->query($gameStatement);
											?>
											<select id="CreateTournamentGame" name="create-tournament-game" class="form-control" required>
												<?php while ($game = mysqli_fetch_assoc($gameQuery)) { ?>
													<option value="<?php echo $game['ID'] ?>"><?php echo $game['NAME'] ?></option>
												<?php } ?>
											</select>
										</div>
										<div class="col-md-12">
											<label for="CreateTournamentType" class="form-label">Choose a Type:</label><span class="required">*</span>
											<?php
												$tournamentTypeStatement = "SELECT * FROM TOURNAMENT_TYPE";
												$tournamentTypeQuery = $con->query($tournamentTypeStatement);
											?>
											<select id="CreateTournamentType" name="create-tournament-type" class="form-control" required>
												<?php while ($type = mysqli_fetch_assoc($tournamentTypeQuery)) { ?>
													<option value="<?php echo $type['ID'] ?>"><?php echo $type['NAME'] ?></option>
												<?php } ?>
											</select>
										</div>
										<div class="col-md-12">
											<label for="CreateTournamentEntryFee" class="form-label">Entry Fee</label>
											<input type="number" id="CreateTournamentEntryFee" name="create-tournament-entry-fee" class="form-control" placeholder="5.00">
										</div>
										<div class="col-md-12">
											<label for="CreateTournamentDescription" class="form-label">Description</label>
											<input type="text" id="CreateTournamentDescription" name="create-tournament-description" class="form-control" placeholder="Just a friendly tournament for everyone!">
										</div>
										<div class="col-md-12">
											<label for="CreateTournamentRules" class="form-label">Rules</label>
											<textarea id="CreateTournamentRules" name="create-tournament-rules" class="form-control">
											</textarea>
										</div>
										<div class="col-md-12">
											<label for="CreateTournamentStartDateTime" class="form-label">Start Date:</label>
											<input type="datetime-local" id="CreateTournamentStartDateTime" name="create-tournament-start-date-time" class="form-control">
										</div>
										<div class="col-md-12">
											<label for="CreateTournamentEndDateTime" class="form-label">End Date:</label>
											<input type="datetime-local" id="CreateTournamentEndDateTime" name="create-tournament-end-date-time" class="form-control">
										</div>
										<div id="CreateTournamentAlert" class="alert" role="alert" hidden>
											<!-- This will be handled by js -->
										</div>
									</form>
								</div>
								<div class="modal-footer">
									<button type="button" class="btn btn-outline-danger" data-bs-dismiss="modal">Cancel</button>
									<button type="submit" form="CreateTournamentForm" class="btn btn-success">Create</button>
								</div>
							</div>
						</div>
					</div>
					<div class="grouping">
						<label for="EditTournament">Edit</label>
						<button id="EditTournament" class="dot dot_edit"><i class="fas fa-pencil-alt"></i></button>
					</div>
					<div class="grouping">
						<label for="DeleteTournament">Remove</label>
						<button id="DeleteTournament" class="dot dot_delete"><i class="fas fa-minus"></i></button>
					</div>
				</div>
			</section>
			<hr>
			<!-- Socials -->
			<section class="SocialIcons">
				<h2>Social Media</h2>
				<?php
					$profileSocialStatement = "SELECT SOCIAL_ID, ENABLED, URL FROM PROFILE_SOCIAL_REF WHERE PROFILE_ID = '" . $profile['ID'] . "'";
					$query = $con->query($profileSocialStatement);
				?>
				<div class="SocialContainer">
					<form id="SocialMediaForm">
						<?php while ($profileSocial = mysqli_fetch_assoc($query)) { ?>
							<?php
							$socialId = $profileSocial['SOCIAL_ID'];
							$socialUrl = $profileSocial['URL'];
							$socialSql = "SELECT * FROM SOCIAL WHERE ID = '" . $socialId ."'";
							$socialQuery = $con->query($socialSql);
							$social = $socialQuery->fetch_assoc();
							$isEnabled = $profileSocial['ENABLED'] == 1;
							$isChecked = $isEnabled ? 'checked' : '';
							?>
							<div class="form-check form-switch">
								<input class="form-check-input" type="checkbox" id="<?php echo $social['NAME']; ?>Toggle" <?php echo $isChecked ?>>
								<label class="form-check-label" for="<?php echo $social['NAME']; ?>Toggle"><i class="fab fa-<?php echo $social['INTERNAL_NAME'] ?>"></i></label>
								<label for="<?php echo $social['NAME']; ?>URL" aria-hidden="true"></label>
								<input id="<?php echo $social['NAME']; ?>URL" type="text" name="<?php echo $social['INTERNAL_NAME']; ?>-url" placeholder="<?php echo $social['NAME']; ?> URL" value="<?php echo $socialUrl; ?>">
							</div>
						<?php } ?>
					</form>
					<button type="button" form="SocialMediaForm" class="btn btn-outline-primary btn-lg btn-update">Update</button>
				</div>
			</section>
			<hr>
		<?php } ?>
		<section class="Payments">
			<h2>Payment</h2>
			<div class="container">
				<form id="PayPalForm">
					<div class="form-group">
						<label for="PaymentSource"><i class="fab fa-paypal"></i></label>
						<input type="text" class="form-control" id="PaymentSource" aria-describedby="text" placeholder="PayPal Client ID">
					</div>
				</form>
				<button type="button" form="PayPalForm" class="btn btn-outline-primary btn-lg btn-update" id="paypal">Update</button>
			</div>
		</section>
	</main>
</body>
</html>
<?php $con->close(); ?>
<?php
session_start();

if(isset($_SESSION['AeviStreamUserProfile'])) {
	$profileId = $_SESSION['AeviStreamUserProfile'];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<title>Aevi Web | Streamer Template</title>
	
	<!-- Bootstrap -->
	<link rel="stylesheet" href="vendor/twbs/bootstrap/dist/css/bootstrap.min.css">
	<link rel="stylesheet" href="vendor/fortawesome/font-awesome/css/all.min.css">
	<link rel="stylesheet" href="css/main.css">
    
    <!--  Google Font  -->
	
    <!-- JavaScript -->
	<script src="vendor/components/jquery/jquery.min.js"></script>
	<script src="vendor/twbs/bootstrap/dist/js/bootstrap.min.js"></script>
	<script src="vendor/tinymce/tinymce/tinymce.min.js"></script>
	<script src="js/index.js"></script>
</head>
<body>
	<?php include_once 'header.php' ?>
	<div id="BackgroundVideo" class="bg-video">
        <video class="bg-video__content" autoplay muted loop>
        <source src="videos/Pexels%20Videos%202759477.mp4" type="video/mp4">
        </video>
    </div>
	<main>
		<!-- The search bar info here. -->
        <div class="container-fluid">
        <div class="jumbotron">
            <h1>Search for a streamer...</h1>
        </div>
            <div class="container h-100">
                <div class="d-flex justify-content-center h-100">
                    <div class="searchbar">
                        <input class="search_input typeahead" type="text" name="streamer-search" data-provide="typeahead" placeholder="Streamer Community Name">
                        <a href="#" class="search_icon"><i class="fas fa-search"></i></a>
                    </div>
                </div>
            </div>
        </div>
	</main>
	
	<?php include_once 'footer.php' ?>
</body>
</html>
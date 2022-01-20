<?php
	
	require_once '../config.php';
	
	if(isset($_REQUEST['community-biography'])) {
		$messageObj = new stdClass();
		$profileId = $_REQUEST['profile-id'];
		$communityBiography = $_REQUEST['community-biography'];
		$bioStatement = "UPDATE PROFILE SET BIOGRAPHY = '" . $communityBiography . "' WHERE  ID = '" . $profileId . "'";
		$result = $con->query($bioStatement);
		
		if ($result) {
			$messageObj->messageType = 'success';
			$messageObj->message = 'Community biography updated successfully!';
		} else {
			$messageObj->messageType = 'danger';
			$messageObj->message = 'Something went wrong. Please try again later.';
		}
		
		echo json_encode($messageObj);
	}
	
	$con->close();
	
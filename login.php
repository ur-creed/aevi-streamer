<?php
	session_start();
	require_once 'config.php';
	
	if(isset($_REQUEST['login-email']))
	{
		$myObj = new stdClass();
		$email = trim(strtolower($_REQUEST['login-email']));
		$password = $_REQUEST['login-password'];
		
		// Query for an existing user.
		$statement = "SELECT * FROM USER WHERE EMAIL = '" . $email . "'";
		$result = $con->query($statement);
	
		if ($result->num_rows == 0) {
			$myObj->profileId = 0;
			$myObj->profileTitle = "";
			$myObj->sessionType = "";
			$myObj->message = "We can't find an account with that email and password!";
			
		} else {
			$userDetails = $result->fetch_assoc();
			$passwordHash = $userDetails['PASSWORD'];
			
			// Verify the the password matches.
			if (password_verify($password, $passwordHash)) {
				
				$roleId = $userDetails['ROLE_ID'];
				$userId = $userDetails['ID'];
				$profileTitle = $userDetails['COMMUNITY_NAME'];
				
				// Get the profile GOID.
				$myObj->userId = $userId;
				$myObj->profileTitle = $profileTitle;
				
				if($roleId == 1) {
					
					$myObj->sessionType = "streamer";
					
				} else {
					
					$myObj->sessionType = "player";
				}
				
				$aeviSessionId = $myObj->sessionType . "-" . uniqid();
				$_SESSION['AeviWebSession'] = $aeviSessionId;
				$_SESSION['AeviStreamProfileName']  = $profileTitle;
				$_SESSION['AeviStreamUserProfile'] = $userId;
				// TODO :: Here we will insert the above session info into the session table.
				// TODO :: This will happen in a later version.
				
			} else {
				$myObj->message = "Username password combination is incorrect"; // TODO :: Think about the alert message should say on redirect.
			}
		}
		
		// Handles what is returned in login request.
		echo json_encode($myObj);
	}
	
	// Close the database connection.
	$con->close();
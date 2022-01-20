<?php

	// Include config file
	require_once "config.php";
	
	// Processing form data when form is submitted
	if ($_SERVER["REQUEST_METHOD"] == "POST") {
		
		// Define variables and initialize with empty values
		$firstName = $_REQUEST['first-name'];
		$lastName = $_REQUEST['last-name'];
		$email = trim(strtolower($_REQUEST['email']));
		$password = $_REQUEST['password'];
		$communityName = $_REQUEST['community-name'];
		$logoImageArr = $_FILES['logo-image'];
		$logoImageName = str_replace(' ', '', strtolower($communityName)) . '-logo-' . $logoImageArr['name'];
		$logoImageSize = $logoImageArr['size'];
		$logoImageType = $logoImageArr['type'];
		$backgroundImageArr = $_FILES['background-image'];
		$backgroundImageName = str_replace(' ', '', strtolower($communityName)) . '-background-' . $backgroundImageArr['name'];
		$backgroundImageSize = $backgroundImageArr['size'];
		$backgroundImageType = $backgroundImageArr['type'];
		$errorMessageObj = new stdClass();
		
		// Validate username
		if (empty(trim($firstName))) {
			$errorMessageObj->message = "Please enter a first name.";
		}
		elseif (empty(trim($lastName))) {
			$errorMessageObj->message = "Please enter a last name.";
		}
		elseif (empty(trim($email))) {
			$errorMessageObj->message = "Please enter an email.";
		}
		elseif (empty(trim($password))) {
			$errorMessageObj->message = "Please enter a password.";
		} elseif (strlen(trim($password)) < 8) {
			$errorMessageObj->message = "Password must have at least 8 characters.";
		}
		elseif (trim(empty($communityName))) {
			$errorMessageObj->message = "Please enter a community name.";
		}
		elseif ($logoImageSize > 2097152) {
			$errorMessageObj->message = "The logo file is too large. Please upload images less than 2MB.";
		}
		elseif ($logoImageType != "image/png") {
			$errorMessageObj->message = "The logo file is too large. Please upload images less than 2MB.";
		}
		elseif ($backgroundImageSize > 2097152) {
			$errorMessageObj->message = "The background file is too large. Please upload images less than 2MB.";
		}
		elseif ($backgroundImageType != "image/png") {
			$errorMessageObj->message = "The logo file is too large. Please upload images less than 2MB.";
		}
		else {
			// Prepare a select statement
			$sql = "SELECT ID, COMMUNITY_NAME FROM USER WHERE EMAIL = ?";
			
			if ($stmt = $con->prepare($sql)) {
				// Bind variables to the prepared statement as parameters
				$stmt->bind_param("s", $paramEmail);
				
				// Set parameters
				$paramEmail = trim($email);
				
				// Attempt to execute the prepared statement
				if ($stmt->execute()) {
					// store result
					$result = $stmt->store_result();
					
					if ($stmt->num_rows == 1) {
						$errorMessageObj->message = "Account with that email already exists.";
					} elseif(str_replace(' ', '', strtolower($result['COMMUNITY_NAME'])) == str_replace(' ', '', strtolower($communityName))) {
						$errorMessageObj->message = "A community with that name already exists.";
					}
				} else {
					$errorMessageObj->message = "Oops! Something went wrong. Please try again later.";
				}
				
				// Close statement
				$stmt->close();
			}
		}
		
		// Validate confirm password
		if (empty(trim($_REQUEST["confirm_password"]))) {
			$confirm_password_err = "Please confirm password.";
		} else {
			$confirm_password = trim($_REQUEST["confirm_password"]);
			if (empty($password_err) && ($password != $confirm_password)) {
				$confirm_password_err = "Password did not match.";
			}
		}
		
		//		$error = "test";
		
		// Check input errors before inserting in database
		if (empty($error)) {
			
			// Prepare an insert statement
			$userSql = "INSERT INTO USER (FIRST_NAME, LAST_NAME, EMAIL, PASSWORD, COMMUNITY_NAME, GUID) VALUES (?, ?, ?, ?, ?, ?)";
			
			if ($userStatement = $con->prepare($userSql)) {
				// Bind variables to the prepared statement as parameters
				$userStatement->bind_param("sssssi", $paramFirstName, $paramLastName, $paramEmail, $paramPassword, $paramCommunityName, $paramUserGuid);
				
				// Set parameters
				$paramFirstName = $firstName;
				$paramLastName = $lastName;
				$paramEmail = $email;
				$paramPassword = password_hash($password, PASSWORD_DEFAULT); // Creates a password hash
				$paramCommunityName = $communityName;
				$paramUserGuid = uniqid('usr_'); // Creates a unique User GUID
				
				// Attempt to execute the prepared statement
				if ($userStatement->execute()) {
					// The newly inserted User ID.
					$userId = $userStatement->insert_id;
					
					$profileSql = "INSERT INTO PROFILE (TITLE, LOGO_IMAGE, BACKGROUND_IMAGE, BIOGRAPHY, GUID, USER_ID) VALUES (?, ?, ?, ?, ?, ?)";
					
					if ($profileStatement = $con->prepare($profileSql)) {
						
						$profileStatement->bind_param("ssssi", $paramTitle, $paramLogoImage, $paramBackgroundImage, '', $paramProfileGuid, $paramUserId);
						
						// Set parameters
						$paramTitle = 'Welcome to ' . $communityName;
						$paramLogoImage = 'images/' . $logoImageName;
						$paramBackgroundImage = 'images/' . $backgroundImageName;
						$paramProfileGuid = uniqid('prof_'); // Creates a unique Profile GUID.
						$paramUserId = $userId;
						
						// Try execute of profile creation.
						if ($profileStatement->execute()) {
							
							// Create the social media account references.
							for ($i = 1; $i <= 6; $i++) {
								
								$profileSocialSql = "INSERT INTO PROFILE_SOCIAL_REF (SOCIAL_ID, PROFILE_ID, URL, ENABLED) VALUES (?, ?, ?, ?, ?, ?)";
								
								if($profileSocialStatement = $con->prepare($profileSocialSql)) {
									// The newly inserted Profile ID
									$profileId = $profileStatement->insert_id;
									
									$profileSocialStatement->bind_param('iisi', $paramSocialId, $paramProfileId, $paramUrl, $paramEnabled);
									
									// Set the Profile Social Reference parameters
									$paramSocialId = $i;
									$paramProfileId = $profileId;
									$paramUrl = '';
									$paramEnabled = 0;
									
									// Execute the profile_social_ref insert.
									// TODO :: Maybe do an if condition like the other later.
									if($profileSocialStatement->execute()) {
										// Close the statement after each insert
										$profileSocialStatement->close();
									} else {
										$errorMessageObj->message = "Something went wrong. Please try again later.";
									}
								}
							}
						} else {
							$errorMessageObj->message = "Something went wrong. Please try again later.";
						}
					} else {
						$errorMessageObj->message = "Something went wrong. Please try again later.";
					}
					
					// Close profile statement.
					$profileStatement->close();
					
				} else {
					$errorMessageObj->message = "Something went wrong. Please try again later.";
				}
				
				// Close user statement
				$userStatement->close();
				
			}
		}
		
		echo json_encode($errorMessageObj);
		
		// Close connection
		$con->close();
	}
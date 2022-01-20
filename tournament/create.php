<?php
	require_once '../config.php';
	
	if($_SERVER['REQUEST_METHOD'] === 'POST') {
		
		$alertObj = new stdClass();
		$profileId = $_REQUEST['profile-id'];
		$tournamentName = $_REQUEST['create-tournament-name'];
		$tournamentGame = $_REQUEST['create-tournament-game'];
		$tournamentType = $_REQUEST['create-tournament-type'];
		$tournamentDescription = $_REQUEST['create-tournament-description'];
		$tournamentRules = $_REQUEST['create-tournament-rules'];
		$tournamentStartDateTime = $_REQUEST['create-tournament-start-date-time'];
		$tournamentEndDateTime = $_REQUEST['create-tournament-end-date-time'];
		$tournamentEntryFee = $_REQUEST['create-tournament-entry-fee'];
		
		$tournamentSql = "INSERT INTO TOURNAMENT (NAME, DESCRIPTION, RULES, TOURNAMENT_TYPE_ID, PROFILE_ID, GAME_ID, START_DATE, END_DATE, FEE) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
		
		if ($tournamentStatement = $con->prepare($tournamentSql)) {
			// Bind variables to the prepared statement as parameters
			$tournamentStatement->bind_param("sssiiissi", $paramName, $paramDescription, $paramRules, $paramTypeId, $paramProfileId, $paramGameId, $paramStartDate, $paramEndDate, $paramEntryFee);

			$paramProfileId = $profileId;
			$paramName = $tournamentName;
			$paramGameId = $tournamentGame;
			$paramTypeId = $tournamentType;
			$paramDescription = $tournamentDescription;
			$paramRules = $tournamentRules;
			$paramStartDate = $tournamentStartDateTime;
			$paramEndDate = $tournamentEndDateTime;
			$paramEntryFee = $tournamentEntryFee;
			
			if($tournamentStatement->execute()) {
				$alertObj->messageType = 'success';
				$alertObj->message = 'Tournament was created successfully!';
			} else {
				$alertObj->messageType = 'danger';
				$alertObj->message = 'Something went wrong. Please try again later!';
			}
			
			$tournamentStatement->close();
		} else {
			$alertObj->messageType = 'danger';
			$alertObj->message = 'Something went wrong. Please try again later!';
		}
		
		echo json_encode($alertObj);
	}
	
	$con->close();
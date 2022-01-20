<?php
session_start();
unset($_SESSION['AeviWebSession']);
unset($_SESSION['AeviStreamProfileName']);
unset($_SESSION['AeviStreamUserProfile']);

echo 'You have been logged out!';
<?php

// Clearing global session variables and ending session

session_start();
session_unset();
session_destroy();

// Sending user back to the homepage

header("location: ./index.php");
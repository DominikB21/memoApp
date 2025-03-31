<?php

function cleanInput($input){
  $data = trim($input);
  $data = strip_tags($data);
  $data = htmlspecialchars($data);

  return $data;
}

if(isset($_POST["signup"])){

  // Grabbing data

  $firstName = cleanInput($_POST["firstNameInputRegister"]);
  $lastName = cleanInput($_POST["lastNameInputRegister"]);
  $email = $_POST["emailInputRegister"];
  $password = $_POST["passwordInputRegister"];
  $passwordRepeat = $_POST["passwordRepeatInputRegister"];

  // Instantiate UserController class

  include "./classes/db_connect.php";
  include "./classes/user-class.php";
  include "./controllers/user-controller.php";
  
  $signup = new UserController($firstName, $lastName, $email, $password, $passwordRepeat,"");

  // Running error handlers and signing up user

  $signup->signupUser();

  // Going back to index page

  header("location: ./index.php?error=none");

}else{
  header("location: ./index.php");
}
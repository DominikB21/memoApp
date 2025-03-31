<?php

if(isset($_POST["login"])){

  //Grabbing data

  $email = $_POST["emailInputLogin"];
  $password = $_POST["passwordInputLogin"];


  // Instantiate UserController class

  include "./classes/db_connect.php";
  include "./classes/user-class.php";
  include "./controllers/user-controller.php";
  
  $login = new UserController("","",$email, $password,"","");

  // Running error handlers and logging in user

  $login->loginUser();

  // Going back to index page

  header("location: ./index.php?error=none");

}else{
  header("location: ./index.php");
}
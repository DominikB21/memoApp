<?php
session_start();

if(isset($_SESSION["id"])){

  // Grabbing data

  $userId = $_SESSION["id"];

  // Instantiate UserController class

  include "./classes/db_connect.php";
  include "./classes/user-class.php";
  include "./controllers/user-controller.php";

  $deleteUser = new UserController("","","","","",$userId);

  // Deleting user

  $deleteUser->deleteUser();

  // Redirecting to index page

  header("location: ./index.php?userSuccesfullyDeleted");

}else{
  header("location: ./home.php");
}
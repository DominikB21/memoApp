<?php

session_start();

if(!isset($_SESSION["id"])){
  header("location: ./index.php");
}

if(isset($_POST["deleteNote"])){

  // Grabbing data

  $userId = $_SESSION["id"];
  $noteId = $_POST["noteId"];

  // Instantiate NoteController class

  include "./classes/db_connect.php";
  include "./classes/note-class.php";
  include "./controllers/note-controller.php";
  
  $noteToDelete = new NoteController($userId,"","",$noteId);

  // Removing note from db

  $noteToDelete->removeNote();

  // Going back to index page

  header("location: ./home.php?error=none");

}else{
  header("location: ./home.php");
}
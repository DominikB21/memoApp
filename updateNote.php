<?php

session_start();

if(!isset($_SESSION["id"])){
  header("location: ./index.php");
}

function cleanInput($input){
  $data = trim($input);
  $data = strip_tags($data);
  $data = htmlspecialchars($data);

  return $data;
}

if(isset($_POST["updateNote"])){

  // Grabbing & cleaning data

  $userId = $_SESSION["id"];
  $content = cleanInput($_POST["contentInput"]);
  $visibility = $_POST["radioVisibility"];
  $noteId = $_POST["noteId"];

  // Instantiate NoteController class

  include "./classes/db_connect.php";
  include "./classes/note-class.php";
  include "./controllers/note-controller.php";
  
  $updatedNote = new NoteController($userId, $content, $visibility, $noteId);

  // Adding note to db

  $updatedNote->changeNote();

  // Going back to index page

  header("location: ./home.php?error=none");

}else{
  header("location: ./home.php");
}
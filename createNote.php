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

if(isset($_POST["createNote"])){

  // Grabbing & cleaning data

  $userId = $_SESSION["id"];
  $content = cleanInput($_POST["contentInput"]);
  $visibility = $_POST["radioVisibility"];

  // Instantiate NoteController class

  include "./classes/db_connect.php";
  include "./classes/note-class.php";
  include "./controllers/note-controller.php";
  
  $newNote = new NoteController($userId, $content, $visibility, "");

  // Adding note to db

  $newNote->createNote();

  // Going back to index page

  header("location: ./home.php?error=none");

}else{
  header("location: ./home.php");
}
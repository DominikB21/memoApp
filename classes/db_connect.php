<?php

//Establishing a database connection

class DbHandler{
  
  protected function connect(){
    try {
      $username = "root";
      $password = "";

      $dbh = new PDO('mysql:host=localhost;dbname=internexmemoburycz', $username, $password);

      return $dbh;

    } catch (PDOException $e) {
      print "Error!: " . $e->getMessage() . "<br/>";
      die();
    }
  }
}

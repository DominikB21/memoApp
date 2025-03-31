<?php

class User extends DbHandler{

//---------- SIGN UP USER METHOD ----------

  protected function setUser($firstName, $lastName, $email, $password){
    $stmt = $this->connect()->prepare('INSERT INTO users(firstName, lastName, email, password) VALUES (?, ?, ?, ?);');

    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    if(!$stmt->execute(array($firstName, $lastName, $email, $hashedPassword))){
      $stmt = null;
      header("location: ../index.php?error=stmtfailed");
      exit();
    }else{
      $this->getUser($email, $password);
    }

    $stmt = null;
  }

//---------- CHECK IF USER EXISTS METHOD ----------

  protected function checkUser($email){
    $stmt = $this->connect()->prepare('SELECT id FROM users WHERE email = ?;');

    if(!$stmt->execute(array($email))){
      $stmt = null;
      header("location: ../index.php?error=stmtfailed");
      exit();
    }

    $resultCheck = false;
    if($stmt->rowCount() > 0){
      $resultCheck = false;
    }else{
      $resultCheck = true;
    }

    return $resultCheck;
  }

//---------- LOGIN USER METHOD ----------

  protected function getUser($email, $password){

    // Fetching hashed password from DB accordinng to user email

    $stmt = $this->connect()->prepare('SELECT password FROM users WHERE email = ?;');

    if(!$stmt->execute(array($email))){
      $stmt = null;
      header("location: ../index.php?error=stmtfailed");
      exit();
    }

    $loginData = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Checking if an entry exists in DB

    if(count($loginData) == 0){
      $stmt = null;
      header("location: ../index.php?loginError=userNotFound");
      exit();
    }

    // Verifying if submitted password is the same as in DB

    $checkPassword = password_verify($password, $loginData[0]["password"]);

    if(!$checkPassword){
      $stmt = null;
      header("location: ../index.php?loginError=wrongPassword");
      exit();
    }elseif($checkPassword){
      $stmt = $this->connect()->prepare('SELECT * FROM users WHERE email = ? AND password = ?;');

      if(!$stmt->execute(array($email,$loginData[0]["password"]))){
        $stmt = null;
        header("location: ../index.php?error=stmtfailed");
        exit();
      }

      // Fetching user data and creating a session

      $userData = $stmt->fetchAll(PDO::FETCH_ASSOC);

      if(count($userData) == 0){
        $stmt = null;
        header("location: ../index.php?error=userNotFound");
        exit();
      }else{
        session_start();
        $_SESSION["id"] = $userData[0]["id"];
        $_SESSION["firstName"] = $userData[0]["firstName"];
        $_SESSION["lastName"] = $userData[0]["lastName"];
        $_SESSION["email"] = $userData[0]["email"];
        $_SESSION["status"] = $userData[0]["status"];
      }

      $stmt = null;
    }

    
  }

//---------- DELETE USER METHOD ----------

  protected function deleteAccount($id){
    $stmt = $this->connect()->prepare('DELETE FROM users WHERE id = ?;');

    if(!$stmt->execute(array($id))){
      $stmt = null;
      header("location: ../index.php?error=stmtfailed");
      exit();
    }

    $stmt = null;

  }
}
<?php

class UserController extends User{

  private $firstName;
  private $lastName;
  private $email;
  private $password;
  private $passwordRepeat;
  private $userId;

  public function __construct($firstName, $lastName, $email, $password, $passwordRepeat, $userId){  
    $this->firstName = $firstName;
    $this->lastName = $lastName;
    $this->email = $email;
    $this->password = $password;
    $this->passwordRepeat = $passwordRepeat;
    $this->userId = $userId;
  }

  public function signupUser(){

    if(!$this->emptyInputSignup()){
      header("location: ../index.php?signupError=emptyInput");
      exit();
    }

    if(!$this->userExists()){
      header("location: ../index.php?signupError=userAlreadyExists");
      exit();
    }

    if(!$this->invalidName()){
      header("location: ../index.php?signupError=invalidName");
      exit();
    }

    if(!$this->invalidEmail()){
      header("location: ../index.php?signupError=invalidEmail");
      exit();
    }

    if(!$this->passwordMatch()){
      header("location: ../index.php?signupError=passwordMatch");
      exit();
    }

    $this->setUser($this->firstName, $this->lastName, $this->email, $this->password);
  }

  public function loginUser(){
    if(!$this->emptyInputLogin()){
      header("location: ../index.php?loginError=emptyInput");
      exit();
    }

    $this->getUser($this->email, $this->password);

  }

  public function deleteUser(){
    $this->deleteAccount($this->userId);
    session_unset();
    session_destroy();

  }

// -------- ERROR HANDLERS --------

// Checking for empty inputs when signing up

  private function emptyInputSignup(){
    $result = false;

    if(empty($this->firstName) || empty($this->lastName) || empty($this->email) || empty($this->password) || empty($this->passwordRepeat)){
      $result = false;
    }else{
      $result = true;
    }

    return $result;
  }

// Checking for empty inputs when logging in

  private function emptyInputLogin(){
    $result = false;

    if(empty($this->email) || empty($this->password)){
    $result = false;
    }else{
      $result = true;
    }

    return $result;
  }

// Checking for invalid first or last name


  private function invalidName(){
    $result = false;

    if(!preg_match("/^[A-Za-z\s\-.']+$/", $this->firstName) || !preg_match("/^[A-Za-z\s\-.']+$/", $this->lastName)){
      $result = false;
    }else{
      $result = true;
    }

    return $result;
  }

// Checking for invalid email

  private function invalidEmail(){
    $result = false;

    if(!filter_var($this->email, FILTER_VALIDATE_EMAIL)){
      $result = false;
    }else{
      $result = true;
    }

    return $result;
  }

// Checking if passwords match

  private function passwordMatch(){
    $result = false;

    if($this->password !== $this->passwordRepeat){
      $result = false;
    }else{
      $result = true;
    }

    return $result;
  }

// Checking if user with this email already exists

  private function userExists(){
    $result = false;

    if(!$this->checkUser($this->email)){
      $result = false;
    }else{
      $result = true;
    }

    return $result;
  }

}
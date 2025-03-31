<?php

session_start();

if(isset($_SESSION["status"]) && $_SESSION["status"] == "user"){
  header("location: ./home.php");
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Memo-App</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  <link rel="icon" type="image/svg" href="https://www.svgrepo.com/show/484546/notepad.svg">
  <style>
    <?php include "style.scss"; ?>
  </style>
</head>
<body>

<!-- Navbar -->

<div id="navbar">
  <nav class="navbar bg-dark border-bottom border-bodys" data-bs-theme="dark">
    <div class="container-fluid justify-content-between">
      <a class="navbar-brand" href="./index.php">Memo-App</a>
    </div>
  </nav>
</div>

<!-- Hero section -->

<div class="d-flex justify-content-center align-items-center" id="hero">
  <h1>Welcome to my memo app!</h1>
</div>

<div class="d-flex justify-content-center userForms">
<!-- Login form -->

  <div id="loginContainer">
    <h1>Login</h1>

    <form action="./login.php" method="POST">
      <div class="mb-3">
        <label for="emailInputLogin" class="form-label">Email address</label>
        <input type="email" class="form-control" name="emailInputLogin" aria-required="true" required>
     </div>

     <div class="mb-3">
       <label for="passwordInputLogin" class="form-label">Password</label>
       <input type="password" class="form-control" name="passwordInputLogin" aria-required="true" required>
     </div>

      <button type="submit" name="login" class="btn btn-primary">Login</button>
    </form>

    <div class="errorMessageField">
    <?php
      if(!isset($_GET["loginError"])){
        echo '';
      }else{
        $loginCheck = $_GET["loginError"];

        if($loginCheck == "emptyInput"){
          echo '<p class="errorMessage mt-3">* Please fill in every input</p>';
        }elseif($loginCheck == "userNotFound"){
          echo '<p class="errorMessage mt-3">* User not found</p>';
        }elseif($loginCheck == "wrongPassword"){
          echo '<p class="errorMessage mt-3">* Wrong password</p>';
        }
      }
    ?>

  </div>
  </div>

  

<!-- Sign up form -->

  <div id="registerContainer">
    <h1>Sign up</h1>

    <form action="./signup.php" method="POST">
      <div class="mb-3">
        <label for="firstNameInputRegister" class="form-label">First name</label>
        <input type="text" class="form-control" name="firstNameInputRegister" id="firstNameInputRegister" aria-required="true" required>
      </div>

      <div class="mb-3">
        <label for="lastNameInputRegister" class="form-label">Last name</label>
        <input type="text" class="form-control" name="lastNameInputRegister" id="lastNameInputRegister" aria-required="true" required>
      </div>

      <div class="mb-3">
        <label for="emailInputRegister" class="form-label">Email address</label>
        <input type="email" class="form-control" name="emailInputRegister" id="emailInputRegister" aria-required="true" required>
     </div>

     <div class="mb-3">
       <label for="passwordInputRegister" class="form-label">Password</label>
       <input type="password" class="form-control" name="passwordInputRegister" id="passwordInputRegister" aria-required="true" required>
     </div>

     <div class="mb-3">
       <label for="passwordRepeatInputRegister" class="form-label">Repeat password</label>
       <input type="password" class="form-control" name="passwordRepeatInputRegister" id="passwordRepeatInputRegister" aria-required="true" required>
     </div>

     <button type="submit" name="signup" class="btn btn-primary">Sign up</button>
    </form>
    <div class="errorMessageField">
      <?php
        if(!isset($_GET["signupError"])){
          echo '';
        }else{
          $signupCheck = $_GET["signupError"];
  
          if($signupCheck == "emptyInput"){
            echo '<p class="errorMessage mt-3">* Please fill in every input</p>';
          }elseif($signupCheck == "userAlreadyExists"){
            echo '<p class="errorMessage mt-3">* User with this email already exists</p>';
          }elseif($signupCheck == "invalidName"){
            echo '<p class="errorMessage mt-3">* Please enter a valid name</p>';
          }elseif($signupCheck == "invalidEmail"){
            echo '<p class="errorMessage mt-3">* Please enter a valid email</p>';
          }elseif($signupCheck == "passwordMatch"){
            '<p class="errorMessage mt-3">* Passwords must match</p>';
          }
        }
      ?>
    </div>
  </div>

</div>

<div class="d-flex justify-content-center bg-dark" id="footer">
  <p class="text-light m-2">© 2025 Dominik Burycz</p>
</div>

</body>
</html>
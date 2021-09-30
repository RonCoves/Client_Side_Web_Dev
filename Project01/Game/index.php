<?php

require_once "includes/init.php";

//Register
if(isset($_POST["register"])){
  $first_name = mysqli_real_escape_string($conn, $_POST["first_name"]);
  $last_name = mysqli_real_escape_string($conn, $_POST["last_name"]);
  $username = mysqli_real_escape_string($conn, $_POST["username"]);
  $email = mysqli_real_escape_string($conn, $_POST["email"]);
  $password = mysqli_real_escape_string($conn, $_POST["password"]);
  $confirm_password = mysqli_real_escape_string($conn, $_POST["confirm_password"]);

  if(empty($first_name) || empty($last_name) || empty($username) || empty($email) || empty($password) || empty($confirm_password)){
      $error = "All * fields are required";
  }else{
      if($password !== $confirm_password){
          $error = "Passwords doesn't match";
      }else{
          $check_sql = mysqli_query($conn, "SELECT * FROM users WHERE email = '$email' or username = '$username'");
          if(mysqli_num_rows($check_sql) > 0){
              $error = "Email/Username already taken";
          }else{
              $hashed_pwd = password_hash($password, PASSWORD_DEFAULT);
              $insert_sql = mysqli_query($conn, "INSERT INTO `users`(`id`, `first_name`, `last_name`, `email`, `username`, `password`, `timestamp`) VALUES (NULL,'$first_name','$last_name','$email','$username','$hashed_pwd','$timestamp')");
              if($insert_sql){
                  $msg = "Registed Successfully! Please Login";
              }
          }
      }
  }
}


//Login
if(isset($_POST["login"])){
  $username = mysqli_real_escape_string($conn, $_POST["username"]);
  $password = mysqli_real_escape_string($conn, $_POST["password"]);

  if(empty($username) || empty($password)){
      $error = "All * fields are required";
  }else{
      $login_sql = mysqli_query($conn, "SELECT * FROM users WHERE username = '$username' OR email = '$username'");
      if(mysqli_num_rows($login_sql) > 0){
          $login_row = mysqli_fetch_array($login_sql);
          $login_password = $login_row["password"];
          $user_id = $login_row["id"];
          if(password_verify($password, $login_password)){
              $_SESSION["user_loggedin"] = $user_id;
              $msg = "Logged In Successfully";
          }else{
              $error = "Wrong password for the user";
          }
      }else{
          $error = "No username with the provided information was found";
      }
  }
}


?>

<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-F3w7mX95PdgyTmZZMECAngseQB83DfGTowi0iMjiWaeVhAn4FJkqJByhZMI3AhiU" crossorigin="anonymous">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta2/css/all.min.css" integrity="sha512-YWzhKL2whUzgiheMoBFwW8CKV4qpHQAEuvilg9FAn5VJUDwKZZxkJNuGM4XkWuk94WCrrwslk8yWNGmY1EduTA==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- JQUERY -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>

    <!-- Animate.css -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />

    <!-- Confetti -->
    <script src="confetti.js"></script>

    <title>Rock, Paper and Scissors!</title>

    <style>
      #confetti-canvas{
        position: absolute !important;
        top: 0 !important;
      }
    </style>
  </head>
  <body class="bg-dark">
    
    <?php include_once "includes/nav.inc.php";?>
    <?php
    if(isset($_SESSION["user_loggedin"])){
      require_once "pages/game.php";
    }else{
    ?>
  <div class="container">
    <div class="row">
      <div class="col-lg-5 mx-auto my-4">
        <div class="card text-center w-100 p-3 alert alert-warning">
          <h5>Please Login to start the game</h5>
          <p>To save your game progress, we request you to please login if you already have an account or register if you don't.</p>
        </div>
      </div>
    </div>
  </div>
    <?php } ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-/bQdsTh/da6pkI1MST/rWKFNjaCP5gBSY4sEBT38Q/9RBh9AH40zEOg7Hlq2THRZ" crossorigin="anonymous"></script>
  
    <script>
      $(document).ready(function(){
        $("#loginBtn").on("click", function(){
          $("#register").hide();
          $("#login").fadeIn();
        });
        $("#regBtn").on("click", function(){
          $("#login").hide();
          $("#register").fadeIn();
        });

        $(".playBtn").on("click", function(e){
          e.preventDefault();
          let play = $(this).val();
          $.ajax({
            url: "ajax/play.php",
            type: "post",
            data: {play: play},
            success: function(data){
              $("#gameResult").html(data);
            }
          })
        })
      })
    </script>
  </body>
</html>
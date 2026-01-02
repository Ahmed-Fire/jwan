<?php

session_start();
include "api/dbconnector.php";
include "includes/header.php";

if (isset($_POST["login"])) {
  $user = $_POST["username"];
  $pass = $_POST["password"];
  if (empty($user) || empty($pass)) {
    $message = '<label>All Fields are required</label>';
  } else {
    $query = "SELECT * FROM accounts WHERE username = :username AND password = :password";
    $statement = $con->prepare($query);
    $statement->execute(
      array(
        'username' => $user,
        'password' => $pass,
      )
    );
    $count = $statement->rowCount();
    if ($count > 0) {
      $_SESSION["username"] = $_POST["username"];

      $query1 = "SELECT type FROM accounts WHERE username='$user' LIMIT 1";
      // $mysqli = new mysqli("localhost", "root", "", "jwan");
      $mysqli = new mysqli("localhost", "u608995856_jwan_web", "Jwan&1980@", "u608995856_Jwan");
      $result = $mysqli->query($query1);
      while ($row = $result->fetch_assoc()) {
        $type = $row["type"];
    }
      $_SESSION["type"] = $type;

      header("location:admin.php");
    } else {
      $message = '<label>Wrong User or Password</label>';
    }
  }
}

?>
<link rel="stylesheet" href="includes/style/signin.css">
<title>Login</title>
</head>

<body class="text-center">

  <main class="form-signin w-100 m-auto">
    <form method="POST" name="login">
      <img class="mb-4" src="assets/images/logo.png" alt="" width="200" height="200">
      <p class="h3 mb-3 display-5">Please sign in</p>
      <div class="form-floating">
        <input name="username" type="text" class="form-control" id="floatingInput" placeholder="Username">
        <label for="floatingInput">Username</label>
      </div>
      <div class="form-floating">
        <input name="password" type="password" class="form-control mt-3" id="floatingPassword" placeholder="Password">
        <label for="floatingPassword">Password</label>
      </div>
      <br>
      <?php
      if (isset($message)) {
        echo '<div class="mx-auto" style="">
                    <h4><span class="badge rounded-pill bg-danger text-center">' . $message . '</span></h4>
                    </div><br>';
      }
      ?>
      <button name="login" class="w-100 btn btn-lg btn-primary" type="submit">Sign in <i class="bi bi-box-arrow-in-right"></i></button>
      <a href="index.php" class="w-100 btn btn-lg btn-secondary mt-3"><i class="bi bi-box-arrow-left"></i> Go To Back</a>
      <p class="mt-5 mb-3 text-muted">© 2023–2024</p>
    </form>
  </main>

  <?php include 'includes/footer.php'; ?>

<?php

session_start();
include "../api/dbconnector.php";
include "../includes/header.php";

if(isset($_POST["login"])){
    $user = $_POST["username"];
    $pass = $_POST["password"];
    if(empty($user) || empty($pass)){
        $message = '<label>All Fields are required</label>';
    }else{
        $query = "SELECT * FROM accounts WHERE username = :username AND password = :password";
        $statement = $con->prepare($query);
        $statement->execute(
            array(
                'username' => $user,
                'password' => $pass,
            )
        );
        $count = $statement->rowCount();
        if($count > 0){
            $_SESSION["username"] = $_POST["username"];
            header("location:../admin.php");
        }else{
            $message = '<label>Wrong User or Password</label>';
        }
    }
}

if(isset($_POST['logout'])) {
    session_destroy();
    unset($_SESSION['username']);
    header('location:../login.php');
}

?>
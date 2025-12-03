<?php
date_default_timezone_set('Asia/Baghdad');
session_start();
$username=$_SESSION['username'];
$date = date("Y/m/d - h:i:s");
include "dbconnector.php";

if(isset($_POST['adduser'])){
    $name = $_POST['name'];
    $user = $_POST['user'];
    $pass = $_POST['pass'];
    $phone = $_POST['phone'];
    $type = $_POST['utype'];
    $stmt=$con->prepare("INSERT INTO accounts (username, password, name, phone, type) VALUES (?,?,?,?,?)");
    $stmt->execute(array($user,$pass,$name,$phone, $type));
    header("location: ../users.php");
}


if (isset($_POST['del_user'])) {
    $id = $_POST['delete_id'];

    $sql = "DELETE FROM accounts WHERE ID=?";
    $stmt = $con->prepare($sql);
    $stmt->execute([$id]);

    header("location: ../users.php");
}

if (isset($_POST['edituser'])) {
    $ID = $_POST['edit_id'];
    $name = $_POST['name'];
    $user = $_POST['users'];
    $pass = $_POST['pass'];
    $phone = $_POST['phone'];
    $type = $_POST['utype'];

        $sql = "UPDATE accounts SET name=?, phone=?, username=?, password=?, type=? WHERE id=?";
        $stmt = $con->prepare($sql);
        $stmt->execute([$name, $phone, $user, $pass, $type, $ID]);
        echo "<script>alert('User account updated!')</script>";
        header("location: ../users.php");
    
}

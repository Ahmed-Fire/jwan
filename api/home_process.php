<?php
session_start();
$username=$_SESSION['username'];
$date = date("Y/m/d");
$time = date("H:i:s");
include "dbconnector.php";

if(isset($_POST['addslide'])){
    $tname = $_POST['tname'];
    $lname = $_POST['lname'];
    $img = $_FILES['imgsrc']['name'];
    $target="../assets/images/slideshow/".basename($img);
    $stmt=$con->prepare("INSERT INTO slideshow (type, location, img_path) VALUES (?,?,?)");
    $stmt->execute(array($tname,$lname,$img));
    move_uploaded_file($_FILES['imgsrc']["tmp_name"],$target);
    header("location: ../admin.php");
}

if (isset($_POST['edit_slide'])) {
    $ID = $_POST['edit_id'];
    $previous = $_POST['previous'];
    $tname = $_POST['type'];
    $lname = $_POST['loc'];
    $img = $_FILES['editimgsrc']['name'];
    $image_temp = $_FILES['editimgsrc']['tmp_name'];
    $exp = explode(".", $img);
    $end = end($exp);
    //if (!is_dir("./upload"))
    //mkdir("upload");
    $path = "../assets/images/slideshow/" . $img;
    $allowed_ext = array("gif", "jpg", "jpeg", "png");
    if (in_array($end, $allowed_ext)) {
        if (unlink("../assets/images/slideshow/" . $previous)) {
            if (move_uploaded_file($image_temp, $path)) {
                $sql = "UPDATE slideshow SET type=?, location=?, img_path=? WHERE id=?";
                $stmt = $con->prepare($sql);
                $stmt->execute([$tname, $lname, $img, $ID]);
                header("location: ../admin.php");
            }
        }
    } else {
        $sql = "UPDATE slideshow SET type=?, location=? WHERE id=?";
        $stmt = $con->prepare($sql);
        $stmt->execute([$tname, $lname, $ID]);
        echo "<script>alert('User account updated!')</script>";
        header("location: ../admin.php");
    }
}


if (isset($_POST['edit_lp'])) {
    $ID = $_POST['edit_id'];
    $previous = $_POST['previous'];
    $tname = $_POST['lpname'];
    $lpdes = $_POST['lp_des'];
    $img = $_FILES['editimgsrc']['name'];
    $image_temp = $_FILES['editimgsrc']['tmp_name'];
    $exp = explode(".", $img);
    $end = end($exp);
    $path = "../assets/images/latestproduct/" . $img;
    $allowed_ext = array("gif", "jpg", "jpeg", "png");
    if (in_array($end, $allowed_ext)) {
        if (unlink("../assets/images/latestproduct/" . $previous)) {
            if (move_uploaded_file($image_temp, $path)) {
                $sql = "UPDATE latest_product SET p_name=?, p_img=?, p_des=? WHERE id=?";
                $stmt = $con->prepare($sql);
                $stmt->execute([$tname, $img, $lpdes, $ID]);
                header("location: ../admin.php");
            }
        }
    } else {
        $sql = "UPDATE latest_product SET p_name=?, p_des=? WHERE id=?";
        $stmt = $con->prepare($sql);
        $stmt->execute([$tname, $lpdes, $ID]);
        echo "<script>alert('User account updated!')</script>";
        header("location: ../admin.php");
    }
}

if (isset($_POST['edit_lw'])) {
    $ID = $_POST['edit_id'];
    $previous = $_POST['previous'];
    $tname = $_POST['lwname'];
    $lwdes = $_POST['lw_des'];
    $lwtype = $_POST['lwtype'];
    $lwclient = $_POST['lwclient'];
    $lwdate = $_POST['lwdate'];
    $img = $_FILES['editimgsrc']['name'];
    $image_temp = $_FILES['editimgsrc']['tmp_name'];
    $exp = explode(".", $img);
    $end = end($exp);
    $path = "../assets/images/latestwork/" . $img;
    $allowed_ext = array("gif", "jpg", "jpeg", "png");
    if (in_array($end, $allowed_ext)) {
        if (unlink("../assets/images/latestwork/" . $previous)) {
            if (move_uploaded_file($image_temp, $path)) {
                $sql = "UPDATE last_works SET p_name=?, p_img=?, p_des=?, p_type=?, c_name=?, date=? WHERE id=?";
                $stmt = $con->prepare($sql);
                $stmt->execute([$tname, $img, $lwdes, $lwtype, $lwclient, $lwdate, $ID]);
                header("location: ../admin.php");
            }
        }
    } else {
        $sql = "UPDATE last_works SET p_name=?, p_des=?, p_type=?, c_name=?, date=? WHERE id=?";
        $stmt = $con->prepare($sql);
        $stmt->execute([$tname, $lwdes, $lwtype, $lwclient, $lwdate, $ID]);
        echo "<script>alert('User account updated!')</script>";
        header("location: ../admin.php");
    }
}


if (isset($_POST['del_slide'])) {
    $id = $_POST['delete_id'];
    $img_n = $_POST['img_n'];

    $sql = "DELETE FROM slideshow WHERE ID=?";
    $stmt = $con->prepare($sql);
    $stmt->execute([$id]);
    $file_to_delete = '../assets/images/slideshow/' . $img_n;
    unlink($file_to_delete);

    header("location: ../admin.php");
}

if(isset($_POST['addlatest'])){
    $lpname = $_POST['lp_name'];
    $lpdes = $_POST['lp_des'];
    $lpimg = $_FILES['lp_img']['name'];
    $target="../assets/images/latestproduct/".basename($lpimg);
    $stmt=$con->prepare("INSERT INTO latest_product (p_name, p_img, p_des) VALUES (?,?,?)");
    $stmt->execute(array($lpname,$lpimg,$lpdes));
    move_uploaded_file($_FILES['lp_img']["tmp_name"],$target);
    header("location: ../admin.php");
}

if(isset($_POST['addlw'])){
    $lwname = $_POST['lwname'];
    $lwdes = $_POST['lw_des'];
    $lwimg = $_FILES['lwimgsrc']['name'];
    $target1="../assets/images/latestwork/".basename($lwimg);
    $lwtype = $_POST['lwtype'];
    $lwclient = $_POST['lwclient'];
    $lwcimg = $_FILES['climgsrc']['name'];
    $pdate = $_POST['pdate'];
    $target2="../assets/images/clientlogo/".basename($lwcimg);
    $stmt=$con->prepare("INSERT INTO last_works (p_name, p_des, p_img, p_type, c_name, c_logo, date) VALUES (?,?,?,?,?,?,?)");
    $stmt->execute(array($lwname,$lwdes,$lwimg,$lwtype,$lwclient,$lwcimg,$pdate));
    move_uploaded_file($_FILES['lwimgsrc']["tmp_name"],$target1);
    move_uploaded_file($_FILES['climgsrc']["tmp_name"],$target2);
    header("location: ../admin.php");
}

if (isset($_POST['del_lp'])) {
    $id = $_POST['delete_id'];
    $img_n = $_POST['img_n'];

    $sql = "DELETE FROM latest_product WHERE id=?";
    $stmt = $con->prepare($sql);
    $stmt->execute([$id]);
    $file_to_delete = '../assets/images/latestproduct/' . $img_n;
    unlink($file_to_delete);

    header("location: ../admin.php");
}

if (isset($_POST['del_lw'])) {
    $id = $_POST['delete_id'];
    $img_w = $_POST['img_w'];
    $img_c = $_POST['img_c'];

    $sql = "DELETE FROM last_works WHERE id=?";
    $stmt = $con->prepare($sql);
    $stmt->execute([$id]);
    $file_to_delete1 = '../assets/images/latestwork/' . $img_w;
    $file_to_delete2 = '../assets/images/clientlogo/' . $img_c;
    unlink($file_to_delete1);
    unlink($file_to_delete2);

    header("location: ../admin.php");
}


?>
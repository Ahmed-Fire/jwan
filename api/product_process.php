<?php
date_default_timezone_set('Asia/Baghdad');
session_start();
$username = $_SESSION['username'];
$date = date("Y/m/d - h:i:s");
include "dbconnector.php";

if (isset($_POST['addtitle'])) {
    $tname = $_POST['tname'];
    $user = $_POST['user'];
    $icon = rand(1, 99999) . '.' . end(explode(".", $_FILES["icon_name"]["name"]));
    $icon_target = "../assets/images/covers" . DIRECTORY_SEPARATOR  . basename($icon);
    $stmt = $con->prepare("INSERT INTO title (title, user, date, t_img) VALUES (?,?,?,?)");
    $stmt->execute(array($tname, $user, $date, $icon));
    if (!file_exists('../assets/images/covers' . DIRECTORY_SEPARATOR . $icon)) {
        move_uploaded_file($_FILES['icon_name']["tmp_name"], $icon_target);
        header("location: ../optadmin.php");
    } else {
        header("location: ../admin.php");
    }
}

if (isset($_POST['edittitle'])) {
    $tname = $_POST['tname'];
    $id = $_POST['edit_id'];
    $user = $_POST['user'];
    $icon = rand(1, 99999) . '.' . end(explode(".", $_FILES["icon_edit"]["name"]));
    $old = $_POST['old_icon'];
    $icon_target = "../assets/images/covers" . DIRECTORY_SEPARATOR  . basename($icon);
    $stmt = $con->prepare("UPDATE title SET title=?, user=?, date=?, t_img=? WHERE id=?");
    $stmt->execute(array($tname, $user, $date, $icon, $id));
    if (!file_exists('../assets/images/covers' . DIRECTORY_SEPARATOR . $icon)) {
        unlink("../assets/images/covers/" . DIRECTORY_SEPARATOR . $old);
        move_uploaded_file($_FILES['icon_edit']["tmp_name"], $icon_target);
        header("location: ../optadmin.php");
    } else {
        header("location: ../admin.php");
    }
}

if (isset($_POST['del_title'])) {
    $id = $_POST['delete_id'];

    $sql = "DELETE FROM title WHERE ID=?";
    $stmt = $con->prepare($sql);
    $stmt->execute([$id]);

    header("location: ../optadmin.php");
}

if (isset($_POST['addsubtitle'])) {
    $tname = $_POST['tname'];
    $title = $_POST['title'];
    $user = $_POST['user'];
    $stmt = $con->prepare("INSERT INTO subtitle (title, user, date, title_name) VALUES (?,?,?,?)");
    $stmt->execute(array($tname, $user, $date, $title));
    header("location: ../optadmin.php");
}

if (isset($_POST['del_subtitle'])) {
    $id = $_POST['delete_subid'];

    $sql = "DELETE FROM subtitle WHERE id=?";
    $stmt = $con->prepare($sql);
    $stmt->execute([$id]);

    header("location: ../optadmin.php");
}

if (isset($_POST['editsubtitle'])) {
    $tname = $_POST['tname'];
    $title = $_POST['title'];
    $id = $_POST['edit_id'];
    $user = $_POST['user'];
    $stmt = $con->prepare("UPDATE subtitle SET title=?, user=?, date=?, title_name=? WHERE id=?");
    $stmt->execute(array($tname, $user, $date, $title, $id));
    header("location: ../optadmin.php");
}

if (isset($_POST['addpro'])) {
    $pname = $_POST['pname'];
    $psize = $_POST['psize'];
    $pdes = $_POST['pdes'];
    $pkey = $_POST['pkey'];
    $ptype = $_POST['ptype'];
    $user = $_POST['user'];
    $ppart = 'Default';
    $stmt = $con->prepare("INSERT INTO products (p_name, p_size, p_description, p_keyword, p_type, p_part, p_user, p_date) VALUES (?,?,?,?,?,?,?,?)");
    $stmt->execute(array($pname, $psize, $pdes, $pkey, $ptype, $ppart, $user, $date));
    header("location: ../proadmin.php");
}

if (isset($_POST['addimg'])) {
    $pside = $_POST['pside'];
    $pkey = $_POST['pkey'];
    $fname = $_POST['fname'];

    $img_target_dir = "../assets/images/products" . DIRECTORY_SEPARATOR . $fname . DIRECTORY_SEPARATOR;

    if (!file_exists($img_target_dir)) {
        mkdir($img_target_dir, 0777, true);
    }

    foreach ($_FILES['pimg']['name'] as $key => $val) {
        $img_name = rand(1, 99999) . '.' . end(explode(".", $_FILES["pimg"]["name"][$key]));
        $img_tmp_name = $_FILES['pimg']['tmp_name'][$key];
        $img_target_file = $img_target_dir . basename($img_name);

        if (move_uploaded_file($img_tmp_name, $img_target_file)) {
            $stmt = $con->prepare("INSERT INTO product_images (img_name, img_key, img_type) VALUES (?,?,?)");
            $stmt->execute(array($img_name, $pkey, $pside));
        }
    }

    header("location: ../proadmin.php");
}

if (isset($_POST['editproduct'])) {
    $pname = $_POST['pname'];
    $old_f = $_POST['old_f'];
    $psize = $_POST['psize'];
    $id = $_POST['edit_id'];
    $user = $_POST['user'];
    $pdes = $_POST['pdes'];
    $pkey = $_POST['pkey'];
    $ptype = $_POST['ptype'];
    $ppart = $_POST['ppart'];
    $ctype = $_POST['current_type'];
    $cpart = $_POST['current_part'];

    $stmt = $con->prepare("UPDATE products SET p_name=?, p_size=?, p_description=?, p_keyword=?, p_type=?, p_part=?, p_user=?, p_date=? WHERE id=?");
    $stmt->execute(array($pname, $psize, $pdes, $pkey, $ptype, $ppart, $user, $date, $id));


    $old_folder = "../assets/images/products" . DIRECTORY_SEPARATOR . $old_f;
    $new_folder = "../assets/images/products" . DIRECTORY_SEPARATOR . $pname;
    rename("$old_folder", "$new_folder");

    header("location: ../proadmin.php");
}

if (isset($_POST['update_image'])) {
    $img_id = $_POST['img_id'];
    //$img_namee = $_FILES['img_name']['tmp_name'];
    $img_name = rand(1, 99999) . '.' . end(explode(".", $_FILES["img_name"]["name"]));
    $old = $_POST['old_img'];
    $f_name = $_POST['f_name'];
    $i_type = $_POST['img_type'];
    $img_target = "../assets/images/products" . DIRECTORY_SEPARATOR . $f_name . DIRECTORY_SEPARATOR . basename($img_name);

    if ($_FILES['img_name']['error'] == 4 || ($_FILES['img_name']['size'] == 0 && $_FILES['img_name']['error'] == 0)) {
        $stmt = $con->prepare("UPDATE product_images SET img_type=? WHERE id=?");
        $stmt->execute(array($i_type, $img_id));
        header("location: ../proadmin.php");
    } else {
        if ($i_type == "") {
            $i_type = "Back";
            if (!file_exists('../assets/images/products' . DIRECTORY_SEPARATOR . $f_name . DIRECTORY_SEPARATOR . $img_name)) {
                $stmt = $con->prepare("UPDATE product_images SET img_name=?, img_type=? WHERE id=?");
                $stmt->execute(array($img_name, $i_type, $img_id));
                move_uploaded_file($_FILES['img_name']['tmp_name'], $img_target);
                unlink("../assets/images/products" . DIRECTORY_SEPARATOR . $f_name . DIRECTORY_SEPARATOR . $old);
                header("location: ../proadmin.php");
            } else {
                header("location: ../proadmin.php");
            }
        } else {
            header("location: ../proadmin.php");
        }
    }
}

if (isset($_POST['del_pro'])) {
    $id = $_POST['delete_id'];
    $pkey = $_POST['pkeys'];
    $ftitle = $_POST['ftitle'];

    $sql = "DELETE FROM products WHERE id=?";
    $stmt = $con->prepare($sql);
    $stmt->execute([$id]);

    $sql1 = "DELETE FROM product_images WHERE img_key=?";
    $stmt1 = $con->prepare($sql1);
    $stmt1->execute([$pkey]);

    $dir = '../assets/images/products' . DIRECTORY_SEPARATOR . $ftitle . DIRECTORY_SEPARATOR;
    $it = new RecursiveDirectoryIterator($dir, RecursiveDirectoryIterator::SKIP_DOTS);
    $files = new RecursiveIteratorIterator(
        $it,
        RecursiveIteratorIterator::CHILD_FIRST
    );
    foreach ($files as $file) {
        if ($file->isDir()) {
            rmdir($file->getRealPath());
        } else {
            unlink($file->getRealPath());
        }
    }
    rmdir($dir);

    header("location: ../proadmin.php");
}

if (isset($_POST['del_image'])) {
    $id = $_POST['delete_img_id'];
    $imgname = $_POST['img_name'];
    $proname = $_POST['pro_name'];

    $sql1 = "DELETE FROM product_images WHERE id=?";
    $stmt1 = $con->prepare($sql1);
    $stmt1->execute([$id]);

    unlink("../assets/images/products" . DIRECTORY_SEPARATOR . $proname . DIRECTORY_SEPARATOR . $imgname);

    header("location: ../proadmin.php");
}

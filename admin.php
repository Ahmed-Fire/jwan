<?php
include 'includes/header.php';
include 'api/dbconnector.php';

//to hide all error

ini_set('display_errors', 0);
ini_set('display_startup_errors', 0);
error_reporting(-1);


session_start();

if (isset($_SESSION['username']) == NULL) {
    $logined = false;
} else {
    $logined = true;
    $un = $_SESSION['username'];

    $sql = 'SELECT * FROM slideshow ORDER BY id ASC';
    $pdo_statement = $con->prepare($sql);
    $pdo_statement->execute();
    $result_h_s = $pdo_statement->fetchAll();

    $sql = 'SELECT * FROM latest_product ORDER BY id ASC';
    $pdo_statement = $con->prepare($sql);
    $pdo_statement->execute();
    $result_lp = $pdo_statement->fetchAll();

    $sql = 'SELECT * FROM last_works ORDER BY id ASC';
    $pdo_statement = $con->prepare($sql);
    $pdo_statement->execute();
    $result_lw = $pdo_statement->fetchAll();
}
?>
<title>Admin Panel</title>
</head>

<body>
    <header>
        <nav class="navbar bg-dark" data-bs-theme="dark">
            <div class="container-fluid">
                <div class="row">
                    <div class="col">
                        <div class="row text-center">
                            <div class="col-2">
                                <img src="assets/images/logo.png" alt="Logo" width="30" height="30" class="d-inline-block align-text-top">
                            </div>
                            <div class="col-10">
                                <h5 class="text-white m-1">Welcome : <?php echo ucfirst($un) ?></h5>
                            </div>
                        </div>
                    </div>
                </div>
                <button class="navbar-toggler bg-white" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbar" aria-controls="offcanvasNavbar">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasNavbar" aria-labelledby="offcanvasNavbarLabel">
                    <div class="offcanvas-header">
                        <h5 class="offcanvas-title" id="offcanvasNavbarLabel">JWAN FURNITURE</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                    </div>
                    <p class="text-white mx-auto display-6">Role : <span class="badge rounded-pill text-bg-primary"><?php echo $_SESSION['type'] ?></span></p>
                    <div class="offcanvas-body">
                        <ul class="navbar-nav justify-content-end flex-grow-1 pe-3">
                            <li>
                                <div class="container text-center">
                                    <div class="row row-cols-3 row-cols-lg-5">
                                        <div class="col">
                                            <h4 class="text-warning"><i class="bi bi-sun-fill"></i></h4>
                                        </div>
                                        <div class="col">
                                            <div class="form-check form-switch form-switch-md">
                                                <input type="checkbox" class="form-check-input bg-primary" id="darkSwitch" />
                                            </div>
                                        </div>
                                        <div class="col">
                                            <h4 class="sky"><i class="bi bi-moon-fill"></i></h4>
                                        </div>
                                    </div>
                                </div>

                            </li>
                            <li class="nav-item">
                                <a class="nav-link active" aria-current="page" href="admin.php">Home</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="proadmin.php">Products</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="optadmin.php">Options</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="users.php">Users</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="index.php">Go To First Page</a>
                            </li>
                        </ul>
                        <?php if ($logined) {
                            echo '
                        <form method="post" action="api/login_process.php">
                            <button class="btn btn-danger" name="logout" type="submit"><i class="bi bi-person-fill-down"></i> Logout</button>
                        </form>';
                        } else {
                            echo '<a href="login.php" class="btn btn-primary"><i class="bi bi-person-fill-up"></i> Login</a>';
                        } ?>
                    </div>
                </div>
            </div>
        </nav>
    </header>

    <div class="container py-4">
        <div class="p-5 mb-4 bg-light rounded-4 border border-5 border-primary-subtle">
            <div class="container-fluid">
                <h1 class="display-5 fw-bold">Home Screen</h1>
                <div>
                    <div class="p-5 mb-4 bg-light rounded-4 border border-5 border-warning shadow">
                        <div class="container-fluid">
                            <h1 class="display-6 fw-bold">Slideshow Part</h1>
                            <button type="button" class="btn btn-primary my-2" data-bs-toggle="modal" data-bs-target="#addslide"><i class="bi bi-plus-square"></i> Add</button>
                            <div class="table-responsive border border-1 border-dark p-2">
                                <table class="table table-bordered border-primary border-1 table-responsive">
                                    <thead>
                                        <tr>
                                            <th scope="col-1">#</th>
                                            <th scope="col-3">Type Name</th>
                                            <th scope="col-3">Loaction</th>
                                            <th scope="col-3">Image Path</th>
                                            <th scope="col-2">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody class="table-group-divider">
                                        <?php if ($logined) {
                                            if (!empty($result_h_s)) {
                                                foreach ($result_h_s as $row) {
                                                    echo '
                                        <tr>
                                            <td scope="row" class="col">' . $i = $i + 1 . '</td>
                                            <td class="col">' . $row['type'] . '</td>
                                            <td class="col">' . $row['location'] . '</td>
                                            <td class="col">' . $row['img_path'] . '</td>
                                            <td class="col-4">
                                                <div class="d-grid gap-2 mx-auto">
                                                    <div class="row">
                                                        <div class="col">
                                                            <button type="button" class="btn btn-success btn-sm w-100" type="button" data-bs-toggle="modal" data-bs-target="#editslide' . $row['id'] . '"><i class="bi bi-pencil-square"></i> Edit</button>
                                                        </div>
                                                        <div class="col">
                                                            <button class="btn btn-danger btn-sm w-100 delete_s"><i class="bi bi-trash3-fill"></i> Delete</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="col" style="display: none;">' . $row['id'] . '</td>
                                        </tr>
                                        ';
                                                }
                                            }
                                        } ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="p-5 mb-4 bg-light rounded-4 border border-5 border-warning">
                        <div class="container-fluid">
                            <h1 class="display-6 fw-bold">Latest Product Part</h1>
                            <button type="button" class="btn btn-primary my-2" data-bs-toggle="modal" data-bs-target="#addlatest"><i class="bi bi-plus-square"></i> Add</button>
                            <div class="table-responsive border border-1 border-dark p-2">
                                <table class="table table-bordered border-primary border-1 table-responsive">
                                    <thead>
                                        <tr>
                                            <th scope="col">#</th>
                                            <th scope="col">Product Name</th>
                                            <th scope="col">Product Description</th>
                                            <th scope="col">Image Name</th>
                                            <th scope="col">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php if ($logined) {
                                            if (!empty($result_lp)) {
                                                foreach ($result_lp as $row) {
                                                    $i = 1;
                                                    $n = $i++;
                                                    echo '
                                        <tr>
                                            <td scope="row" class="col">' . $n . '</td>
                                            <td class="col">' . $row['p_name'] . '</td>
                                            <td class="col">' . substr("$row[p_des]", 0, 10) . '...</td>
                                            <td class="col">' . substr("$row[p_img]", 0, 10) . '...</td>
                                            <td class="col-4">
                                                <div class="d-grid gap-2 mx-auto">
                                                    <div class="row">
                                                        <div class="col">
                                                            <button type="button" class="btn btn-success btn-sm w-100" type="button" data-bs-toggle="modal" data-bs-target="#editlp' . $row['id'] . '"><i class="bi bi-pencil-square"></i> Edit</button>
                                                        </div>
                                                        <div class="col">
                                                            <button class="btn btn-danger btn-sm w-100 delete_lp"><i class="bi bi-trash3-fill"></i> Delete</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="col" style="display: none">' . $row['id'] . '</td>
                                            <td class="col" style="display: none">' . $row['p_img'] . '</td>
                                        </tr>
                                        ';
                                                }
                                            }
                                        } ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="p-5 mb-4 bg-light rounded-4 border border-5 border-warning">
                        <div class="container-fluid">
                            <h1 class="display-6 fw-bold">Last Work Part</h1>
                            <button type="button" class="btn btn-primary my-2" data-bs-toggle="modal" data-bs-target="#addlw"><i class="bi bi-plus-square"></i> Add</button>
                            <div class="table-responsive border border-1 border-dark p-2">
                                <table class="table table-bordered border-primary border-1 table-responsive">
                                    <thead>
                                        <tr>
                                            <th scope="col">#</th>
                                            <th scope="col">Project Name</th>
                                            <th scope="col">Description</th>
                                            <th scope="col">Project Image</th>
                                            <th scope="col">Type</th>
                                            <th scope="col">Client Name</th>
                                            <th scope="col">Client Logo</th>
                                            <th scope="col">Date</th>
                                            <th scope="col">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php if ($logined) {
                                            if (!empty($result_lw)) {
                                                foreach ($result_lw as $row) {
                                                    echo '
                                        <tr>
                                            <td scope="row" class="col-1">' . $i = $i + 1 . '</td>
                                            <td class="col">' . $row['p_name'] . '</td>
                                            <td class="col">' . substr("$row[p_des]", 0, 10) . '...</td>
                                            <td class="col">' . substr("$row[p_img]", 0, 10) . '...</td>
                                            <td class="col">' . $row['p_type'] . '</td>
                                            <td class="col">' . $row['c_name'] . '</td>
                                            <td class="col">' . substr("$row[c_logo]", 0, 10) . '...</td>
                                            <td class="col">' . $row['date'] . '</td>
                                            <td class="col-2">
                                                <div class="d-grid gap-2 mx-auto">
                                                    <div class="row">
                                                        <div class="col">
                                                            <button type="button" class="btn btn-success btn-sm w-100" type="button" data-bs-toggle="modal" data-bs-target="#editlw' . $row['id'] . '"><i class="bi bi-pencil-square"></i> Edit</button>
                                                        </div>
                                                        <div class="col">
                                                        <button class="btn btn-danger btn-sm w-100 delete_lw">Delete</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="col" style="display: none;">' . $row['id'] . '</td>
                                            <td class="col" style="display: none;">' . $row['p_img'] . '</td>
                                            <td class="col" style="display: none;">' . $row['c_logo'] . '</td>
                                        </tr>
                                        ';
                                                }
                                            }
                                        } ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Add Modal -->
    <div class="modal fade" id="addslide" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel"><i class="bi bi-image text-danger"></i> Slideshow</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div id="sizealert"></div>
                    <form action="api/home_process.php" method="POST" enctype="multipart/form-data">
                        <div class="modal-body">

                            <div class="mb-3">
                                <label>Type Name</label>
                                <input type="text" name="tname" class="form-control" placeholder="Enter Type Name">
                            </div>
                            <div class="mb-3">
                                <label>Location</label>
                                <input type="text" name="lname" class="form-control" placeholder="Enter Location">
                            </div>
                            <div class="mb-3">
                                <label for="formFile" class="form-label">Choose Image</label>
                                <input name="imgsrc" class="form-control bg-secondary text-white" type="file" id="input" accept="image/png, image/jpeg, image/webp">
                            </div>
                        </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" name="addslide" class="btn btn-primary">Add Slideshow</button>
                </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="addlatest" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel"><i class="bi bi-box-seam-fill"></i> Latest Product</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div id="AddLP"></div>
                    <form action="api/home_process.php" method="POST" enctype="multipart/form-data">
                        <div class="modal-body">

                            <div class="mb-3">
                                <label>Product Name</label>
                                <input type="text" name="lp_name" class="form-control" placeholder="Enter Product Name">
                            </div>
                            <div class="mb-3">
                                <label for="exampleFormControlTextarea1" class="form-label">Product Description</label>
                                <textarea type="text" name="lp_des" class="form-control" id="exampleFormControlTextarea1" placeholder="Enter Description" rows="3"></textarea>
                            </div>
                            <div class="mb-3">
                                <label for="formFile" class="form-label text-white">Choose Image</label>
                                <input name="lp_img" class="form-control bg-secondary text-white" type="file" id="input_add_lp" accept="image/png, image/jpeg, image/webp">
                            </div>
                        </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" name="addlatest" class="btn btn-primary">Add Product</button>
                </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="addlw" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel"><i class="bi bi-person-fill-gear text-danger"></i> Latest Work</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="api/home_process.php" method="POST" enctype="multipart/form-data">
                        <div class="modal-body">
                            <div id="LWADD"></div>
                            <div id="AddCL"></div>
                            <div class="mb-3">
                                <label>Product Name</label>
                                <input type="text" name="lwname" class="form-control" placeholder="Enter Product Name">
                            </div>
                            <div class="mb-3">
                                <label for="exampleFormControlTextarea1" class="form-label">Product Description</label>
                                <textarea type="text" name="lw_des" class="form-control" id="exampleFormControlTextarea1" placeholder="Enter Description" rows="3"></textarea>
                            </div>
                            <div class="mb-3">
                                <label for="formFile" class="form-label">Choose Image</label>
                                <input name="lwimgsrc" class="form-control bg-secondary text-white" type="file" id="input_add_lw" accept="image/png, image/jpeg, image/webp">
                            </div>
                            <div class="mb-3">
                                <label>Product Type</label>
                                <input type="text" name="lwtype" class="form-control" placeholder="Enter Product Type">
                            </div>
                            <div class="mb-3">
                                <label>Client Name</label>
                                <input type="text" name="lwclient" class="form-control" placeholder="Enter Client">
                            </div>
                            <div class="mb-3">
                                <label for="formFile" class="form-label">Choose Client Logo</label>
                                <input name="climgsrc" class="form-control bg-secondary text-white" type="file" id="input_add_cl" accept="image/png, image/jpeg, image/webp">
                            </div>
                            <div class="input-group mb-3 dp" id="dp">
                                <span class="input-group-text" id="basic-addon1"><i class="bi bi-calendar3 dp"></i></span>
                                <input type="date" class="form-control dp" placeholder="Username" name="pdate">
                            </div>
                        </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" name="addlw" class="btn btn-primary">Add Work</button>
                </div>
                </form>
            </div>
        </div>
    </div>

    <?php
    if (!empty($result_h_s)) {
        foreach ($result_h_s as $row) {
    ?>
            <div class="modal fade" id="editslide<?php echo $row['id'] ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">

                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Edit <?php echo $row['type'] ?></h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>

                        <form action="api/home_process.php" method="POST" enctype="multipart/form-data">
                            <div class="modal-body">
                                <div id="sizeEditAlert"></div>
                                <input type="hidden" name="img_n" id="img_n">
                                <div class="d-flex justify-content-center">
                                    <div class="col-md-8">
                                        <div class="form-group">
                                            <h3>Current Photo</h3>
                                            <div class="bg-image hover-zoom">
                                                <img class="rounded" src="assets/images/slideshow/<?php echo $row['img_path']; ?>" width="50%" />
                                            </div>
                                            <input type="hidden" name="previous" value="<?php echo $row['img_path'] ?>" />
                                            <hr>
                                            <h3>New Photo</h3>
                                            <input type="file" class="form-control" name="editimgsrc" accept="image/png, image/jpeg, image/webp" id="input_e" />
                                        </div>
                                        <div class="form-group">
                                            <label>Name</label>
                                            <input type="hidden" name="edit_id" value="<?php echo $row['id'] ?>" name="id" />
                                            <input type="text" class="form-control" value="<?php echo $row['type'] ?>" name="type" required="required" />
                                        </div>
                                        <div class="form-group">
                                            <label>Location</label>
                                            <input type="text" class="form-control" value="<?php echo $row['location'] ?>" name="loc" required="required" />
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                                <button type="submit" name="edit_slide" class="btn btn-warning">Update</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
    <?php
        }
    }
    ?>

    <?php
    if (!empty($result_lp)) {
        foreach ($result_lp as $row) {
    ?>
            <div class="modal fade" id="editlp<?php echo $row['id'] ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">

                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Edit <?php echo $row['p_name'] ?></h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>

                        <form action="api/home_process.php" method="POST" enctype="multipart/form-data">
                            <div class="modal-body">
                                <input type="hidden" name="edit_id" value="<?php echo $row['id'] ?>" name="id" />
                                <input type="hidden" name="previous" value="<?php echo $row['p_img'] ?>" />
                                <div id="EditLP"></div>
                                <div class="d-flex justify-content-center">
                                    <div class="col-md-8">
                                        <div class="form-group">
                                            <h3>Current Photo</h3>
                                            <div class="bg-image hover-zoom">
                                                <img class="rounded" src="assets/images/latestproduct/<?php echo $row['p_img']; ?>" width="50%" />
                                            </div>
                                            <hr>
                                            <h3>New Photo</h3>
                                            <input type="file" class="form-control" name="editimgsrc" id="input_edit_lp" accept="image/png, image/jpeg, image/webp" />
                                        </div>
                                        <div class="form-group">
                                            <label>Name</label>
                                            <input type="text" class="form-control" value="<?php echo $row['p_name'] ?>" name="lpname" required="required" />
                                        </div>
                                        <div class="form-group">
                                            <label>Description</label>
                                            <textarea type="text" name="lp_des" class="form-control" id="exampleFormControlTextarea1" rows="3"><?php echo $row['p_des'] ?></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                                <button type="submit" name="edit_lp" class="btn btn-warning">Update</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
    <?php
        }
    }
    ?>

    <?php
    if (!empty($result_lw)) {
        foreach ($result_lw as $row) {
    ?>
            <div class="modal fade" id="editlw<?php echo $row['id'] ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">

                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Edit <?php echo $row['p_name'] ?></h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>

                        <form action="api/home_process.php" method="POST" enctype="multipart/form-data">
                            <div class="modal-body">
                                <input type="hidden" name="edit_id" value="<?php echo $row['id'] ?>" />
                                <input type="hidden" name="previous" value="<?php echo $row['p_img'] ?>" />
                                <div id="LWEdit"></div>
                                <div id="EditCL"></div>
                                <div class="d-flex justify-content-center">
                                    <div class="col-md-8">
                                        <div class="form-group">
                                            <h3>Current Photo</h3>
                                            <div class="bg-image hover-zoom">
                                                <img class="rounded" src="assets/images/latestwork/<?php echo $row['p_img']; ?>" width="50%" />
                                            </div>
                                            <hr>
                                            <h3>New Photo</h3>
                                            <input type="file" class="form-control" name="editimgsrc" id="input_edit_lw" accept="image/png, image/jpeg, image/webp" />
                                        </div>
                                        <div class="form-group">
                                            <label>Project Name</label>
                                            <input type="text" class="form-control" value="<?php echo $row['p_name'] ?>" name="lwname" required="required" />
                                        </div>
                                        <div class="form-group">
                                            <label>Description</label>
                                            <textarea type="text" name="lw_des" class="form-control" id="exampleFormControlTextarea1" rows="3"><?php echo $row['p_des'] ?></textarea>
                                        </div>
                                        <div class="form-group">
                                            <label>Type</label>
                                            <input type="text" class="form-control" value="<?php echo $row['p_type'] ?>" name="lwtype" required="required" />
                                        </div>
                                        <div class="form-group">
                                            <label>Client Name</label>
                                            <input type="text" class="form-control" value="<?php echo $row['c_name'] ?>" name="lwclient" required="required" />
                                        </div>
                                        <div class="form-group">
                                            <label>Date</label>
                                            <div class="input-group dp" id="dp">
                                                <span class="input-group-text" id="basic-addon1"><i class="bi bi-calendar3 dp"></i></span>
                                                <input value="<?php echo $row['date'] ?>" type="date" class="form-control dp" placeholder="Username" name="lwdate" id="input_edit_cl">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                                <button type="submit" name="edit_lw" class="btn btn-warning">Update</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
    <?php
        }
    }
    ?>

    <div class="modal fade" id="delete_slide" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Delete Slide</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="api/home_process.php" method="POST">
                    <div class="modal-body">

                        <input type="hidden" name="delete_id" id="delete_slideid">
                        <input type="hidden" name="img_n" id="slide_img">

                        <h4>Do You Want To Delete ?</h4>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">No</button>
                        <button type="submit" name="del_slide" class="btn btn-primary">Yes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="delete_l_p" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Delete Product</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="api/home_process.php" method="POST">
                    <div class="modal-body">

                        <input type="hidden" name="delete_id" id="delete_lp">
                        <input type="hidden" name="img_n" id="lp_img">

                        <h4>Do You Want To Delete ?</h4>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">No</button>
                        <button type="submit" name="del_lp" class="btn btn-primary">Yes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="delete_l_w" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Delete Work</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="api/home_process.php" method="POST">
                    <div class="modal-body">

                        <input type="hidden" name="delete_id" id="delete_lw">
                        <input type="hidden" name="img_w" id="lw_img">
                        <input type="hidden" name="img_c" id="lwc_img">

                        <h4>Do You Want To Delete ?</h4>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">No</button>
                        <button type="submit" name="del_lw" class="btn btn-primary">Yes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script>
        $(document).ready(function() {
            $('.delete_s').on('click', function() {
                $('#delete_slide').modal('show');

                $tr = $(this).closest('tr');

                var data = $tr.children("td").map(function() {
                    return $(this).text();
                }).get();

                console.log(data);

                $('#delete_slideid').val(data[5]);
                $('#slide_img').val(data[3]);
            });
        });

        $(document).ready(function() {
            $('.delete_lp').on('click', function() {
                $('#delete_l_p').modal('show');

                $tr = $(this).closest('tr');

                var data = $tr.children("td").map(function() {
                    return $(this).text();
                }).get();

                console.log(data);

                $('#delete_lp').val(data[5]);
                $('#lp_img').val(data[6]);
            });
        });

        $(document).ready(function() {
            $('.delete_lw').on('click', function() {
                $('#delete_l_w').modal('show');

                $tr = $(this).closest('tr');

                var data = $tr.children("td").map(function() {
                    return $(this).text();
                }).get();

                console.log(data);

                $('#delete_lw').val(data[9]);
                $('#lw_img').val(data[10]);
                $('#lwc_img').val(data[11]);
            });
        });
    </script>
    <script>
        const alertPlaceholder = document.getElementById('sizealert')
        const appendAlert = (message, type) => {
            const wrapper = document.createElement('div')
            wrapper.innerHTML = [
                `<div class="alert alert-${type} alert-dismissible" role="alert">`,
                `   <div>${message}</div>`,
                '   <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>',
                '</div>'
            ].join('')

            alertPlaceholder.append(wrapper)
        }
        const uploadField = document.getElementById("input");

        uploadField.onchange = function() {
            if (this.files[0].size > 5242880) {
                //alert("File is too big!");
                appendAlert('File Size Too Big!', 'danger')
                this.value = "";

                window.setTimeout(function() {
                    $(".alert").fadeTo(500, 0).slideUp(500, function() {
                        $(this).remove();
                    });
                }, 3000);
            }
        }
        //-----------------------------------------------------------------------------------------------------------
        const alertEdit = document.getElementById('sizeEditAlert')
        const appendEditedAlert = (message, type) => {
            const wrapper = document.createElement('div')
            wrapper.innerHTML = [
                `<div class="alert alert-${type} alert-dismissible" role="alert">`,
                `   <div>${message}</div>`,
                '   <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>',
                '</div>'
            ].join('')

            alertEdit.append(wrapper)
        }
        const EditSlide = document.getElementById("input_e");

        EditSlide.onchange = function() {
            if (this.files[0].size > 5242880) {
                //alert("File is too big!");
                appendEditedAlert('File Size Too Big!', 'danger')
                this.value = "";

                window.setTimeout(function() {
                    $(".alert").fadeTo(500, 0).slideUp(500, function() {
                        $(this).remove();
                    });
                }, 3000);
            }
        }
        //-----------------------------------------------------------------------------------------------------------
    </script>
    <script>
        const alertAddLP = document.getElementById('AddLP')
        const appendLPAlert = (message, type) => {
            const wrapper = document.createElement('div')
            wrapper.innerHTML = [
                `<div class="alert alert-${type} alert-dismissible" role="alert">`,
                `   <div>${message}</div>`,
                '   <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>',
                '</div>'
            ].join('')

            alertAddLP.append(wrapper)
        }

        const AddLP = document.getElementById("input_add_lp");

        AddLP.onchange = function() {
            if (this.files[0].size > 5242880) {
                //alert("File is too big!");
                appendLPAlert('File Size Too Big!', 'danger')
                this.value = "";

                window.setTimeout(function() {
                    $(".alert").fadeTo(500, 0).slideUp(500, function() {
                        $(this).remove();
                    });
                }, 3000);
            }
        }
        //-----------------------------------------------------------------------------------------------------------
        const alertEditLP = document.getElementById('EditLP')
        const EditLPShow = (message, type) => {
            const wrapper = document.createElement('div')
            wrapper.innerHTML = [
                `<div class="alert alert-${type} alert-dismissible" role="alert">`,
                `   <div>${message}</div>`,
                '   <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>',
                '</div>'
            ].join('')

            alertEditLP.append(wrapper)
        }

        const EditLP = document.getElementById("input_edit_lp");

        EditLP.onchange = function() {
            if (this.files[0].size > 5242880) {
                //alert("File is too big!");
                EditLPShow('File Size Too Big!', 'danger')
                this.value = "";

                window.setTimeout(function() {
                    $(".alert").fadeTo(500, 0).slideUp(500, function() {
                        $(this).remove();
                    });
                }, 3000);
            }
        }
        //-----------------------------------------------------------------------------------------------------------
    </script>
    <script>
        const alertAddLW = document.getElementById('LWADD')
        const AddLWAlert = (message, type) => {
            const wrapper = document.createElement('div')
            wrapper.innerHTML = [
                `<div class="alert alert-${type} alert-dismissible" role="alert">`,
                `   <div>${message}</div>`,
                '   <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>',
                '</div>'
            ].join('')

            alertAddLW.append(wrapper)
        }

        const LWAdd = document.getElementById("input_add_lw");

        LWAdd.onchange = function() {
            if (this.files[0].size > 5242880) {
                //alert("File is too big!");
                AddLWAlert('File Size Too Big!', 'danger')
                this.value = "";

                window.setTimeout(function() {
                    $(".alert").fadeTo(500, 0).slideUp(500, function() {
                        $(this).remove();
                    });
                }, 3000);
            }
        }
        //-----------------------------------------------------------------------------------------------------------
        const alertEditLW = document.getElementById('LWEdit')
        const EditLWShow = (message, type) => {
            const wrapper = document.createElement('div')
            wrapper.innerHTML = [
                `<div class="alert alert-${type} alert-dismissible" role="alert">`,
                `   <div>${message}</div>`,
                '   <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>',
                '</div>'
            ].join('')

            alertEditLW.append(wrapper)
        }

        const EditLW = document.getElementById("input_edit_lw");

        EditLW.onchange = function() {
            if (this.files[0].size > 5242880) {
                //alert("File is too big!");
                EditLWShow('File Size Too Big!', 'danger')
                this.value = "";

                window.setTimeout(function() {
                    $(".alert").fadeTo(500, 0).slideUp(500, function() {
                        $(this).remove();
                    });
                }, 3000);
            }
        }
        //-----------------------------------------------------------------------------------------------------------
    </script>
    <script>
        const alertAddCL = document.getElementById('AddCL')
        const AddCLAlert = (message, type) => {
            const wrapper = document.createElement('div')
            wrapper.innerHTML = [
                `<div class="alert alert-${type} alert-dismissible" role="alert">`,
                `   <div>${message}</div>`,
                '   <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>',
                '</div>'
            ].join('')

            alertAddCL.append(wrapper)
        }

        const AddCL = document.getElementById("input_add_cl");

        AddCL.onchange = function() {
            if (this.files[0].size > 5242880) {
                //alert("File is too big!");
                AddCLAlert('Client Image Size Too Big!', 'warning')
                this.value = "";

                window.setTimeout(function() {
                    $(".alert").fadeTo(500, 0).slideUp(500, function() {
                        $(this).remove();
                    });
                }, 3000);
            }
        }
        //-----------------------------------------------------------------------------------------------------------
        const alertEditCL = document.getElementById('EditCL')
        const EditCLShow = (message, type) => {
            const wrapper = document.createElement('div')
            wrapper.innerHTML = [
                `<div class="alert alert-${type} alert-dismissible" role="alert">`,
                `   <div>${message}</div>`,
                '   <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>',
                '</div>'
            ].join('')

            alertEditCL.append(wrapper)
        }

        const EditCL = document.getElementById("input_edit_cl");

        EditCL.onchange = function() {
            if (this.files[0].size > 5242880) {
                //alert("File is too big!");
                EditLWShow('Client Image Size Too Big!', 'warning')
                this.value = "";

                window.setTimeout(function() {
                    $(".alert").fadeTo(500, 0).slideUp(500, function() {
                        $(this).remove();
                    });
                }, 3000);
            }
        }
        //-----------------------------------------------------------------------------------------------------------
        //1MB = 1,048,576 Bytes
    </script>
</body>




<?php include 'includes/footer.php'; ?>
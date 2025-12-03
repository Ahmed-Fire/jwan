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

    $sql = 'SELECT * FROM title ORDER BY id ASC';
    $pdo_statement = $con->prepare($sql);
    $pdo_statement->execute();
    $result_t = $pdo_statement->fetchAll();

    $sql = 'SELECT * FROM subtitle ORDER BY id ASC';
    $pdo_statement = $con->prepare($sql);
    $pdo_statement->execute();
    $result_s = $pdo_statement->fetchAll();

    $sql = 'SELECT * FROM products ORDER BY id ASC';
    $pdo_statement = $con->prepare($sql);
    $pdo_statement->execute();
    $result_p = $pdo_statement->fetchAll();

    $sql = 'SELECT * FROM product_images ORDER BY id ASC';
    $pdo_statement = $con->prepare($sql);
    $pdo_statement->execute();
    $result_i = $pdo_statement->fetchAll();
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
                                <h5 class="text-white m-1">Welcome : Ahmed Imad</h5>
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
                                <a class="nav-link" aria-current="page" href="admin.php">Home</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link active" href="proadmin.php">Products</a>
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
        <div class="p-5 mb-4 bg-light rounded-4 border border-5 border-danger-subtle">
            <div class="container-fluid">
                <h1 class="display-5 fw-bold">Products</h1>
                <div>
                    <div class="p-5 mb-4 rounded-4 border border-5 border-dark">
                        <div class="container-fluid">
                            <h1 class="display-6 fw-bold">Add Any Product in Here</h1>
                            <button type="button" class="btn btn-primary my-2" data-bs-toggle="modal" data-bs-target="#addpro"><i class="bi bi-plus-square"></i> Add</button>
                            <div class="table-responsive">
                                <table class="table table-bordered border-primary border-1 text-center">
                                    <thead>
                                        <tr>
                                            <th scope="col">#</th>
                                            <th scope="col">Product Name</th>
                                            <th scope="col">Product Size</th>
                                            <th scope="col">Product Description</th>
                                            <th scope="col">Product Type</th>
                                            <th scope="col">Product Part</th>
                                            <th scope="col">Product Keyword</th>
                                            <th scope="col">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php if (!empty($result_p)) {
                                            foreach ($result_p as $row) {
                                                echo '
                                                <tr>
                                                    <td scope="row" class="col-1">' . $i = $i + 1 . '</td>
                                                    <td class="col">' . $row['p_name'] . '</td>
                                                    <td class="col">' . $row['p_size'] . '</td>
                                                    <td class="col">
                                                        <button type="button" class="btn btn-sm btn-outline-success" data-bs-toggle="modal" data-bs-target="#descModal' . $row['id'] . '">
                                                            Show Description
                                                        </button>
                                                    </td>
                                                    <td class="col">' . $row['p_type'] . '</td>
                                                    <td class="col">' . $row['p_part'] . '</td>
                                                    <td class="col">' . $row['p_keyword'] . '</td>
                                                    <td class="col">
                                                        <div class="btn-group" role="group" aria-label="Basic outlined example">
                                                        <button type="button" class="btn btn-outline-primary btn-sm w-100" type="button" data-bs-toggle="modal" data-bs-target="#editpro' . $row['id'] . '"><i class="bi bi-pencil-square"></i> Edit</button>
                                                        <button class="btn btn-outline-dark btn-sm w-100 " data-bs-toggle="modal" data-bs-target="#editimg' . $row['id'] . '" type="button"><i class="bi bi-images"></i> Edit</button>
                                                        <button class="btn btn-outline-danger btn-sm w-100 delete_p" type="button"><i class="bi bi-trash3-fill"></i> Delete</button>
                                                        <button class="btn btn-outline-warning btn-sm w-100 p_img" type="button"><i class="bi bi-plus-square-fill"></i> Image</button>
                                                        </div>
                                                    </td>
                                                    <td class="col" style="display: none;">' . $row['id'] . '</td>
                                                </tr>
                                            ';
                                            }
                                        }
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Add Product -->
    <div class="modal fade" id="addpro" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Add New Product</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="api/product_process.php" method="POST" enctype="multipart/form-data">
                        <div class="modal-body">

                            <div class="mb-3">
                                <label>Product Name</label>
                                <input type="text" name="pname" class="form-control" placeholder="Enter Product Name">
                            </div>
                            <div class="mb-3">
                                <label>Product Size</label>
                                <input type="text" name="psize" class="form-control" placeholder="Enter Size">
                            </div>
                            <div class="mb-3">
                                <label>Product Description</label>
                                <textarea class="form-control" name="pdes" placeholder="Enter Product Description"></textarea>
                            </div>
                            <div class="mb-3">
                                <label>Product Keyword</label>
                                <input type="text" name="pkey" class="form-control" placeholder="Enter Keyword">
                            </div>
                            <div class="mb-3">
                                <label>Product Type</label>
                                <select name="ptype" class="form-select" aria-label="Default select example">
                                    <option selected disabled>Select Type</option>
                                    <?php if (!empty($result_t)) {
                                        foreach ($result_t as $rows) {
                                    ?>
                                            <option value="<?php echo $rows['title'] ?>"><?php echo $rows['title'] ?></option>
                                    <?php
                                        }
                                    }
                                    ?>
                                </select>
                            </div>
                            <input type="hidden" name="user" value="<?php echo $_SESSION['username']; ?>">
                            <div class="mb-3">
                            </div>
                        </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" name="addpro" class="btn btn-primary">Add Product</button>
                </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Add Product Image -->
    <div class="modal fade" id="pro_img" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-sm modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel"><i class="bi bi-image text-danger"></i> Add Photo</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="api/product_process.php" method="POST" enctype="multipart/form-data">
                    <div class="modal-body">
                        <div id="AddImagePro"></div>
                        <div class="mb-3">
                            <label class="form-label">Select Product Image</label>
                                                        <input class="form-control" name="pimg[]" type="file" id="input_Add_img" accept="image/png, image/jpeg, image/webp" multiple>
                        </div>
                        <div class="mb-3">
                            <select class="form-select" name="pside" aria-label="Default select example">
                                <option value="Back" selected disabled>Select Type</option>
                                <option value="Back">Back</option>
                                <option value="Front">Front</option>
                            </select>
                        </div>
                        <input type="hidden" name="pkey" id="p_key">
                        <input type="hidden" name="fname" id="f_name">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><i class="bi bi-x-octagon-fill"></i> Close</button>
                        <button type="submit" name="addimg" class="btn btn-primary"><i class="bi bi-file-earmark-plus-fill"></i> Add</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Edit Product -->
    <?php if (!empty($result_p)) {
        foreach ($result_p as $row) {
    ?>
            <div class="modal fade" id="editpro<?php echo $row['id'] ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="exampleModalLabel">Edit <?php echo $row['p_name'] ?></h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <form action="api/product_process.php" method="POST" enctype="multipart/form-data">
                            <div class="modal-body">
                                <div class="modal-body">

                                    <div class="mb-3">
                                        <label>Product Name</label>
                                        <input type="text" name="pname" class="form-control" value="<?php echo $row['p_name'] ?>">
                                    </div>
                                    <div class="mb-3">
                                        <label>Product Size</label>
                                        <input type="text" name="psize" class="form-control" value="<?php echo $row['p_size'] ?>">
                                    </div>
                                    <div class="mb-3">
                                        <label>Product Description</label>
                                        <input type="text" name="pdes" class="form-control" value="<?php echo $row['p_description'] ?>">
                                    </div>
                                    <div class="mb-3">
                                        <label>Product Keyword</label>
                                        <input type="text" name="pkey" class="form-control" value="<?php echo $row['p_keyword'] ?>">
                                    </div>
                                    <div class="mb-3">
                                        <label>Product Type</label>
                                        <select name="ptype" class="form-select" aria-label="Default select example">
                                            <option selected value="<?php echo $row['p_type'] ?>" hidden><?php echo $row['p_type'] ?></option>
                                            <?php if (!empty($result_t)) {
                                                foreach ($result_t as $rows) {
                                            ?>
                                                    <option value="<?php echo $rows['title'] ?>"><?php echo $rows['title'] ?></option>
                                            <?php
                                                }
                                            }
                                            ?>
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label>Product Part</label>
                                        <div class="input-group col-8">
                                            <span class="input-group-text" id="basic-addon1"><?php echo $row['p_type'] ?></span>
                                            <select name="ppart" class="form-select" aria-label="Default select example">
                                                <option class="text-secondary" value="<?php echo $rows['title'] ?>" selected hidden><?php echo $row['p_part'] ?></option>
                                                <?php if (!empty($result_s)) {
                                                    foreach ($result_s as $rows) if ($row['p_type'] == $rows['title_name']) { {
                                                ?>
                                                            <option value="<?php echo $rows['title'] ?>"><?php echo $rows['title'] ?></option>
                                                <?php
                                                        }
                                                    }
                                                }
                                                ?>
                                            </select>
                                        </div>

                                    </div>

                                    <input type="hidden" name="user" value="<?php echo $_SESSION['username']; ?>">
                                    <input type="hidden" name="edit_id" value="<?php echo $row['id'] ?>" />
                                    <input type="hidden" name="old_f" value="<?php echo $row['p_name'] ?>" />
                                </div>
                                <hr>
                                <div class="input-group mb-3">
                                    <span class="input-group-text bg-dark text-white" id="basic-addon1">Added By</span>
                                    <input type="text" class="form-control" value="<?php echo $row['p_user'] ?>" disabled>
                                </div>
                                <div class="input-group mb-3">
                                    <span class="input-group-text bg-dark text-white" id="basic-addon1">From</span>
                                    <input type="text" class="form-control" value="<?php echo $row['p_date'] ?>" disabled>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                <button type="submit" name="editproduct" class="btn btn-primary">Update Item</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
    <?php
        }
    }
    ?>

    <!-- Show Product Image -->
    <?php if (!empty($result_p)) {
        foreach ($result_p as $row) {
    ?>
            <div class="modal fade" id="editimg<?php echo $row['id'] ?>" aria-hidden="true" aria-labelledby="exampleModalToggleLabel" tabindex="-1">
                <div class="modal-dialog modal-dialog-centered modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="exampleModalLabel">Edit Images of <?php echo $row['p_name'] ?></h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="modal-body">
                                <div class="container">
                                    <div class="row row-cols-1 row-cols-md-2 g-4">
                                        <?php if (!empty($result_i)) {
                                            foreach ($result_i as $rows) {
                                                if ($rows['img_key'] == $row['p_keyword']) {
                                        ?>
                                                    <div class="col">
                                                        <div class="card">
                                                            <img src="assets/images/products/<?php echo $row['p_name'] . '/' . $rows['img_name'] ?>" class="card-img-top img-fluid">
                                                            <div class="card-body">
                                                                <button class="btn btn-dark" data-bs-target="#img<?php echo $rows['id'] ?>" data-bs-toggle="modal"><i class="bi bi-gear-wide-connected"></i> Change</button>
                                                                <button class="btn btn-danger" data-bs-target="#delete_img<?php echo $rows['id'] ?>" data-bs-toggle="modal"><i class="bi bi-trash-fill"></i></button>
                                                            </div>
                                                            <?php if ($rows['img_type'] == "Front") { ?>
                                                                <span class="position-absolute bottom-0 end-0 badge rounded-start-pill bg-dark">
                                                                    <?php echo $rows['img_type'] ?>
                                                                </span>
                                                            <?php } else { ?>
                                                                <span class="position-absolute bottom-0 end-0 badge rounded-start-pill bg-danger">
                                                                    <?php echo $rows['img_type'] ?>
                                                                </span>
                                                            <?php } ?>
                                                        </div>
                                                    </div>
                                        <?php
                                                }
                                            }
                                        }
                                        ?>
                                    </div>
                                    <input type="hidden" name="user" value="<?php echo $_SESSION['username']; ?>">
                                    <input type="hidden" name="edit_id" value="<?php echo $row['id'] ?>" />
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
    <?php
        }
    }
    ?>

    <!-- Edit Product Image -->
    <?php
    // Create a map of product details by keyword for image modals
    $products_details_map_by_keyword = [];
    if (!empty($result_p)) {
        foreach ($result_p as $product_item_for_map) {
            $products_details_map_by_keyword[$product_item_for_map['p_keyword']] = $product_item_for_map;
        }
    }

    // $products_details_map_by_keyword is used here
    if (!empty($result_i)) { // Iterate over all images
        foreach ($result_i as $image_item) { // $image_item is an image
            // Find the parent product for this image_item
            $parent_product_info = null;
            if (isset($image_item['img_key']) && isset($products_details_map_by_keyword[$image_item['img_key']])) {
                $parent_product_info = $products_details_map_by_keyword[$image_item['img_key']];
            }

            if ($parent_product_info) { // Only generate modal if parent product is found
                $parent_product_id = $parent_product_info['id'];
                $parent_product_name = $parent_product_info['p_name'];
    ?>
                    <div class="modal fade" id="img<?php echo $image_item['id']; ?>" aria-hidden="true" aria-labelledby="exampleModalToggleLabel2" tabindex="-1">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h1 class="modal-title fs-5" id="exampleModalToggleLabel2"><?php echo htmlspecialchars($image_item['img_name']); ?></h1>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <form action="api/product_process.php" method="POST" enctype="multipart/form-data">
                                    <div class="modal-body">
                                        <div id="<?php echo $image_item['id']; ?>EditImagePro"></div>
                                        <div class="card mx-auto" style="width: 18rem;">
                                            <img src="assets/images/products/<?php echo htmlspecialchars($parent_product_name); ?>/<?php echo htmlspecialchars($image_item['img_name']); ?>" class="card-img-top" alt="...">
                                            <div class="card-footer text-center">
                                                <small class="text-body-secondary">Current Image</small>
                                            </div>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Select Image</label>
                                            <input class="form-control" name="img_name" type="file" id="<?php echo $image_item['id']; ?>input_img" accept="image/png, image/jpeg, image/webp">
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Select Type</label>
                                            <div class="input-group">
                                                <span class="input-group-text text-danger" id="basic-addon3">Type: <?php echo htmlspecialchars($image_item['img_type']); ?></span>
                                                <select class="form-select" name="img_type">
                                                    <option value="<?php echo htmlspecialchars($image_item['img_type']); ?>" selected disabled><?php echo htmlspecialchars($image_item['img_type']); ?></option>
                                                    <option value="Front">Front</option>
                                                    <option value="Back">Back</option>
                                                </select>
                                            </div>
                                        </div>
                                        <input type="hidden" name="img_id" value="<?php echo $image_item['id']; ?>">
                                        <input type="hidden" name="old_img" value="<?php echo htmlspecialchars($image_item['img_name']); ?>">
                                        <input type="hidden" name="f_name" value="<?php echo htmlspecialchars($parent_product_name); ?>">
                                    </div>
                                    <div class="modal-footer">
                                        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                            <a class="btn btn-warning" data-bs-target="#editimg<?php echo $parent_product_id; ?>" data-bs-toggle="modal"><i class="bi bi-chevron-double-left"></i> Back</a>
                                            <button class="btn btn-c-indigo" name="update_image" type="submit"><i class="bi bi-arrow-repeat"></i> Update</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
    <?php
            } // end if $parent_product_info
        } // end foreach $result_i
    } // end if !empty $result_i
    ?>

    <!-- Product Description Modals -->
    <?php if (!empty($result_p)) {
        foreach ($result_p as $row) {
    ?>
            <div class="modal fade" id="descModal<?php echo $row['id']; ?>" tabindex="-1" aria-labelledby="descModalLabel<?php echo $row['id']; ?>" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="descModalLabel<?php echo $row['id']; ?>">Product Description: <?php echo htmlspecialchars($row['p_name']); ?></h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <p><?php echo nl2br(htmlspecialchars(str_replace('; ', "\\n", $row['p_description']))); ?></p>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>
    <?php
        }
    }
    ?>

    <!-- Delete Product -->
    <div class="modal fade" id="delete_pro" tabindex="-1" aria-labelledby="exampleModalLabel0" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Delete Product</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="api/product_process.php" method="POST">
                    <div class="modal-body">

                        <input type="hidden" name="delete_id" id="delete_proid">
                        <input type="hidden" name="pkeys" id="pkey">
                        <input type="hidden" name="ftitle" id="f_title">
                        <h4>Do You Want To Delete ?</h4>
                    </div>
                    <div class="modal-footer">
                        <a type="button" class="btn btn-secondary" data-bs-dismiss="modal"><i class="bi bi-x-square-fill"></i> No</a>
                        <button type="submit" name="del_pro" class="btn btn-danger"><i class="bi bi-check-square-fill"></i> Yes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Delete Product Image -->
    <?php
    // $products_details_map_by_keyword should still be in scope and available here
    if (!empty($result_i)) { // Iterate over all images
        foreach ($result_i as $image_item) { // $image_item is an image
            // Find the parent product for this image_item
            $parent_product_info = null;
            if (isset($image_item['img_key']) && isset($products_details_map_by_keyword[$image_item['img_key']])) {
                $parent_product_info = $products_details_map_by_keyword[$image_item['img_key']];
            }

            if ($parent_product_info) { // Only generate modal if parent product is found
                $parent_product_id = $parent_product_info['id'];
                $parent_product_name = $parent_product_info['p_name'];
    ?>
                    <div class="modal fade" id="delete_img<?php echo $image_item['id']; ?>" tabindex="-1" aria-labelledby="exampleModalLabel0" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Delete Image</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <form action="api/product_process.php" method="POST">
                                    <div class="modal-body">
                                        <input type="hidden" name="delete_img_id" value="<?php echo $image_item['id']; ?>">
                                        <input type="hidden" name="img_name" value="<?php echo htmlspecialchars($image_item['img_name']); ?>">
                                        <input type="hidden" name="pro_name" value="<?php echo htmlspecialchars($parent_product_name); ?>">

                                        <div class="card mx-auto" style="width: 18rem;">
                                            <img src="assets/images/products/<?php echo htmlspecialchars($parent_product_name); ?>/<?php echo htmlspecialchars($image_item['img_name']); ?>" class="card-img-top" alt="...">
                                            <div class="card-footer text-center">
                                                <h5 class="text-body-dark">Do You Want To Delete ?</h5>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="submit" name="del_image" class="btn btn-danger"><i class="bi bi-check2-circle"></i> Yes</button>
                                        <a class="btn btn-secondary" data-bs-target="#editimg<?php echo $parent_product_id; ?>" data-bs-toggle="modal"><i class="bi bi-x-circle"></i> No</a>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
    <?php
            } // end if $parent_product_info
        } // end foreach $result_i
    } // end if !empty $result_i
    ?>




    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script>
        $(document).ready(function() {
            $('.delete_p').on('click', function() {
                $('#delete_pro').modal('show');

                $tr = $(this).closest('tr');

                var data = $tr.children("td").map(function() {
                    return $(this).text();
                }).get();

                console.log(data);

                $('#delete_proid').val(data[8]);
                $('#pkey').val(data[6]);
                $('#f_title').val(data[1]);
            });

            $('.p_img').on('click', function() {
                $('#pro_img').modal('show');

                $tr = $(this).closest('tr');

                var data = $tr.children("td").map(function() {
                    return $(this).text();
                }).get();

                console.log(data);

                $('#f_name').val(data[1]);
                $('#p_key').val(data[6]);
            });
        });
    </script>
    <script>
        const alertAddPro = document.getElementById('AddImagePro')
        const AddiProShow = (message, type) => {
            const wrapper = document.createElement('div')
            wrapper.innerHTML = [
                `<div class="alert alert-${type} alert-dismissible" role="alert">`,
                `   <div>${message}</div>`,
                '   <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>',
                '</div>'
            ].join('')

            alertAddPro.append(wrapper)
        }

        const AddiPro = document.getElementById("input_Add_img");

        AddiPro.onchange = function() {
            if (this.files[0].size > 5242880) {
                //alert("File is too big!");
                AddiProShow('Image Size Too Big!', 'danger')
                this.value = "";

                window.setTimeout(function() {
                    $(".alert").fadeTo(500, 0).slideUp(500, function() {
                        $(this).remove();
                    });
                }, 3000);
            }
        }
        //-----------------------------------------------------------------------------------------------------------

        //-----------------------------------------------------------------------------------------------------------
        //1MB = 1,048,576 Bytes
    </script>

    <?php if (!empty($result_i)) {
        foreach ($result_i as $rows) {
    ?>
            <script>
                const A<?php echo $rows['id'] ?> = document.getElementById('<?php echo $rows['id'] ?>EditImagePro')
                const B<?php echo $rows['id'] ?> = (message, type) => {
                    const wrapper = document.createElement('div')
                    wrapper.innerHTML = [
                        `<div class="alert alert-${type} alert-dismissible" role="alert">`,
                        `   <div>${message}</div>`,
                        '   <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>',
                        '</div>'
                    ].join('')

                    A<?php echo $rows['id'] ?>.append(wrapper)
                }

                const E<?php echo $rows['id'] ?> = document.getElementById("<?php echo $rows['id'] ?>input_img");

                E<?php echo $rows['id'] ?>.onchange = function() {
                    if (this.files[0].size > 5242880) {
                        //alert("File is too big!");
                        B<?php echo $rows['id'] ?>('Image Size Too Big!', 'danger')
                        this.value = "";

                        window.setTimeout(function() {
                            $(".alert").fadeTo(500, 0).slideUp(500, function() {
                                $(this).remove();
                            });
                        }, 3000);
                    }
                }
            </script>
    <?php
        }
    }
    ?>


</body>




<?php include 'includes/footer.php'; ?>
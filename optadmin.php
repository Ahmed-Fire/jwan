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
                                <a class="nav-link" aria-current="page" href="admin.php">Home</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="proadmin.php">Products</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link active" href="optadmin.php">Options</a>
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
                <h1 class="display-5 fw-bold">Titiles</h1>
                <div>
                    <div class="p-5 mb-4 bg-light rounded-4 border border-5 border-warning shadow">
                        <div class="container-fluid">
                            <h1 class="display-6 fw-bold">Product Title</h1>
                            <button type="button" class="btn btn-primary my-2" data-bs-toggle="modal" data-bs-target="#addtitle"><i class="bi bi-plus-square"></i> Add</button>
                            <div class="table-responsive border border-1 border-dark p-2">
                                <table class="table table-bordered border-primary border-1 table-responsive">
                                    <thead>
                                        <tr>
                                            <th scope="col-1">#</th>
                                            <th scope="col-3">Title Name</th>
                                            <th scope="col-3">User</th>
                                            <th scope="col-3">Date</th>
                                            <th scope="col-2">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody class="table-group-divider">
                                        <?php if ($logined) {
                                            if (!empty($result_t)) {
                                                foreach ($result_t as $row) {
                                                    echo '
                                        <tr>
                                            <td scope="row" class="col">' . $i = $i + 1 . '</td>
                                            <td class="col">' . $row['title'] . '</td>
                                            <td class="col">' . $row['user'] . '</td>
                                            <td class="col">' . $row['date'] . '</td>
                                            <td class="col-4">
                                                <div class="d-grid gap-2 mx-auto">
                                                    <div class="row">
                                                        <div class="col">
                                                            <button type="button" class="btn btn-success btn-sm w-100" type="button" data-bs-toggle="modal" data-bs-target="#edittitle' . $row['id'] . '"><i class="bi bi-pencil-square"></i> Edit</button>
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
                    <div class="p-5 mb-4 bg-light rounded-4 border border-5 border-warning shadow">
                        <div class="container-fluid">
                            <h1 class="display-6 fw-bold">Subtitle Title</h1>
                            <button type="button" class="btn btn-primary my-2" data-bs-toggle="modal" data-bs-target="#addsubtitle"><i class="bi bi-plus-square"></i> Add</button>
                            <div class="table-responsive border border-1 border-dark p-2">
                                <table class="table table-bordered border-primary border-1 table-responsive">
                                    <thead>
                                        <tr>
                                            <th scope="col-1">#</th>
                                            <th scope="col-3">Title Name</th>
                                            <th scope="col-3">User</th>
                                            <th scope="col-3">Date</th>
                                            <th scope="col-3">Connect</th>
                                            <th scope="col-2">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody class="table-group-divider">
                                        <?php if ($logined) {
                                            if (!empty($result_s)) {
                                                foreach ($result_s as $row) {
                                                    echo '
                                        <tr>
                                            <td scope="row" class="col">' . $a = $a + 1 . '</td>
                                            <td class="col">' . $row['title'] . '</td>
                                            <td class="col">' . $row['user'] . '</td>
                                            <td class="col">' . $row['date'] . '</td>
                                            <td class="col">' . $row['title_name'] . '</td>
                                            <td class="col-4">
                                                <div class="d-grid gap-2 mx-auto">
                                                    <div class="row">
                                                        <div class="col">
                                                            <button type="button" class="btn btn-success btn-sm w-100" type="button" data-bs-toggle="modal" data-bs-target="#editsubtitle' . $row['id'] . '"><i class="bi bi-pencil-square"></i> Edit</button>
                                                        </div>
                                                        <div class="col">
                                                            <button class="btn btn-danger btn-sm w-100 delete_sub"><i class="bi bi-trash3-fill"></i> Delete</button>
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
                </div>
            </div>
        </div>
    </div>

    <!-- Add Title Modal -->
    <div class="modal fade" id="addtitle" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Add Title</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="api/product_process.php" method="POST" enctype="multipart/form-data">
                    <div class="modal-body">
                        <div id="AddIcon"></div>
                        <div class="mb-3">
                            <label>Title Name</label>
                            <input type="text" name="tname" class="form-control" placeholder="Enter Type Name">
                            <input type="text" name="user" value="<?php echo $_SESSION['username']; ?>" style="display:none">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Select Title Icon</label>
                            <input class="form-control" name="icon_name" type="file" id="input_Add_icon" accept="image/png, image/webp">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" name="addtitle" class="btn btn-primary">Add Title</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Add Subtitle Modal -->
    <div class="modal fade" id="addsubtitle" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Add Subtitle</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="api/product_process.php" method="POST" enctype="multipart/form-data">
                    <div class="modal-body">
                        <div class="modal-body">
                            <div class="mb-3">
                                <label>Title Name</label>
                                <input type="text" name="tname" class="form-control">
                                <br>
                                <select name="title" class="form-select" aria-label="Default select example">
                                    <?php if (!empty($result_t)) {
                                        foreach ($result_t as $row) {
                                    ?>
                                            <option value="<?php echo $row['title'] ?>"><?php echo $row['title'] ?></option>
                                    <?php
                                        }
                                    }
                                    ?>
                                </select>
                                <input type="hidden" name="user" value="<?php echo $_SESSION['username']; ?>">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" name="addsubtitle" class="btn btn-primary">Add Subtitle</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Edit Title Modal -->
    <?php if (!empty($result_t)) {
        foreach ($result_t as $row) {
    ?>
            <div class="modal fade" id="edittitle<?php echo $row['id'] ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="exampleModalLabel">Edit <?php echo $row['title'] ?></h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <form action="api/product_process.php" method="POST" enctype="multipart/form-data">
                            <div class="modal-body">
                                <div id="EditIcon<?php echo $row['id'] ?>"></div>
                                <div class="card mx-auto" style="width: 10rem;">
                                    <img src="assets/images/covers/<?php echo $row['t_img'] ?>" class="card-img-top" alt="...">
                                    <div class="card-footer text-center">
                                        <small class="text-body-secondary">Current Icon</small>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label>Type Name</label>
                                    <input type="text" name="tname" class="form-control" value="<?php echo $row['title'] ?>">
                                    <input type="hidden" name="user" value="<?php echo $_SESSION['username']; ?>">
                                    <input type="hidden" name="old_icon" value="<?php echo $row['t_img'] ?>">
                                    <input type="hidden" name="edit_id" value="<?php echo $row['id'] ?>" name="id" />
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Select Title Icon</label>
                                    <input class="form-control" name="icon_edit" type="file" id="input_edit_icon<?php echo $row['id'] ?>" accept="image/png, image/webp">
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                <button type="submit" name="edittitle" class="btn btn-c-indigo">Update Title</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
    <?php
        }
    }
    ?>

    <!-- Edit Subtitle Modal -->
    <?php if (!empty($result_s)) {
        foreach ($result_s as $row) {
    ?>
            <div class="modal fade" id="editsubtitle<?php echo $row['id'] ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <form action="api/product_process.php" method="POST" enctype="multipart/form-data">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h1 class="modal-title fs-5" id="exampleModalLabel">Edit <?php echo $row['title'] ?></h1>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <form action="api/product_process.php" method="POST" enctype="multipart/form-data">
                                <div class="modal-body">
                                    <div class="modal-body">

                                        <div class="mb-3">
                                            <label>Type Name</label>
                                            <input type="text" name="tname" class="form-control" value="<?php echo $row['title'] ?>">
                                            <br>
                                            <select name="title" class="form-select" aria-label="Default select example">
                                                <option selected value="<?php echo $row['title_name'] ?>" disabled><?php echo $row['title_name'] ?></option>
                                                <?php if (!empty($result_t)) {
                                                    foreach ($result_t as $rows) {
                                                ?>
                                                        <option value="<?php echo $rows['title'] ?>"><?php echo $rows['title'] ?></option>
                                                <?php
                                                    }
                                                }
                                                ?>
                                            </select>
                                            <input type="hidden" name="user" value="<?php echo $_SESSION['username']; ?>">
                                            <input type="hidden" name="edit_id" value="<?php echo $row['id'] ?>" />
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                    <button type="submit" name="editsubtitle" class="btn btn-primary">Update Item</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </form>
            </div>
    <?php
        }
    }
    ?>

    <!-- Delete Title Modal -->
    <div class="modal fade" id="delete_title" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Delete Title</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="api/product_process.php" method="POST">
                    <div class="modal-body">

                        <input type="hidden" name="delete_id" id="delete_titleid">

                        <h4>Do You Want To Delete ?</h4>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">No</button>
                        <button type="submit" name="del_title" class="btn btn-primary">Yes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Delete Subtitle Modal -->
    <div class="modal fade" id="delete_subtitle" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Delete Subtitle</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="api/product_process.php" method="POST">
                    <div class="modal-body">

                        <input type="hidden" name="delete_subid" id="delete_subtitleid">

                        <h4>Do You Want To Delete ?</h4>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">No</button>
                        <button type="submit" name="del_subtitle" class="btn btn-primary">Yes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script>
        $(document).ready(function() {
            $('.delete_s').on('click', function() {
                $('#delete_title').modal('show');

                $tr = $(this).closest('tr');

                var data = $tr.children("td").map(function() {
                    return $(this).text();
                }).get();

                console.log(data);

                $('#delete_titleid').val(data[5]);
            });

            $('.delete_sub').on('click', function() {
                $('#delete_subtitle').modal('show');

                $tr = $(this).closest('tr');

                var data = $tr.children("td").map(function() {
                    return $(this).text();
                }).get();

                console.log(data);

                $('#delete_subtitleid').val(data[6]);
            });
        });
    </script>
    <script>
        const alertAddIcon = document.getElementById('AddIcon')
        const AddIconShow = (message, type) => {
            const wrapper = document.createElement('div')
            wrapper.innerHTML = [
                `<div class="alert alert-${type} alert-dismissible" role="alert">`,
                `   <div>${message}</div>`,
                '   <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>',
                '</div>'
            ].join('')

            alertAddIcon.append(wrapper)
        }

        const AddIcon = document.getElementById("input_Add_icon");

        AddIcon.onchange = function() {
            if (this.files[0].size > 5242880) {
                //alert("File is too big!");
                AddIconShow('Icon Size Too Big!', 'danger')
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
    <?php if (!empty($result_t)) {
        foreach ($result_t as $row) {
    ?>
            <script>
                const alertEditIcon<?php echo $row['id'] ?> = document.getElementById('EditIcon<?php echo $row['id'] ?>')
                const EditIconShow<?php echo $row['id'] ?> = (message, type) => {
                    const wrapper = document.createElement('div')
                    wrapper.innerHTML = [
                        `<div class="alert alert-${type} alert-dismissible" role="alert">`,
                        `   <div>${message}</div>`,
                        '   <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>',
                        '</div>'
                    ].join('')

                    alertEditIcon<?php echo $row['id'] ?>.append(wrapper)
                }

                const EditIcon<?php echo $row['id'] ?> = document.getElementById("input_edit_icon<?php echo $row['id'] ?>");

                EditIcon<?php echo $row['id'] ?>.onchange = function() {
                    if (this.files[0].size > 5242880) {
                        //alert("File is too big!");
                        EditIconShow<?php echo $row['id'] ?>('Icon Size Too Big!', 'danger')
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
    <?php
        }
    }
    ?>
</body>




<?php include 'includes/footer.php'; ?>
<?php
include 'includes/header.php';
include 'api/dbconnector.php';

//to hide all error

ini_set('display_errors', 0);
ini_set('display_startup_errors', 0);
error_reporting(-1);


session_start();
$ty = $_SESSION['type'];
if (isset($_SESSION['username']) == NULL || $ty == 'employee') {
    $logined = false;
} else {
    $logined = true;
    $un = $_SESSION['username'];

    $sql = 'SELECT * FROM accounts ORDER BY id ASC';
    $pdo_statement = $con->prepare($sql);
    $pdo_statement->execute();
    $result_u = $pdo_statement->fetchAll();
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
                                <div class="row">
                                    <div class="col">
                                        <h5 class="text-white m-1">Welcome : <?php echo $_SESSION['username'] ?></h5>
                                    </div>
                                </div>
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
                                <a class="nav-link" href="optadmin.php">Options</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link active" href="users.php">Users</a>
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
                <h1 class="display-5 fw-bold">Users</h1>
                <div>
                    <div class="p-5 mb-4 rounded-4 border border-5 border-dark">
                        <div class="container-fluid">
                            <h1 class="display-6 fw-bold">Edit or Add Users</h1>
                            <?php if ($logined) { ?>
                                <button type="button" class="btn btn-primary my-2" data-bs-toggle="modal" data-bs-target="#addpro"><i class="bi bi-plus-square"></i> Add</button>
                            <?php }
                            ?>
                            <div>
                                <table class="table table-bordered border-primary border-1">
                                    <thead>
                                        <tr>
                                            <th scope="col">#</th>
                                            <th scope="col">Name</th>
                                            <th scope="col">Phone</th>
                                            <th scope="col">Username</th>
                                            <th scope="col">Password</th>
                                            <th scope="col">Type</th>
                                            <th scope="col">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php if (!empty($result_u)) {
                                            foreach ($result_u as $row) {
                                                echo '
                                                <tr>
                                                    <td scope="row" class="col-1">' . $row['id'] . '</td>
                                                    <td class="col">' . $row['name'] . '</td>
                                                    <td class="col">' . $row['phone'] . '</td>
                                                    <td class="col">' . $row['username'] . '</td>
                                                    <td class="col">' . $row['password'] . '</td>
                                                    <td class="col">' . $row['type'] . '</td>
                                                    <td class="col-4">
                                                        <div class="d-grid gap-2 mx-auto">
                                                            <div class="row">
                                                                <div class="col">
                                                                <button type="button" class="btn btn-outline-success btn-sm w-100" type="button" data-bs-toggle="modal" data-bs-target="#editpro' . $row['id'] . '"><i class="bi bi-pencil-square"></i> Edit</button>
                                                                </div>
                                                                <div class="col">
                                                                    <button class="btn btn-outline-danger btn-sm w-100 delete_p" type="button"><i class="bi bi-trash3-fill"></i> Delete</button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </td>
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

    <!-- Add Modal -->
    <div class="modal fade" id="addpro" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Add New User</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="api/user_process.php" method="POST" enctype="multipart/form-data">
                        <div class="modal-body">

                            <div class="mb-3">
                                <label>Full Name</label>
                                <input type="text" name="name" class="form-control" placeholder="Enter Full Name">
                            </div>
                            <div class="mb-3">
                                <label>Phone Number</label>
                                <input type="text" name="phone" class="form-control" placeholder="Enter Phone Number">
                            </div>
                            <div class="mb-3">
                                <label>Username</label>
                                <input type="text" class="form-control" name="user" placeholder="Enter Username"></input>
                            </div>
                            <div class="mb-3">
                                <label>Password</label>
                                <input type="text" name="pass" class="form-control" placeholder="Enter Password">
                            </div>
                            <div class="mb-3">
                                <label>User Type</label>
                                <select name="utype" class="form-select" aria-label="Default select example">
                                    <option selected disabled>Select Type</option>
                                    <option value="admin">Admin</option>
                                    <option value="employee">Employee</option>
                                </select>
                            </div>
                        </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" name="adduser" class="btn btn-primary">Add User</button>
                </div>
                </form>
            </div>
        </div>
    </div>

    <?php if (!empty($result_u)) {
        foreach ($result_u as $row) {
    ?>
            <div class="modal fade" id="editpro<?php echo $row['id'] ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <form action="api/user_process.php" method="POST" enctype="multipart/form-data">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h1 class="modal-title fs-5" id="exampleModalLabel">Edit <?php echo $row['name'] ?></h1>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <form action="api/product_process.php" method="POST" enctype="multipart/form-data">
                                <div class="modal-body">
                                    <div class="modal-body">

                                        <div class="mb-3">
                                            <label>Full Name</label>
                                            <input type="text" name="name" class="form-control" value="<?php echo $row['name'] ?>">
                                        </div>
                                        <div class="mb-3">
                                            <label>Phone Number</label>
                                            <input type="text" name="phone" class="form-control" value="<?php echo $row['phone'] ?>">
                                        </div>
                                        <div class="mb-3">
                                            <label>Username</label>
                                            <input type="text" name="users" class="form-control" value="<?php echo $row['username'] ?>">
                                        </div>
                                        <div class="mb-3">
                                            <label>Password</label>
                                            <input type="text" name="pass" class="form-control" value="<?php echo $row['password'] ?>">
                                        </div>
                                        <div class="mb-3">
                                            <label>User Type</label>
                                            <select name="utype" class="form-select" aria-label="Default select example">
                                                <option selected disabled>Select Type</option>
                                                <option value="admin">Admin</option>
                                                <option value="employee">Employee</option>
                                            </select>
                                        </div>

                                        <input type="hidden" name="edit_id" value="<?php echo $row['id'] ?>" />
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                    <button type="submit" name="edituser" class="btn btn-primary">Update Item</button>
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

    <div class="modal fade" id="delete_pro" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Delete Items</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="api/user_process.php" method="POST">
                    <div class="modal-body">

                        <input type="hidden" name="delete_id" id="delete_proid">
                        <h4>Do You Want To Delete ?</h4>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">No</button>
                        <button type="submit" name="del_user" class="btn btn-primary">Yes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>


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

                $('#delete_proid').val(data[0]);
            });
        });
    </script>

</body>




<?php include 'includes/footer.php'; ?>
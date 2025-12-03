<?php
include 'includes/header.php';
include 'api/dbconnector.php';
include 'includes/data-fetcher.php';

session_start();

// Fetch all required data using helper functions
$result_t = fetchProductTitles($con);
$result_s = fetchSubtitleData($con);
$result_p = fetchProducts($con);
$result_i = fetchProductImages($con);
?>


<title>Home</title>

</head>

<body class="d-flex flex-column h-100">
    <main class="flex-shrink-0">
        <?php include 'includes/navigation.php'; ?>
        <!-- Features section-->
        <section class="py-5" id="features">
            <section class="" id="features">
                <div class="p-3">
                    <div class="container">
                        <ul class="nav nav-pills mb-3 shadow rounded p-2" id="pills-tab" role="tablist">
                            <!-- <button class="nav-link active btn btn-outline-danger" id="pills-home-tab" data-bs-toggle="pill" data-bs-target="#pills-home" type="button" role="tab" aria-controls="pills-home" aria-selected="true">All</button> -->
                            <div class="overflow-auto">
                                <div class="" style="white-space: nowrap;">
                                    <a class="active btn btn-danger text-center" id="pills-home-tab" data-bs-toggle="pill" data-bs-target="#pills-home"><img src="assets/living-room.png" class="img-fluid px-2" height="50px" width="50px">ALL</a>
                                    <?php if (!empty($result_t)) {
                                        foreach ($result_t as $row) {
                                            $p_title = str_replace(' ', '', $row['title']);
                                    ?>
                                            <!-- <li class="nav-item" role="presentation">
                                    <button class="nav-link" id="pills-<?php echo $p_title ?>-tabs" data-bs-toggle="pill" data-bs-target="#pill-<?php echo $p_title ?>" type="button" role="tab" aria-controls="pill-<?php echo $p_title ?>" aria-selected="false"><img src="assets/table.png" class="img-fluid mx-3" height="40px" width="40px"><?php echo $row['title'] ?></button>
                                </li> -->
                                            <a class="btn btn-danger mx-2" data-bs-toggle="pill" data-bs-target="#pill-<?php echo $p_title ?>"><img src="assets/images/covers/<?php echo $row['t_img'] ?>" class="img-fluid px-2" height="50px" width="50px"><?php echo $row['title'] ?></a>
                                    <?php
                                        }
                                    }
                                    ?>
                                </div>
                            </div>
                        </ul>
                    </div>


                    <div class="contaier">
                        <div class="tab-content" id="pills-tabContent">
                            <div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab">
                                <div class="row">
                                    <?php
                                    foreach ($result_p as $row_p) {
                                        if (!empty($result_i)) {
                                            foreach ($result_i as $row_i) if ($row_i['img_key'] == $row_p['p_keyword'] && trim($row_i['img_type']) == 'Front') {
                                    ?>
                                                <div class="col p-3">
                                                    <div class="card h-100" style="width: 18rem;">
                                                        <img src="assets/images/products/<?php echo $row_p['p_name'] ?>/<?php echo $row_i['img_name'] ?>" class="card-img-top" alt="...">
                                                        <div class="card-body">
                                                            <h5 class="card-title"><?php echo $row_p['p_name'] ?></h5>
                                                            
                                                            <button type="button" class="btn btn-sm btn-secondary mb-2" data-bs-toggle="modal" data-bs-target="#sizeModal_<?php echo htmlspecialchars($row_p['p_keyword']); ?>">Show Sizes</button></br>
                                                            <?php if (!empty($result_i)) {
                                                                foreach ($result_i as $row_i) if ($row_i['img_key'] == $row_p['p_keyword'] && $row_i['img_type'] == 'Back') {
                                                                    $i_img = str_replace(' ', '', $row_i['img_name']);
                                                                    echo '
                                                                            <a class="" data-bs-toggle="modal" data-bs-target="#' . substr($i_img, 0, -4) . '"><img src="assets/images/products/' . $row_p['p_name'] . '/' . $row_i['img_name'] . '" height="50px" width="50px" alt="..."></a>';
                                                                }
                                                            }
                                                            ?>
                                                        </div>
                                                    </div>
                                                </div>
                                    <?php
                                            }
                                        }
                                    }
                                    ?>
                                </div>
                            </div>
                            <?php if (!empty($result_t)) {
                                foreach ($result_t as $row) {
                                    $p_title = str_replace(' ', '', $row['title']);
                            ?>
                                    <div class="tab-pane fade show" id="pill-<?php echo $p_title ?>" role="tabpanel" aria-labelledby="pills-<?php echo $p_title ?>-tabs" tabindex="0">
                                        <div class="row">
                                            <div class="col-3">
                                                <div class="list-group" id="list-tab" role="tablist">
                                                    <?php if (!empty($result_s)) {
                                                        foreach ($result_s as $rows) if ($row['title'] == $rows['title_name']) { {
                                                                $s_title = str_replace(' ', '', $rows['title']);
                                                    ?>
                                                                <a class="list-group-item list-group-item-action" style="white-space: nowrap;" id="<?php echo $s_title ?>-lists" data-bs-toggle="list" href="#lists-<?php echo $s_title ?>" role="tab" aria-controls="lists-<?php echo $s_title ?>"><?php echo $rows['title'] ?></a>
                                                    <?php
                                                            }
                                                        }
                                                    }
                                                    ?>
                                                </div>
                                            </div>
                                            <div class="col-9">
                                                <div class="tab-content" id="nav-tabContent">
                                                    <?php if (!empty($result_s)) {
                                                        foreach ($result_s as $row_s) if ($row['title'] == $row_s['title_name']) { {
                                                                $c_title = str_replace(' ', '', $row_s['title']);
                                                    ?>
                                                                <div class="tab-pane fade" id="lists-<?php echo $c_title ?>" role="tabpanel" aria-labelledby="<?php echo $c_title ?>-lists">
                                                                    <div class="row">
                                                                        <?php
                                                                        foreach ($result_p as $row_p)
                                                                            if ($row['title'] == $row_p['p_type'] && $row_s['title'] == $row_p['p_part']) { {
                                                                                    if (!empty($result_i)) {
                                                                                        foreach ($result_i as $row_i) if ($row_i['img_key'] == $row_p['p_keyword'] && $row_i['img_type'] == 'Front') {
                                                                        ?>
                                                                                        <div class="col p-3">
                                                                                            <div class="card h-100" style="width: 15rem;">
                                                                                                <img src="assets/images/products/<?php echo $row_p['p_name'] ?>/<?php echo $row_i['img_name'] ?>" class="card-img-top" alt="...">
                                                                                                <div class="card-body">
                                                                                                    <h5 class="card-title"><?php echo $row_p['p_name'] ?></h5>
                                                                                                    
                                                                                                    <button type="button" class="btn btn-sm btn-secondary mb-2" data-bs-toggle="modal" data-bs-target="#sizeModal_<?php echo htmlspecialchars($row_p['p_keyword']); ?>">Show Details</button>
                                                                                                    <?php if (!empty($result_i)) {
                                                                                                        foreach ($result_i as $row_i) if ($row_i['img_key'] == $row_p['p_keyword'] && $row_i['img_type'] == 'Back') {
                                                                                                            $i_img = str_replace(' ', '', $row_i['img_name']);
                                                                                                            echo '
                                                                            <a class="" data-bs-toggle="modal" data-bs-target="#' . substr($i_img, 0, -4) . '"><img src="assets/images/products/' . $row_p['p_name'] . '/' . $row_i['img_name'] . '" height="50px" width="50px" alt="..."></a>';
                                                                                                        }
                                                                                                    }
                                                                                                    ?>
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
                                                                        <?php
                                                                                        }
                                                                                    }
                                                                                }
                                                                            }
                                                                        ?>
                                                                    </div>
                                                                </div>
                                                    <?php
                                                            }
                                                        }
                                                    }
                                                    ?>

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                            <?php
                                }
                            }
                            ?>
                        </div>
                    </div>
                </div>
            </section>

            <div>
                <?php
                if (!empty($result_i)) {
                    foreach ($result_i as $row_i) {

                ?>
                        <div class="modal fade" id="<?php $i_img = str_replace(' ', '', $row_i['img_name']);
                                                    echo substr($i_img, 0, -4) ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h1 class="modal-title fs-5" id="exampleModalLabel"><?php $row_p['p_name'] ?></h1>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <?php
                                        if (!empty($result_p)) {
                                            foreach ($result_p as $row_p) {
                                                echo '<img class="img-fluid" src="assets/images/products/' . $row_p['p_name'] . '/' . $row_i['img_name'] . '" alt="" srcset="">';
                                            }
                                        }
                                        ?>
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
            </div>

            <div> <!-- New Modals for Product Sizes -->
                <?php
                if (!empty($result_p)) {
                    foreach ($result_p as $product_item) { 
                ?>
                        <div class="modal fade" id="sizeModal_<?php echo htmlspecialchars($product_item['p_keyword']); ?>" tabindex="-1" aria-labelledby="sizeModalLabel_<?php echo htmlspecialchars($product_item['p_keyword']); ?>" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="sizeModalLabel_<?php echo htmlspecialchars($product_item['p_keyword']); ?>"><?php echo htmlspecialchars($product_item['p_name']); ?> - Details</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <h6>Description:</h6>
                                        <p><?php echo nl2br(htmlspecialchars(str_replace(', ', "\n", $product_item['p_description']))); ?></p>
                                        <hr>
                                        <h6>Sizes:</h6>
                                        <p><?php echo nl2br(htmlspecialchars($product_item['p_size'])); ?></p>
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
            </div>

    </main>

    <?php include 'includes/page-footer.php'; ?>
</body>


<?php include 'includes/footer.php'; ?>
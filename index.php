<?php
include 'includes/header.php';
include 'api/dbconnector.php';
include 'includes/data-fetcher.php';

session_start();

// Fetch all required data using helper functions
$result_s = fetchSlideshowData($con);
$result_ss = fetchSubtitleData($con);
$result_lp = fetchLatestProducts($con);
$result_lw = fetchLastWorks($con);
?>
<title>Home</title>
</head>

<body class="d-flex flex-column h-100">
  <main class="flex-shrink-0">
    <?php include 'includes/navigation.php'; ?>
    <!-- Header-->
    <header class="py-5 bg-white">
      <div class="container px-5">
        <div class="row gx-5 align-items-center justify-content-center">
          <div class="text-center">
            <div id="carouselExampleDark" class="carousel carousel-dark slide" data-bs-ride="carousel">
              <div class="carousel-inner">
                <?php if (!empty($result_s)) {
                  $is_first = true;
                  foreach ($result_s as $row_s) {
                ?>
                    <div class="carousel-item <?php echo $is_first ? 'active' : ''; ?>" data-bs-interval="5000">
                      <img src="assets/images/slideshow/<?php echo $row_s['img_path'] ?>" class="d-block w-100" alt="..." />
                      <div class="carousel-caption d-none d-md-block bg-dark text-white bg-opacity-50">
                        <h5>
                          <?php echo $row_s['location'] ?>
                        </h5>
                        <p>
                          <?php echo $row_s['type'] ?>
                        </p>
                      </div>
                    </div>
                <?php
                    $is_first = false;
                  }
                }
                ?>
              </div>
              <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleDark" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
              </button>
              <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleDark" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
              </button>
            </div>
          </div>
        </div>
      </div>
    </header>
    <!-- Features section-->
    <section class="py-5 bg-dark" id="features">
      <div class="container px-5 my-5">
        <div class="col-lg-8 col-xl-7 col-xxl-6 text-center">
          <div class="my-5 text-center text-xl-start">
            <h1 class="display-5 fw-bolder text-white mb-2" style="color: #ffffff !important; text-shadow: 2px 2px 8px rgba(0,0,0,0.8); letter-spacing: 1px;">
              JWAN Furniture
            </h1>
            <p class="lead fw-normal text-white-50 mb-4">
              JWAN Office Furniture was established in 1980, He has owned many
              government and private company projects so far and finished the
              projects with the best quality, with the many abrod companies
              help.
            </p>
            <div class="d-grid gap-3 d-sm-flex justify-content-sm-center justify-content-xl-start">
              <a class="btn btn-danger btn-lg px-4 me-sm-3" href="tel:009647515786666" style="font-weight: 600; box-shadow: 0 4px 12px rgba(220, 53, 69, 0.5); transition: all 0.3s ease;">Call Us</a>
            </div>
          </div>
        </div>
      </div>
    </section>


    <section>
      <div class="container">
        <div class="container py-3">
          <h2>Our Latest Products</h2>
        </div>
        <div class="slider">
          <div class="slide-track">
            <div class="slide">
              <div class="row">
                <?php if (!empty($result_lp)) {
                  foreach ($result_lp as $row) {
                ?>
                    <div class="col">
                      <div class="card" style="width: 18rem;">
                        <img src="assets/images/latestproduct/<?php echo $row['p_img'] ?>" class="card-img-top" alt="...">
                        <div class="card-body">
                          <h5 class="card-title"><?php echo $row['p_name'] ?></h5>
                          <p class="card-text"><?php echo $row['p_des'] ?></p>
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
        </div>
      </div>
    </section>


    <!-- Blog preview section-->
    <section class="py-5">
      <div class="container px-5 my-5">
        <div class="row gx-5 justify-content-center">
          <div class="col-lg-8 col-xl-6">
            <div class="text-center">
              <h2 class="fw-bolder">Last Works</h2>
              <p class="lead fw-normal text-muted mb-5">
                Our Completed Works For Companies
              </p>
            </div>
          </div>
        </div>
        <div class="row gx-5">
          <?php if (!empty($result_lw)) {
            foreach ($result_lw as $row) {
          ?>
              <div class="col-lg-4 mb-5">
                <div class="card h-100 shadow border-0">
                  <img class="card-img-top" src="assets/images/latestwork/<?php echo $row['p_img'] ?>" alt="..." />
                  <div class="card-body p-4">
                    <div class="badge bg-primary bg-gradient rounded-pill mb-2">
                      <?php echo $row['p_type'] ?>
                    </div>
                    <a class="text-decoration-none link-dark stretched-link" href="#!">
                      <h5 class="card-title mb-3"><?php echo $row['p_name'] ?></h5>
                    </a>
                    <p class="card-text mb-0">
                      <?php echo $row['p_des'] ?>
                    </p>
                  </div>
                  <div class="card-footer p-4 pt-0 bg-transparent border-top-0">
                    <div class="d-flex align-items-end justify-content-between">
                      <div class="d-flex align-items-center">
                        <img class="rounded-circle me-3" src="assets/images/clientlogo/<?php echo $row['c_logo'] ?>" alt="..." height="40px" width="40px" />
                        <div class="small">
                          <div class="fw-bold"><?php echo $row['c_name'] ?></div>
                          <div class="text-muted"><?php echo $row['date'] ?></div>
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
        </div>
        <!-- Call to action-->
        <aside class="bg-dark bg-gradient rounded-3 p-4 p-sm-5 mt-5">
          <div class="d-flex align-items-center justify-content-between flex-column flex-xl-row text-center text-xl-start">
            <div class="mb-4 mb-xl-0">
              <div class="fs-3 fw-bold text-white">
                Follow Us on Social Media
              </div>
              <div class="text-white-50">Follow us on social media</div>
            </div>
            <div class="ms-xl-4">
              <a href="" class="btn btn-primary">Facebook</a>
              <a href="" class="btn btn-danger">Instagram</a>
              <a href="" class="btn btn-success">Whatsapp</a>
            </div>
            <div class="small text-white-50">
              We care about privacy, and will never share your data.
            </div>
          </div>
      </div>
      </aside>
      <div class="container">
        <div class="row text-center">
          <div class="col">
          <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d1910.3904109531588!2d44.001954090241945!3d36.17571754070394!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x4007231d9ac07563%3A0x916a24d602935677!2sJwan%20Furniture!5e0!3m2!1sen!2siq!4v1715092998147!5m2!1sen!2siq" width="300" height="250" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
          </div>
          <div class="col">
          <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3219.481905952197!2d44.004106876237934!3d36.20348007242322!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x400723660f7cf5cb%3A0xc5a638d4b7782195!2sJwan%20Office%20Furniture!5e0!3m2!1sen!2siq!4v1715093092358!5m2!1sen!2siq" width="300" height="250" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
          </div>
        </div>
      </div>
      </div>
    </section>

    <div class="navbar fixed-bottom">
      <div class="container-fluid d-flex justify-content-end p-4">
        <a href="https://wa.me/009647515786666" target="_blank">
          <img class="img-fluid" src="assets/images/whatsapp.png" alt="WhatsApp Button" height="50px" width="50px">
        </a>
      </div>
    </div>
  </main>
  <?php include 'includes/page-footer.php'; ?>

  <?php include 'includes/footer.php'; ?>
<?php
/**
 * Common Data Fetcher
 * Fetches frequently used data to avoid repetition across pages
 */

// Ensure database connection is available
if (!isset($con)) {
    die("Database connection not available. Please include dbconnector.php first.");
}

// Fetch slideshow data
function fetchSlideshowData($con) {
    $sql = 'SELECT * FROM slideshow ORDER BY id ASC';
    $pdo_statement = $con->prepare($sql);
    $pdo_statement->execute();
    return $pdo_statement->fetchAll();
}

// Fetch subtitle data
function fetchSubtitleData($con) {
    $sql = 'SELECT * FROM subtitle ORDER BY id ASC';
    $pdo_statement = $con->prepare($sql);
    $pdo_statement->execute();
    return $pdo_statement->fetchAll();
}

// Fetch latest products
function fetchLatestProducts($con) {
    $sql = 'SELECT * FROM latest_product ORDER BY id ASC';
    $pdo_statement = $con->prepare($sql);
    $pdo_statement->execute();
    return $pdo_statement->fetchAll();
}

// Fetch last works
function fetchLastWorks($con) {
    $sql = 'SELECT * FROM last_works ORDER BY id ASC';
    $pdo_statement = $con->prepare($sql);
    $pdo_statement->execute();
    return $pdo_statement->fetchAll();
}

// Fetch product titles
function fetchProductTitles($con) {
    $sql = 'SELECT * FROM title ORDER BY id ASC';
    $pdo_statement = $con->prepare($sql);
    $pdo_statement->execute();
    return $pdo_statement->fetchAll();
}

// Fetch products
function fetchProducts($con) {
    $sql = 'SELECT * FROM products ORDER BY id DESC';
    $pdo_statement = $con->prepare($sql);
    $pdo_statement->execute();
    return $pdo_statement->fetchAll();
}

// Fetch product images
function fetchProductImages($con) {
    $sql = 'SELECT * FROM product_images ORDER BY id ASC';
    $pdo_statement = $con->prepare($sql);
    $pdo_statement->execute();
    return $pdo_statement->fetchAll();
}

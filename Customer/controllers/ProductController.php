<?php

require_once __DIR__ . "/../models/db.php";
require_once __DIR__ . "/../models/Product.php";
require_once __DIR__ . "/../models/Review.php";
require_once __DIR__ . "/../models/Wishlist.php";

function index() {
    global $conn;

    $keyword   = trim($_GET['keyword']   ?? '');
    $category  = trim($_GET['category']  ?? '');
    $min_price = trim($_GET['min_price'] ?? '');
    $max_price = trim($_GET['max_price'] ?? '');

    $model      = new Product($conn);
    $products   = $model->getAll($keyword, $category, $min_price, $max_price);
    $categories = $model->getCategories();

    include __DIR__ . "/../views/products/list.php";
}

function details($id) {
    global $conn;

    $id = (int)$id;
    if (!$id) { header("Location: index.php?action=products"); exit(); }

    $model   = new Product($conn);
    $product = $model->getById($id);

    if (!$product) { header("Location: index.php?action=products"); exit(); }

    $rating_info  = $model->getAvgRating($id);
    $reviewModel  = new Review($conn);
    $reviews      = $reviewModel->getByProduct($id);
    $already_reviewed = false;
    $in_wishlist      = false;

    if (isset($_SESSION['user'])) {
        $already_reviewed = $reviewModel->alreadyReviewed($_SESSION['user']['id'], $id);
        $wl               = new Wishlist($conn);
        $in_wishlist      = $wl->exists($_SESSION['user']['id'], $id);
    }

    include __DIR__ . "/../views/products/details.php";
}

<?php

require_once __DIR__ . "/../models/db.php";
require_once __DIR__ . "/../models/Review.php";

function submitReview() {
    global $conn;

    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        header("Location: index.php?action=products");
        exit();
    }

    $product_id = (int)($_POST['product_id'] ?? 0);
    $rating     = (int)($_POST['rating']     ?? 0);
    $comment    = trim($_POST['comment']     ?? '');

    if (!$product_id || $rating < 1 || $rating > 5 || empty($comment)) {
        $_SESSION['error'] = "Rating (1-5) and comment are required.";
        header("Location: index.php?action=product_details&id=$product_id");
        exit();
    }

    $model = new Review($conn);

    if ($model->alreadyReviewed($_SESSION['user']['id'], $product_id)) {
        $_SESSION['error'] = "You already reviewed this product.";
        header("Location: index.php?action=product_details&id=$product_id");
        exit();
    }

    $model->add($_SESSION['user']['id'], $product_id, $rating, $comment);
    $_SESSION['success'] = "Review submitted!";
    header("Location: index.php?action=product_details&id=$product_id");
    exit();
}

function deleteReview() {
    global $conn;

    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        header("Location: index.php?action=products");
        exit();
    }

    $id         = (int)($_POST['id']         ?? 0);
    $product_id = (int)($_POST['product_id'] ?? 0);

    $model = new Review($conn);
    $model->delete($id, $_SESSION['user']['id']);
    $_SESSION['success'] = "Review deleted.";
    header("Location: index.php?action=product_details&id=$product_id");
    exit();
}

function editReview() {
    global $conn;

    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        header("Location: index.php?action=products");
        exit();
    }

    $id         = (int)($_POST['review_id']  ?? 0);
    $product_id = (int)($_POST['product_id'] ?? 0);
    $rating     = (int)($_POST['rating']     ?? 0);
    $comment    = trim($_POST['comment']     ?? '');

    if ($rating < 1 || $rating > 5 || empty($comment)) {
        $_SESSION['error'] = "Rating and comment are required.";
        header("Location: index.php?action=product_details&id=$product_id");
        exit();
    }

    $model = new Review($conn);
    $model->update($id, $_SESSION['user']['id'], $rating, $comment);
    $_SESSION['success'] = "Review updated.";
    header("Location: index.php?action=product_details&id=$product_id");
    exit();
}

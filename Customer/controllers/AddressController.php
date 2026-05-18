<?php

require_once __DIR__ . "/../models/db.php";
require_once __DIR__ . "/../models/ShippingAddress.php";
require_once __DIR__ . "/../models/DeliveryZone.php";

function addressList() {
    global $conn;

    $addressModel = new ShippingAddress($conn);
    $zoneModel    = new DeliveryZone($conn);

    $addresses = $addressModel->getByUser($_SESSION['user']['id']);
    $zones     = $zoneModel->getAll();
    $edit      = null;

    if (!empty($_GET['edit_id'])) {
        $edit = $addressModel->getById((int)$_GET['edit_id'], $_SESSION['user']['id']);
    }

    include __DIR__ . "/../views/customer/addresses.php";
}

function saveAddress() {
    global $conn;

    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        header("Location: index.php?action=addresses");
        exit();
    }

    $id               = (int)($_POST['id'] ?? 0);
    $full_name        = trim($_POST['full_name'] ?? '');
    $phone            = trim($_POST['phone'] ?? '');
    $address_line     = trim($_POST['address_line'] ?? '');
    $city             = trim($_POST['city'] ?? '');
    $delivery_zone_id = (int)($_POST['delivery_zone_id'] ?? 0);
    $is_default       = isset($_POST['is_default']) ? 1 : 0;

    if ($full_name === '' || $phone === '' || $address_line === '' || $city === '' || !$delivery_zone_id) {
        $_SESSION['error'] = "Please fill all address fields.";
        header("Location: index.php?action=addresses");
        exit();
    }

    $model = new ShippingAddress($conn);

    if ($id) {
        $model->update($id, $_SESSION['user']['id'], $full_name, $phone, $address_line, $city, $delivery_zone_id, $is_default);
        $_SESSION['success'] = "Address updated.";
    } else {
        $model->add($_SESSION['user']['id'], $full_name, $phone, $address_line, $city, $delivery_zone_id, $is_default);
        $_SESSION['success'] = "Address added.";
    }

    header("Location: index.php?action=addresses");
    exit();
}

function deleteAddress() {
    global $conn;

    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        header("Location: index.php?action=addresses");
        exit();
    }

    $id = (int)($_POST['id'] ?? 0);
    $model = new ShippingAddress($conn);
    $model->delete($id, $_SESSION['user']['id']);

    $_SESSION['success'] = "Address deleted.";
    header("Location: index.php?action=addresses");
    exit();
}

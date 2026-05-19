<?php
require_once 'models/DashboardModel.php';
require_once 'models/SellerModel.php';
require_once 'models/AdminDataModel.php';

class AdminController {
    private $dashboardModel;
    private $sellerModel;
    private $adminDataModel;

    public function __construct($db) {
        $this->dashboardModel = new DashboardModel($db);
        $this->sellerModel = new SellerModel($db);
        $this->adminDataModel = new AdminDataModel($db);
    }

    public function showDashboard() {
        $userStats = $this->dashboardModel->getUserStats();
        $revenueStats = $this->dashboardModel->getRevenueStats();
        
        require_once 'views/layout/header.php';
        require_once 'views/dashboard.php';
        require_once 'views/layout/footer.php';
    }

    public function showSellers() {
        $sellers = $this->sellerModel->getAllSellers();
        require_once 'views/layout/header.php';
        require_once 'views/sellers.php';
        require_once 'views/layout/footer.php';
    }

    public function addSeller() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = trim($_POST['name']);
            $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
            $password = $_POST['password'];
            $phone = trim($_POST['phone']);
            $shop_name = trim($_POST['shop_name']);
            $address = trim($_POST['address']);
            $commission = floatval($_POST['commission_rate']);

            if (!empty($name) && !empty($email) && !empty($password) && !empty($shop_name)) {
                $success = $this->sellerModel->createSeller($name, $email, $password, $phone, $shop_name, $address, $commission);
                if ($success) {
                    header("Location: index.php?action=sellers&msg=added");
                    exit();
                }
            }
            header("Location: index.php?action=sellers&msg=error");
            exit();
        }
    }

    public function removeSeller() {
        if (isset($_GET['id'])) {
            $seller_id = intval($_GET['id']);
            $success = $this->sellerModel->deleteSeller($seller_id);
            if ($success) {
                header("Location: index.php?action=sellers&msg=deleted");
                exit();
            }
        }
        header("Location: index.php?action=sellers&msg=error");
        exit();
    }

    public function approveSellerAjax() {
        header('Content-Type: application/json');
        if (ob_get_length()) ob_clean();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $seller_id = isset($_POST['id']) ? intval($_POST['id']) : 0;
            if ($seller_id > 0) {
                $updateSuccess = $this->sellerModel->updateApprovalStatus($seller_id, 1);
                if ($updateSuccess) {
                    echo json_encode(["success" => true, "message" => "Seller approved successfully."]);
                    exit();
                }
            }
            echo json_encode(["success" => false, "message" => "Parameter validation issue."]);
            exit();
        }
    }

    public function showCoupons() {
        $coupons = $this->adminDataModel->getCoupons();
        $sellers = $this->sellerModel->getAllSellers(); 

        require_once 'views/layout/header.php';
        require_once 'views/coupons.php';
        require_once 'views/layout/footer.php';
    }

    public function addCoupon() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $seller_id = !empty($_POST['seller_id']) ? intval($_POST['seller_id']) : null;
            $code = strtoupper(trim($_POST['code']));
            $discount_pct = floatval($_POST['discount_pct']);
            $max_uses = intval($_POST['max_uses']);
            $valid_until = $_POST['valid_until'];

            if (!empty($code) && $discount_pct > 0 && !empty($valid_until)) {
                $success = $this->adminDataModel->createCoupon($seller_id, $code, $discount_pct, $max_uses, $valid_until);
                if ($success) {
                    header("Location: index.php?action=coupons&msg=added");
                    exit();
                }
            }
            header("Location: index.php?action=coupons&msg=error");
            exit();
        }
    }

    public function removeCoupon() {
        if (isset($_GET['id'])) {
            $coupon_id = intval($_GET['id']);
            $success = $this->adminDataModel->hardDeleteCoupon($coupon_id);
            if ($success) {
                header("Location: index.php?action=coupons&msg=deleted");
                exit();
            }
        }
        header("Location: index.php?action=coupons&msg=error");
        exit();
    }

    public function showProducts() {
        $products = $this->adminDataModel->getProducts();
        require_once 'views/layout/header.php';
        require_once 'views/products.php';
        require_once 'views/layout/footer.php';
    }

    public function removeProduct() {
        if (isset($_GET['id'])) {
            $product_id = intval($_GET['id']);
            $success = $this->adminDataModel->softDeleteProduct($product_id);
            if ($success) {
                header("Location: index.php?action=products&msg=deleted");
                exit();
            }
        }
        header("Location: index.php?action=products&msg=error");
        exit();
    }

    public function showOrders() {
        $searchId = isset($_GET['search_id']) ? trim($_GET['search_id']) : null;
        $orders = $this->adminDataModel->getOrders($searchId);
        
        require_once 'views/layout/header.php';
        require_once 'views/orders.php';
        require_once 'views/layout/footer.php';
    }

    public function showCategories() {
        $categories = $this->adminDataModel->getCategories();
        require_once 'views/layout/header.php';
        require_once 'views/categories.php';
        require_once 'views/layout/footer.php';
    }


    public function showDisputes() {
        require_once 'views/layout/header.php';
        require_once 'views/disputes.php';
        require_once 'views/layout/footer.php';
    }

    public function showAnalytics() {
        require_once 'views/layout/header.php';
        require_once 'views/analytics.php';
        require_once 'views/layout/footer.php';
    }
}
?>
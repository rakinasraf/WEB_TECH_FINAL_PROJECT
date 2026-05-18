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

    /**
     * Aggregates platform operational analytics statistics metrics 
     * and compiles layout view structure layers systematically.
     */
    public function showDashboard() {
        // Core metrics calculations extracts loaded via database models layers directly
        $userStats = $this->dashboardModel->getUserStats();
        $revenueStats = $this->dashboardModel->getRevenueStats();
        
        // Fetch raw sellers collection data to handle validation lists dynamically
        $unapprovedSellers = $this->sellerModel->getAllSellers();
        
        // Assemble UI Layers seamlessly using include configurations frames logic
        require_once 'views/layout/header.php';
        require_once 'views/dashboard.php';
        require_once 'views/layout/footer.php';
    }

    public function approveSellerAjax() {
        header('Content-Type: application/json');
        if (ob_get_length()) ob_clean();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $seller_id = isset($_POST['id']) ? intval($_POST['id']) : 0;
            if ($seller_id > 0) {
                $updateSuccess = $this->sellerModel->updateApprovalStatus($seller_id, 1);
                if ($updateSuccess) {
                    echo json_encode(["success" => true, "message" => "Seller approved successfully standard matrix validation."]);
                    exit();
                }
            }
            echo json_encode(["success" => false, "message" => "Execution framework failures structural update parameters missing."]);
            exit();
        }
    }

    public function showSellers() {
        $sellers = $this->sellerModel->getAllSellers();
        require_once 'views/layout/header.php';
        require_once 'views/sellers.php';
        require_once 'views/layout/footer.php';
    }

    public function showCategories() {
        $categories = $this->adminDataModel->getCategories();
        require_once 'views/layout/header.php';
        require_once 'views/categories.php';
        require_once 'views/layout/footer.php';
    }

    public function showProducts() {
        $products = $this->adminDataModel->getProducts();
        require_once 'views/layout/header.php';
        require_once 'views/products.php';
        require_once 'views/layout/footer.php';
    }

    public function showOrders() {
        $orders = $this->adminDataModel->getOrders();
        require_once 'views/layout/header.php';
        require_once 'views/orders.php';
        require_once 'views/layout/footer.php';
    }

    public function showCoupons() {
        $coupons = $this->adminDataModel->getCoupons();
        require_once 'views/layout/header.php';
        require_once 'views/coupons.php';
        require_once 'views/layout/footer.php';
    }

    public function showDisputes() {
        require_once 'views/layout/header.php';
        require_once 'views/disputes.php';
        require_once 'views/layout/footer.php';
    }

    public function showAnalytics() {
        $revenueStats = $this->dashboardModel->getRevenueStats();
        require_once 'views/layout/header.php';
        require_once 'views/analytics.php';
        require_once 'views/layout/footer.php';
    }
}

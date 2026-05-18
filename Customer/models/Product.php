<?php

class Product {

    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    private function productSelectSql() {
        return "SELECT p.*,
                       p.primary_image_path AS image,
                       p.stock_qty AS stock,
                       c.name AS category,
                       c.slug AS category_slug
                FROM products p
                LEFT JOIN categories c ON c.id = p.category_id";
    }

    
    public function getAll($keyword = '', $category = '', $min_price = '', $max_price = '') {
        $sql = $this->productSelectSql() . " WHERE p.stock_qty > 0 AND p.status = 'active'";

        if ($keyword !== '') {
            $kw = mysqli_real_escape_string($this->conn, "%" . $keyword . "%");
            $sql .= " AND (p.name LIKE '$kw' OR p.description LIKE '$kw')";
        }

        if ($category !== '') {
            if (ctype_digit((string)$category)) {
                $category = (int)$category;
                $sql .= " AND p.category_id = $category";
            } else {
                $category = mysqli_real_escape_string($this->conn, $category);
                $sql .= " AND (c.slug = '$category' OR c.name = '$category')";
            }
        }

        if ($min_price !== '') {
            $min_price = (float)$min_price;
            $sql .= " AND p.price >= $min_price";
        }

        if ($max_price !== '') {
            $max_price = (float)$max_price;
            $sql .= " AND p.price <= $max_price";
        }

        $sql .= " ORDER BY p.created_at DESC";

        $result = mysqli_query($this->conn, $sql);
        return mysqli_fetch_all($result, MYSQLI_ASSOC);
    }

    public function getById($id) {
        $id = (int)$id;
        $sql = $this->productSelectSql() . " WHERE p.id = $id";
        $result = mysqli_query($this->conn, $sql);
        return mysqli_fetch_assoc($result);
    }

    public function getCategories() {
        $result = mysqli_query(
            $this->conn,
            "SELECT id, name, slug, name AS category
             FROM categories
             WHERE is_active = 1
             ORDER BY name"
        );
        return mysqli_fetch_all($result, MYSQLI_ASSOC);
    }

    public function getByIds($ids) {
        if (empty($ids)) return [];
        $ids = array_values(array_filter(array_map('intval', $ids)));
        if (empty($ids)) return [];

        $id_list = implode(',', $ids);
        $sql = $this->productSelectSql() . " WHERE p.id IN ($id_list)";
        $result = mysqli_query($this->conn, $sql);
        return mysqli_fetch_all($result, MYSQLI_ASSOC);
    }

    public function getAvgRating($id) {
        $id = (int)$id;
        $sql = "SELECT ROUND(AVG(rating),1) AS avg_rating, COUNT(*) AS total FROM reviews WHERE product_id = $id";
        $result = mysqli_query($this->conn, $sql);
        return mysqli_fetch_assoc($result);
    }
}

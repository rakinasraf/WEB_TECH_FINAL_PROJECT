<?php

require_once("database.php");

class ProductModel
{
    private $conn;

    public function __construct($conn)
    {
        $this->conn = $conn;
    }

    // ADD PRODUCT
    public function addProduct($data)
    {
        $sql = "INSERT INTO products
                (seller_id, category_id, name, description,
                 price, stock_qty, primary_image_path)
                VALUES(?,?,?,?,?,?,?)";

        $stmt = $this->conn->prepare($sql);

        $stmt->bind_param(
            "iissdis",
            $data['seller_id'],
            $data['category_id'],
            $data['name'],
            $data['description'],
            $data['price'],
            $data['stock_qty'],
            $data['image']
        );

        return $stmt->execute();
    }

    // GET PRODUCTS
    public function getProducts($seller_id)
    {
        $sql = "SELECT p.*, c.name AS category_name
                FROM products p
                JOIN categories c ON p.category_id = c.id
                WHERE seller_id=?";

        $stmt = $this->conn->prepare($sql);

        $stmt->bind_param("i",$seller_id);

        $stmt->execute();

        return $stmt->get_result();
    }

    // GET SINGLE PRODUCT
    public function getSingleProduct($id,$seller_id)
    {
        $sql = "SELECT *
            FROM products
            WHERE id=?
            AND seller_id=?";

        $stmt = $this->conn->prepare($sql);

        $stmt->bind_param("ii",$id,$seller_id);

        $stmt->execute();

        return $stmt->get_result()->fetch_assoc();
    }

    // UPDATE PRODUCT
    public function updateProduct($data)
    {
        $sql = "UPDATE products
                SET category_id=?,
                    name=?,
                    description=?,
                    price=?,
                    stock_qty=?
                WHERE id=?";

        $stmt = $this->conn->prepare($sql);

        $stmt->bind_param(
            "issdii",
            $data['category_id'],
            $data['name'],
            $data['description'],
            $data['price'],
            $data['stock_qty'],
            $data['id']
        );

        return $stmt->execute();
    }

    // DELETE PRODUCT
    public function deleteProduct($id)
    {
        $sql = "DELETE FROM products WHERE id=?";

        $stmt = $this->conn->prepare($sql);

        $stmt->bind_param("i",$id);

        return $stmt->execute();
    }
}
?>
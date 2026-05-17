<?php
require_once("database.php");
if(isset($_POST['product_id']))
{
    $product_id = $_POST['product_id'];

    // current status fetch
    $sql = "SELECT is_available
            FROM products
            WHERE id=?";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i",$product_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    $newStatus = ($row['is_available'] == 1) ? 0 : 1;

    // update status
    $sql2 = "UPDATE products
             SET is_available=?
             WHERE id=?";

    $stmt2 = $conn->prepare($sql2);
    $stmt2->bind_param("ii",$newStatus,$product_id);
    
    if($stmt2->execute())
    {
        echo json_encode([
            "success" => true,
            "newStatus" => $newStatus
        ]);
    }
}
?>
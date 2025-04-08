<?php
// fetch-product.php

// Include database connection
include("dbinfo.php");

if (isset($_GET['barcode'])) {
    $barcode = $_GET['barcode'];

    // Query the database to get product details by barcode
    $sql = "SELECT * FROM product_tbl WHERE barcode = '$barcode' LIMIT 1";
    $result = mysqli_query($con, $sql);
    
    if (mysqli_num_rows($result) > 0) {
        $product = mysqli_fetch_assoc($result);
        
        // Return product details in JSON format, including barcode
        echo json_encode([
            'p_id' => $product['product_id'],
            'barcode' => $product['barcode'], // Adding barcode in the response
            'product_name' => $product['product_name'],
            'stock' => $product['stock'],
            'sale' => $product['sale']
        ]);
    } else {
        echo json_encode(null); // Product not found
    }
} elseif (isset($_GET['product_name'])) {
    $productName = $_GET['product_name'];

    // Query the database to get product details by product name
    $sql = "SELECT * FROM product_tbl WHERE product_name = '$productName' LIMIT 1";
    $result = mysqli_query($con, $sql);
    
    if (mysqli_num_rows($result) > 0) {
        $product = mysqli_fetch_assoc($result);
        
        // Return product details in JSON format, including barcode
        echo json_encode([
            'p_id' => $product['product_id'],
            'barcode' => $product['barcode'], // Adding barcode in the response
            'product_name' => $product['product_name'],
            'stock' => $product['stock'],
            'sale' => $product['sale']
        ]);
    } else {
        echo json_encode(null); // Product not found
    }
} else {
    echo json_encode(null); // No barcode or product name provided
}
?>

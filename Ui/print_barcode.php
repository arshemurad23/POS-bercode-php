

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <script>
        
        window.onload = function() {
            window.print();
        };
    </script>





</head>
<body>


<?php
// Check if form is submitted

// Capture form data
$product_name = $_POST['product_name'];
$barcode = $_POST['barcode'];  // This seems to be the actual barcode value
$sale = $_POST['sale'];
$stock = $_POST['stock'];
$barcode_quantity = $_POST['barcode_quantity'];

// Load the Barcode Generator class
require 'vendor/autoload.php';
use Picqer\Barcode\BarcodeGeneratorPNG;

// Create the Barcode generator object
$generator = new BarcodeGeneratorPNG();

// Create a container for the barcodes
echo '<div style="display: flex; flex-wrap: wrap; justify-content: flex-start;">';

for ($i = 0; $i < $barcode_quantity; $i++) {
    // Generate the barcode using the product name (or barcode field, based on your needs)
    $barcodeImage = $generator->getBarcode("$barcode", $generator::TYPE_CODE_128);

    // Display the barcode with product details
    echo '
        <div style="text-align: center; margin: 10px;">
            <span>Item: ' . $product_name . '</span><br>
            <img src="data:image/png;base64,' . base64_encode($barcodeImage) . '" /><br>
            <span>' . $barcode . '</span><br>
            <span>Price: ' . $sale . '</span><br>
        </div>';
}

// Close the container div
echo '</div>';
?>

</body>
</html>

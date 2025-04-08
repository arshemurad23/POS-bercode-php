<?php
require 'vendor/autoload.php';

use Picqer\Barcode\BarcodeGeneratorPNG;


    // Barcode generator object create karein
    $generator = new BarcodeGeneratorPNG();

    // Barcode ko generate karein
    $barcode = $generator->getBarcode('454644h6fg5', $generator::TYPE_CODE_128);

    // HTML mein barcode image ko display karen
    echo '<img src="data:image/png;base64,' . base64_encode($barcode) . '" />';

?>

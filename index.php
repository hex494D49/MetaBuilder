<?php

require_once 'Models/User.php';
require_once 'Models/Product.php';
require_once 'Utilities/Attributes.php';
require_once 'Utilities/MetaBuilder.php';  
require_once 'Controllers/UserController.php';

$classes = ['User', 'Product'];
$metadata = [];

foreach ($classes as $class) {
    try {
        $metaBuilder = new MetaBuilder($class);
        $metadata[$class] = json_decode($metaBuilder->buildJsonStructure(), true);
    } catch (Exception $e) {
        echo "Error processing class {$class}: " . $e->getMessage() . "\n";
    }
}

echo json_encode($metadata, JSON_PRETTY_PRINT);

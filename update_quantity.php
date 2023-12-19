<?php
session_start();

if (isset($_GET['product_id']) && isset($_GET['action'])) {
    $productId = $_GET['product_id'];
    $action = $_GET['action'];

    // Find the product in the shopping cart
    $existingKey = array_search($productId, array_column($_SESSION['shopping_cart'], 'id'));

    if ($existingKey !== false) {
        // Perform the action
        if ($action === 'increase') {
            $_SESSION['shopping_cart'][$existingKey]['quantity']++;
        } elseif ($action === 'decrease') {
            // Ensure quantity does not go below 1
            if ($_SESSION['shopping_cart'][$existingKey]['quantity'] > 1) {
                $_SESSION['shopping_cart'][$existingKey]['quantity']--;
            } else {
                // Remove the product if quantity is 1 and decreasing
                array_splice($_SESSION['shopping_cart'], $existingKey, 1);
            }
        }
    }
}

// Redirect back to shopping-cart.php
header('Location: shopping-cart.php');
exit();
?>

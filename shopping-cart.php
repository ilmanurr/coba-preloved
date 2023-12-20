<?php
session_start();

// Check if the user is logged in
if (isset($_SESSION['username'])) {
    $loggedInUsername = $_SESSION['username'];
}

// Check if 'shopping_cart' is set in the session
if (isset($_SESSION['shopping_cart'])) {
    // Simpan data produk ke dalam session
    $_SESSION['checkout_products'] = $_SESSION['shopping_cart'];

    // Check if the cancel button is clicked
    if (isset($_POST['cancel'])) {
        // Perform actions when the cancel button is clicked
        // For example, clear the current order from the session
        unset($_SESSION['checkout_products']);
        header("Location: shopping-cart.php"); // Redirect to the same page to refresh the content
        exit();
    }
} 
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Preloved-You</title>
    <link rel="icon" href="image/Preloved-logo-png.png">

    <!-- Font style -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,300;0,400;0,700;1,700&display=swap" rel="stylesheet">

    <!-- Feather icons -->
    <script src="https://unpkg.com/feather-icons"></script>

    <!-- CSS style -->
    <link rel="stylesheet" href="css/style_cart.css">
    
    <!-- JavaScript -->
    <script>
        // Function to increment or decrement the quantity
        function updateQuantity(productId, action) {
            // Send the product ID and action to a PHP script
            window.location.href = 'update_quantity.php?product_id=' + productId + '&action=' + action;
        }
    </script>
</head>

<body>
    <div class="shopping-cart">
        <h2>Shopping Cart</h2>
        
        <?php
        // Check if there is a cart message
        if (isset($_SESSION['cart_message'])) {
            echo '<p class="cart-message">' . $_SESSION['cart_message'] . '</p>';
            // Clear the cart message after displaying it
            unset($_SESSION['cart_message']);
        }

        // Check if there are items in the shopping cart
        if (isset($_SESSION['shopping_cart']) && count($_SESSION['shopping_cart']) > 0) {
            // Initialize total
            $total = 0;

            // Loop through each item in the shopping cart
            foreach ($_SESSION['shopping_cart'] as $item) {
                echo '<div class="produk-cart">';
                echo '<div class="row-produk-cart">';
                echo '<img src="images/' . $item['image'] . '" alt="' . $item['name'] . '">';
                echo '<p class="nama-produk">' . $item['name'] . '</p>';
                echo '<p class="harga-produk">Rp ' . number_format($item['price'], 0, ',', '.') . '</p>';
                echo '<p class="jumlah-produk">x' . $item['quantity'] . '</p>';
                echo '<div class="jumlah-produk">';
                echo '<span class="minus" onclick="updateQuantity(' . $item['id'] . ', \'decrease\')">-</span>';
                echo '<span>' . $item['quantity'] . '</span>';
                echo '<span class="plus" onclick="updateQuantity(' . $item['id'] . ', \'increase\')">+</span>';
                echo '</div>';
                echo '</div>';
                echo '</div>';
                // Accumulate total
                $total += $item['price'] * $item['quantity'];
            }

            // Display total
            echo '<p class="total-harga">Total Harga: Rp ' . number_format($total, 0, ',', '.') . '</p>';
        } else {
            echo '<p class="cart-message">Keranjang belanja Anda kosong.</p>';
        }
        ?>

        <div class="tombol-cart">
            <a href="produk-kami.php" class="cta">Kembali</a>
            <a href="checkout.php" class="cta">Checkout</a>
        </div>
    </div>

    <!-- Footer start -->
    <footer>
        <div class="isi-footer">
            <a href="index.php">Beranda</a>
            <a href="produk-kami.php">Produk Kami</a>
            <a href="kontak-kami.php">Kontak Kami</a>
            <p>Created by Preloved.you's team | &copy 2023</p>
        </div>
    </footer>
    <!-- Footer end -->
</body>

</html>
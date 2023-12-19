<?php
// Start the session
session_start();

// Check if the user is logged in
if (isset($_SESSION['username'])) {
    $loggedInUsername = $_SESSION['username'];
}

// Function to get the total quantity of items in the shopping cart
function getTotalCartQuantity() {
    $totalQuantity = 0;

    if (isset($_SESSION['shopping_cart'])) {
        foreach ($_SESSION['shopping_cart'] as $item) {
            $totalQuantity += $item['quantity'];
        }
    }

    return $totalQuantity;
}

// Retrieve the status information from the session
$statusPemesanan = isset($_SESSION['status_pemesanan']) ? $_SESSION['status_pemesanan'] : 'Menunggu Konfirmasi';

// Retrieve all previous orders from the session
$previousOrders = isset($_SESSION['previous_orders']) ? $_SESSION['previous_orders'] : array();

if (isset($_POST['hapus_semua'])) {
    // Remove all items from the shopping cart
    unset($_SESSION['previous_orders']);
    echo 'Form submitted';
}
?>

<!DOCTYPE html>
<html lang="en">
    
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE-edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Preloved-You</title>
    <link rel="icon" href="image/Preloved-logo-png.png">

    <!-- font style -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,300;0,400;0,700;1,700&display=swap" rel="stylesheet">

    <!-- feather icons -->
    <script src="https://unpkg.com/feather-icons"></script>
    
    <!-- css style -->
    <link rel="stylesheet" href="css/style.css">
</head>

<body>
    <!-- Navbar Section start -->
    <nav class="navbar">
        <a href="#" class="logo-navbar">Preloved<span>.you</span></a>
        <div class="isinavbar">
            <ul class="ul-navbar">
                <li class="list-navbar">
                    <a href="index.php">Beranda</a>
                </li>
                <li class="list-navbar">
                    <a href="produk-kami.php">Produk Kami</a>
                </li>
                <li class="list-navbar">
                    <a href="keranjang.php">Pesananmu</a>
                </li>
                <li class="list-navbar">
                    <a href="kontak-kami.php">Kontak Kami</a>
                </li>
            </ul>
        </div>

        <!-- icon navbar -->
        <div class="navbar-extra">
            <a href="#" id="search-button"><i data-feather="search"></i></a>
            <a href="shopping-cart.php" id="shopping-cart-button"><i data-feather="shopping-cart"></i><span id="icon-cart-span"><?php echo getTotalCartQuantity(); ?></span></a>
            <a href="registration.html" id="profil-menu"><i data-feather="user"></i></a>
            <a href="#" id="hamburger-menu"><i data-feather="menu"></i></a>
        </div>

        <!-- search form start -->
        <div class="search-form">
            <input type="text" id="search-box" placeholder="Search here...">
            <label for="search-box"><i data-feather="search"></i></label>
        </div>
        <!-- search form end -->

        <!-- Login form start -->
        <div class="login-form">
            <?php
            // If the user is logged in, display the username
            if (isset($loggedInUsername)) {
                echo '<h3 id="login-box">' . $loggedInUsername . '</h3>';
                echo '<a href="logout.php" class="cta" for="login-box">Logout</a>';
            } else {
                // If the user is not logged in, display the login link
                echo '<h3 id="login-box">Login sekarang</h3>';
                echo '<a href="login.html" class="cta" for="login-box">Login</a>';
                echo '<p>Belum punya akun? <a href="registration.html">Daftar</a></p>';
            }
            ?>
        </div>
        <!-- Login navbar end -->


    </nav>
    <!-- Navbar Section end -->
    
    <!-- Cart Section start -->
    <section class="carts" id="carts">
        <h2><span>Pesanan</span> Kamu</h2>
        <p>Lihat riwayat pesanan kamu di preloved.you</p>

            <!-- Add a form for deleting all products -->
        <form method="post" action="keranjang.php">
            <button type="submit" name="hapus_semua" class="hapus-semua-btn">Batalkan Semua Pesanan</button>
        </form>
        
        <div class="row">
        <?php
        foreach ($previousOrders as $order) {
            echo '<div class="order-details">';

            // Loop untuk menampilkan produk yang dipilih
            foreach ($order['products'] as $item) {
                echo '<div class="list-carts">';
                echo '<img src="images/' . $item['image'] . '" alt="' . $item['name'] . '">';
                echo '<p class="name">' . $item['name'] . '</p>';
                echo '<p class="price">Rp ' . number_format($item['price'], 0, ',', '.') . '</p>';
                echo '<p class="quantity">Jumlah: ' . $item['quantity'] . '</p>';
                echo '<br>';
            }

            echo '<div class="order-summary">';
            echo '<p>Total Ongkos Kirim</p>';
            echo '<p class="harga">Rp ' . number_format($order['hargaOngkir'], 0, ',', '.') . '</p>';
            echo '<p>Total Belanja</p>';
            echo '<p class="harga">Rp ' . number_format($order['totalHarga'] + $order['hargaOngkir'], 0, ',', '.') . '</p>';
            echo '</div>';

            echo '</div>';
            echo '</div>';
        }
        ?>

        </div>
    </section>
    <!-- Cart Section end -->

    <!-- Footer start -->
    <footer>
        <div class="sosmed">
            <a href="https://instagram.com/">Instagram</a>
            <a href="index.php">Beranda</a>
            <a href="produk-kami.php">Produk Kami</a>
            <a href="keranjang.php">Pesananmu</a>
            <a href="kontak-kami.php">Kontak Kami</a>
        </div>
        <div class="credit">
            <p>Created by Preloved.you's team | &copy 2023</p>
        </div>
    </footer>
    <!-- Footer end -->
    
    <!-- feather icons -->
    <script>
      feather.replace()
    </script>
  
  <!-- my js script -->
    <script src="js/script.js"></script>
</body>
</html>

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
    
    <!-- Contact Section start -->
    <section id="contact" class="contact">
        <h2><span>Kontak</span> Kami</h2>
        <p>Jika kamu membutuhkan informasi lain mengenai produk preloved.you, jangan ragu untuk menghubungi kami.</p>
        
        <div class="row-contact">
            <a href="https://whatsapp.com/" class="cta">WhatsApp</a>
            <a href="https://gmail.com/" class="cta">Email</a>            
            <a href="https://instagram.com/" class="cta">Instagram</a>
        </div>

        <div class="row-alamat-saran">
            <div class="row-alamat">
                <h3>Alamat Kami</h3>
                <p>Jl. Ketintang, Kec. Gayungan, Surabaya</p>
                <p class="telp">Telepon : <a href="">0897234567</a></p>
                <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3957.375286497052!2d112.72461187431495!3d-7.3116690718883595!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2dd7fb4cb05e34ed%3A0x90f4c8a169558495!2sVokasi%20UNESA!5e0!3m2!1sid!2sid!4v1702960776391!5m2!1sid!2sid" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade" class="map"></iframe>
            </div>
            <div class="row-kritik-saran">
                <h3>Kritik & Saran</h3>
                <form action="">
                    <div class="input-group">
                        <input type="text" placeholder="Nama">
                    </div>
                    <div class="input-group">
                        <input type="text" placeholder="E-mail">
                    </div>
                    <div class="input-group">
                        <textarea name="" id="" cols="30" rows="5" placeholder="Kritik & Saran"></textarea>
                    </div>
                    <button type="submit" class="submit-button">Kirim</button>
                </form>
            </div>
        </div>
    </section>
    <!-- Contact Section end -->

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

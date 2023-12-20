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

    <!-- Hero Section start -->
    <section class="hero" id="hero-content">
        <img src="image/hero5-gif.gif" alt="gambar hero" class="hero-img">
        <div class="hero-content">
            <h1>Temukan baju <span>preloved-mu</span> disini!</h1>
            <p>kualitas terbaik, harga terjangkau, perhatian pada lingkungan, pilihan gaya yang beragam, dan pengalaman berbelanja yang menyenangkan!</p>
            <a href="produk-kami.php" class="cta">Beli Sekarang</a>
        </div>
    </section>
    <!-- Hero Section end -->

    <!-- About section start -->
    <section class="home-content" id="about-content">
        <h2><span>Tentang</span> Kami</h2>
        <div class="row">
            <div class="about-img">
                <img src="image/hero1.jpg" alt="Tentang Kami">
            </div>
            <div class="kenapa-content">
                <h3>Kenapa harus Preloved.you ?</h3>
                <p>Preloved.you merupakan destinasi tempat belanja baju preloved terbaik untuk kamu, Kamu dapat menemukan pakaian bermerk atau
                    berkualitas tinggi tanpa harus menguras dompet. Serta kamu dapat berkontribusi dalam mengurangi limbah tekstil dan jejak karbon produksi pakaian baru.</p>
            </div>
        </div>
    </section>
    <!-- About Section end -->

    <!-- Review section start -->
    <section class="review" id="review">
        <h2>Bagaimana pendapat mereka tentang <span>Preloved.you</span> ?</h2>

        <div class="row-review" id="row-review">
            <div class="review-card">
                <h3>Nabila</h3>
                <p>"Makasih, Preloved.you! Aku seneng banget belanja di sini. Banyak pakaian preloved yang cantik banget, dan harganya juga masih oke. Kualitasnya juara!"</p>
            </div>
            <div class="review-card">
                <h3>Alex</h3>
                <p>"Gue suka banget Preloved.you, banyak baju branded yang terjangkau tapi kualitasnya ga main-main. Websitenya juga simpel banget."</p>
            </div>
            <div class="review-card">
                <h3>Sania</h3>
                <p>"Bakalan jadi langganan aku banget! mau belanja jadi ga ribet dan ga cape. Banyak pilihannya dan ga susah buat pesen!"</p>
            </div>
            <div class="review-card">
                <h3>Gladis</h3>
                <p>"Jatuh cinta sama Preloved.you!, Banyak pilihan dan harganya masih bisa dicicipin. Plus, gw ngerasa gw nolong bumi juga pas belanja di sini.".</p>
            </div>
            <div class="review-card">
                <h3>Hans</h3>
                <p>"Preloved.you itu praktis banget buat belanja. Gue tinggal klik sana-sini, langsung nemu baju yang oke buat gue. Gak ribet sama sekali!"</p>
            </div>
        </div>
    </section>
    <!-- Review section end -->

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
    <script src="js/script_checkout.js"></script>
</body>

</html>

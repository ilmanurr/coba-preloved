<?php
session_start();

// Check if the user is logged in
if (isset($_SESSION['username'])) {
    $loggedInUsername = $_SESSION['username'];
}

// Check if the product is added to the cart
if (isset($_GET['tambahkan_keranjang']) && $_GET['tambahkan_keranjang'] == 'true') {
    handleAddToCart();
    // Redirect back to produk-kami.php to prevent duplicate form submissions
    header('Location: shopping-cart.php');
    exit();
}

function handleAddToCart() {
    // Get product details from the URL
    $productId = $_GET['product_id'];
    $productName = $_GET['product_name'];
    $productPrice = $_GET['product_price'];
    $productImage = $_GET['product_image'];

    // Initialize the shopping cart if not exists
    if (!isset($_SESSION['shopping_cart'])) {
        $_SESSION['shopping_cart'] = array();
    }

    // Check if the product is already in the cart
    $existingKey = array_search($productId, array_column($_SESSION['shopping_cart'], 'id'));
    if ($existingKey !== false) {
        // Increment quantity if the product is already in the cart
        $_SESSION['shopping_cart'][$existingKey]['quantity']++;
    } else {
        // Add the new product to the cart
        $_SESSION['shopping_cart'][] = [
            'id' => $productId,
            'name' => $productName,
            'price' => $productPrice,
            'image' => $productImage,
            'quantity' => 1,
        ];

        // Set a success message
        $_SESSION['cart_message'] = 'Produk "' . $productName . '" berhasil ditambahkan ke keranjang.';
    }
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

    <!-- Product Section start -->
    <section class="product" id="all-products">
        <h2><span>Produk</span> Kami</h2>
        <div class="row" id="row-all-product">

        <?php
        // Fetch data from the database
        include_once 'crud/config.php';
        include_once 'crud/database.php';

        $db = new Database();
        $query = "SELECT * FROM produk";
        $result = $db->pilih_data($query);

        if ($result) {
            while ($row = mysqli_fetch_assoc($result)) {
                echo '<div class="list-produk">';
                echo '<form method="post" action="produk-kami.php">';
                echo '<img src="images/' . $row['foto'] . '" alt="' . $row['nama_produk'] . '">'; 
                echo '<h3 class="produk-tittle">' . $row['nama_produk'] . '</h3>'; 
                echo '<p class="produk-price">Rp ' . number_format($row['harga_satuan'], 0, ',', '.') . '</p>'; 
                // Add an anchor link to submit the product details to the shopping cart
                echo '<div class="produk-button">';
                echo '<a href="produk-kami.php?tambahkan_keranjang=true&product_id=' . $row['id'] . '&product_name=' . urlencode($row['nama_produk']) . '&product_price=' . $row['harga_satuan'] . '&product_image=' . urlencode($row['foto']) . '" class="masukkan-keranjang">Masukkan keranjang</a>';
                echo '<a href="#modal-' . strtolower(str_replace(" ", "-", $row['nama_produk'])) . '?product_id=' . $row['id'] . '&product_name=' . urlencode($row['nama_produk']) . '&product_price=' . $row['harga_satuan'] . '&product_image=' . urlencode($row['foto']) . '" class="detail-produk">Detail</a>';
                echo '</div>';
                echo '</div>';
            }
        }
        ?>
        </div>
    </section>
    <!-- Product Section end -->

    <!-- Modal Box Item Detail start -->
    <div class="detail-box" id="modal-sweater-stripe">
        <div class="detail-box-container">
            <a href="#" class="close-icon"><i data-feather="x"></i></a>
            <div class="detail-content">
                <div class="slider-container" >
                    <a href="#" class="slider-btn" id="prevBtn"><i data-feather="chevron-left"></i></a>
                    <div class="slide-img">
                        <img src="image/sweater-stripe.jpg" alt="">
                    </div>
                    <div class="slide-img">
                        <img src="image/kemeja-maroon.jpg" alt="">
                    </div>
                    <div class="slide-img">
                        <img src="image/hoodie-cream.jpg" alt="">
                    </div>
                    <div class="slide-img">
                        <img src="image/kemeja-hitam.jpg" alt="">
                    </div>
                    <a href="#" class="slider-btn" id="nextBtn"><i data-feather="chevron-right"></i></a>
                </div>
                <div class="konten-produk">
                    <h3 class="produk-tittle">Sweater Stripe</h3>
                    <p class="deskripsi-produk">deskripsi produk bla bla bla Lorem ipsum dolor sit amet consectetur adipisicing elit. Fugiat omnis nisi alias temporibus, quos eos.</p>
                    <p class="produk-price">Rp 60.000</p>
                </div>
            </div>
        </div> 
    </div>
    <div class="detail-box" id="modal-kemeja-maroon">
        <div class="detail-box-container">
            <a href="#" class="close-icon"><i data-feather="x"></i></a>
            <div class="detail-content">
                <div class="slider-container" >
                    <a href="#" class="slider-btn" id="prevBtn"><i data-feather="chevron-left"></i></a>
                    <div class="slide-img">
                        <img src="image/kemeja-maroon.jpg" alt="">
                    </div>
                    <div class="slide-img">
                        <img src="image/kemeja-maroon.jpg" alt="">
                    </div>
                    <div class="slide-img">
                        <img src="image/hoodie-cream.jpg" alt="">
                    </div>
                    <div class="slide-img">
                        <img src="image/kemeja-hitam.jpg" alt="">
                    </div>
                    <a href="#" class="slider-btn" id="nextBtn"><i data-feather="chevron-right"></i></a>
                </div>
                <div class="konten-produk">
                    <h3 class="produk-tittle">Kemeja Maroon</h3>
                    <p class="deskripsi-produk">deskripsi produk bla bla bla Lorem ipsum dolor sit amet consectetur adipisicing elit. Fugiat omnis nisi alias temporibus, quos eos.</p>
                    <p class="produk-price">Rp 50.000</p>
                </div>
            </div>
        </div> 
    </div>
    <div class="detail-box" id="modal-sweater-coklat">
        <div class="detail-box-container">
            <a href="#" class="close-icon"><i data-feather="x"></i></a>
            <div class="detail-content">
                <div class="slider-container" >
                    <a href="#" class="slider-btn" id="prevBtn"><i data-feather="chevron-left"></i></a>
                    <div class="slide-img">
                        <img src="image/sweater-coklat.jpg" alt="">
                    </div>
                    <div class="slide-img">
                        <img src="image/kemeja-maroon.jpg" alt="">
                    </div>
                    <div class="slide-img">
                        <img src="image/hoodie-cream.jpg" alt="">
                    </div>
                    <div class="slide-img">
                        <img src="image/kemeja-hitam.jpg" alt="">
                    </div>
                    <a href="#" class="slider-btn" id="nextBtn"><i data-feather="chevron-right"></i></a>
                </div>
                <div class="konten-produk">
                    <h3 class="produk-tittle">Sweater Coklat</h3>
                    <p class="deskripsi-produk">deskripsi produk bla bla bla Lorem ipsum dolor sit amet consectetur adipisicing elit. Fugiat omnis nisi alias temporibus, quos eos.</p>
                    <p class="produk-price">Rp 60.000</p>
                </div>
            </div>
        </div> 
    </div>
    <div class="detail-box" id="modal-kemeja-abu">
        <div class="detail-box-container">
            <a href="#" class="close-icon"><i data-feather="x"></i></a>
            <div class="detail-content">
                <div class="slider-container" >
                    <a href="#" class="slider-btn" id="prevBtn"><i data-feather="chevron-left"></i></a>
                    <div class="slide-img">
                        <img src="image/kemeja-abu.jpg" alt="">
                    </div>
                    <div class="slide-img">
                        <img src="image/kemeja-maroon.jpg" alt="">
                    </div>
                    <div class="slide-img">
                        <img src="image/hoodie-cream.jpg" alt="">
                    </div>
                    <div class="slide-img">
                        <img src="image/kemeja-hitam.jpg" alt="">
                    </div>
                    <a href="#" class="slider-btn" id="nextBtn"><i data-feather="chevron-right"></i></a>
                </div>
                <div class="konten-produk">
                    <h3 class="produk-tittle">Kemeja Abu</h3>
                    <p class="deskripsi-produk">deskripsi produk bla bla bla Lorem ipsum dolor sit amet consectetur adipisicing elit. Fugiat omnis nisi alias temporibus, quos eos.</p>
                    <p class="produk-price">Rp 50.000</p>
                </div>
            </div>
        </div> 
    </div>
    <div class="detail-box" id="modal-kemeja-flanel-coklat">
        <div class="detail-box-container">
            <a href="#" class="close-icon"><i data-feather="x"></i></a>
            <div class="detail-content">
                <div class="slider-container" >
                    <a href="#" class="slider-btn" id="prevBtn"><i data-feather="chevron-left"></i></a>
                    <div class="slide-img">
                        <img src="image/kemeja-flanel-coklat.jpg" alt="">
                    </div>
                    <div class="slide-img">
                        <img src="image/kemeja-biru.jpg" alt="">
                    </div>
                    <div class="slide-img">
                        <img src="image/hoodie-cream.jpg" alt="">
                    </div>
                    <div class="slide-img">
                        <img src="image/kemeja-hitam.jpg" alt="">
                    </div>
                    <a href="#" class="slider-btn" id="nextBtn"><i data-feather="chevron-right"></i></a>
                </div>
                <div class="konten-produk">
                    <h3 class="produk-tittle">Kemeja Flanel Coklat</h3>
                    <p class="deskripsi-produk">deskripsi produk bla bla bla Lorem ipsum dolor sit amet consectetur adipisicing elit. Fugiat omnis nisi alias temporibus, quos eos.</p>
                    <p class="produk-price">Rp 50.000</p>
                </div>
            </div>
        </div> 
    </div>
    <div class="detail-box" id="modal-hoodie-hijau">
        <div class="detail-box-container">
            <a href="#" class="close-icon"><i data-feather="x"></i></a>
            <div class="detail-content">
                <div class="slider-container" >
                    <a href="#" class="slider-btn" id="prevBtn"><i data-feather="chevron-left"></i></a>
                    <div class="slide-img">
                        <img src="image/hoodie-hijau.jpg" alt="">
                    </div>
                    <div class="slide-img">
                        <img src="image/kemeja-maroon.jpg" alt="">
                    </div>
                    <div class="slide-img">
                        <img src="image/hoodie-cream.jpg" alt="">
                    </div>
                    <div class="slide-img">
                        <img src="image/kemeja-hitam.jpg" alt="">
                    </div>
                    <a href="#" class="slider-btn" id="nextBtn"><i data-feather="chevron-right"></i></a>
                </div>
                <div class="konten-produk">
                    <h3 class="produk-tittle">Hoodie Hijau</h3>
                    <p class="deskripsi-produk">deskripsi produk bla bla bla Lorem ipsum dolor sit amet consectetur adipisicing elit. Fugiat omnis nisi alias temporibus, quos eos.</p>
                    <p class="produk-price">Rp 70.000</p>
                </div>
            </div>
        </div> 
    </div>
    <div class="detail-box" id="modal-sweater-pink">
        <div class="detail-box-container">
            <a href="#" class="close-icon"><i data-feather="x"></i></a>
            <div class="detail-content">
                <div class="slider-container" >
                    <a href="#" class="slider-btn" id="prevBtn"><i data-feather="chevron-left"></i></a>
                    <div class="slide-img">
                        <img src="image/sweater-pink.jpg" alt="">
                    </div>
                    <div class="slide-img">
                        <img src="image/kemeja-maroon.jpg" alt="">
                    </div>
                    <div class="slide-img">
                        <img src="image/hoodie-cream.jpg" alt="">
                    </div>
                    <div class="slide-img">
                        <img src="image/kemeja-hitam.jpg" alt="">
                    </div>
                    <a href="#" class="slider-btn" id="nextBtn"><i data-feather="chevron-right"></i></a>
                </div>
                <div class="konten-produk">
                    <h3 class="produk-tittle">Sweater Pink</h3>
                    <p class="deskripsi-produk">deskripsi produk bla bla bla Lorem ipsum dolor sit amet consectetur adipisicing elit. Fugiat omnis nisi alias temporibus, quos eos.</p>
                    <p class="produk-price">Rp 60.000</p>
                </div>
            </div>
        </div> 
    </div>
    <div class="detail-box" id="modal-hoodie-cream">
        <div class="detail-box-container">
            <a href="#" class="close-icon"><i data-feather="x"></i></a>
            <div class="detail-content">
                <div class="slider-container" >
                    <a href="#" class="slider-btn" id="prevBtn"><i data-feather="chevron-left"></i></a>
                    <div class="slide-img">
                        <img src="image/hoodie-cream.jpg" alt="">
                    </div>
                    <div class="slide-img">
                        <img src="image/kemeja-maroon.jpg" alt="">
                    </div>
                    <div class="slide-img">
                        <img src="image/hoodie-cream.jpg" alt="">
                    </div>
                    <div class="slide-img">
                        <img src="image/kemeja-hitam.jpg" alt="">
                    </div>
                    <a href="#" class="slider-btn" id="nextBtn"><i data-feather="chevron-right"></i></a>
                </div>
                <div class="konten-produk">
                    <h3 class="produk-tittle">Hoodie Cream</h3>
                    <p class="deskripsi-produk">deskripsi produk bla bla bla Lorem ipsum dolor sit amet consectetur adipisicing elit. Fugiat omnis nisi alias temporibus, quos eos.</p>
                    <p class="produk-price">Rp 70.000</p>
                </div>
            </div>
        </div> 
    </div>
    <div class="detail-box" id="modal-kemeja-flanel-biru">
        <div class="detail-box-container">
            <a href="#" class="close-icon"><i data-feather="x"></i></a>
            <div class="detail-content">
                <div class="slider-container" >
                    <a href="#" class="slider-btn" id="prevBtn"><i data-feather="chevron-left"></i></a>
                    <div class="slide-img">
                        <img src="image/kemeja-flanel-biru.jpg" alt="">
                    </div>
                    <div class="slide-img">
                        <img src="image/kemeja-maroon.jpg" alt="">
                    </div>
                    <div class="slide-img">
                        <img src="image/hoodie-cream.jpg" alt="">
                    </div>
                    <div class="slide-img">
                        <img src="image/kemeja-hitam.jpg" alt="">
                    </div>
                    <a href="#" class="slider-btn" id="nextBtn"><i data-feather="chevron-right"></i></a>
                </div>
                <div class="konten-produk">
                    <h3 class="produk-tittle">Kemeja Flanel Biru</h3>
                    <p class="deskripsi-produk">deskripsi produk bla bla bla Lorem ipsum dolor sit amet consectetur adipisicing elit. Fugiat omnis nisi alias temporibus, quos eos.</p>
                    <p class="produk-price">Rp 50.000</p>
                </div>
            </div>
        </div> 
    </div>
    <div class="detail-box" id="modal-kemeja-hitam">
        <div class="detail-box-container">
            <a href="#" class="close-icon"><i data-feather="x"></i></a>
            <div class="detail-content">
                <div class="slider-container" >
                    <a href="#" class="slider-btn" id="prevBtn"><i data-feather="chevron-left"></i></a>
                    <div class="slide-img">
                        <img src="image/kemeja-hitam.jpg" alt="">
                    </div>
                    <div class="slide-img">
                        <img src="image/kemeja-maroon.jpg" alt="">
                    </div>
                    <div class="slide-img">
                        <img src="image/hoodie-cream.jpg" alt="">
                    </div>
                    <div class="slide-img">
                        <img src="image/kemeja-hitam.jpg" alt="">
                    </div>
                    <a href="#" class="slider-btn" id="nextBtn"><i data-feather="chevron-right"></i></a>
                </div>
                <div class="konten-produk">
                    <h3 class="produk-tittle">Kemeja Hitam</h3>
                    <p class="deskripsi-produk">deskripsi produk bla bla bla Lorem ipsum dolor sit amet consectetur adipisicing elit. Fugiat omnis nisi alias temporibus, quos eos.</p>
                    <p class="produk-price">Rp 50.000</p>
                </div>
            </div>
        </div> 
    </div>
    <div class="detail-box" id="modal-kemeja-biru">
        <div class="detail-box-container">
            <a href="#" class="close-icon"><i data-feather="x"></i></a>
            <div class="detail-content">
                <div class="slider-container" >
                    <a href="#" class="slider-btn" id="prevBtn"><i data-feather="chevron-left"></i></a>
                    <div class="slide-img">
                        <img src="image/kemeja-biru.jpg" alt="">
                    </div>
                    <div class="slide-img">
                        <img src="image/kemeja-maroon.jpg" alt="">
                    </div>
                    <div class="slide-img">
                        <img src="image/hoodie-cream.jpg" alt="">
                    </div>
                    <div class="slide-img">
                        <img src="image/kemeja-hitam.jpg" alt="">
                    </div>
                    <a href="#" class="slider-btn" id="nextBtn"><i data-feather="chevron-right"></i></a>
                </div>
                <div class="konten-produk">
                    <h3 class="produk-tittle">Kemeja Biru</h3>
                    <p class="deskripsi-produk">deskripsi produk bla bla bla Lorem ipsum dolor sit amet consectetur adipisicing elit. Fugiat omnis nisi alias temporibus, quos eos.</p>
                    <p class="produk-price">Rp 50.000</p>
                </div>
            </div>
        </div> 
    </div>
    <div class="detail-box" id="modal-vest-coklat">
        <div class="detail-box-container">
            <a href="#" class="close-icon"><i data-feather="x"></i></a>
            <div class="detail-content">
                <div class="slider-container" >
                    <a href="#" class="slider-btn" id="prevBtn"><i data-feather="chevron-left"></i></a>
                    <div class="slide-img">
                        <img src="image/vest-coklat.jpg" alt="">
                    </div>
                    <div class="slide-img">
                        <img src="image/kemeja-maroon.jpg" alt="">
                    </div>
                    <div class="slide-img">
                        <img src="image/hoodie-cream.jpg" alt="">
                    </div>
                    <div class="slide-img">
                        <img src="image/kemeja-hitam.jpg" alt="">
                    </div>
                    <a href="#" class="slider-btn" id="nextBtn"><i data-feather="chevron-right"></i></a>
                </div>
                <div class="konten-produk">
                    <h3 class="produk-tittle">Vest Coklat</h3>
                    <p class="deskripsi-produk">deskripsi produk bla bla bla Lorem ipsum dolor sit amet consectetur adipisicing elit. Fugiat omnis nisi alias temporibus, quos eos.</p>
                    <p class="produk-price">Rp 50.000</p>
                </div>
            </div>
        </div> 
    </div>
    <!-- Modal Box Item Detail end -->

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

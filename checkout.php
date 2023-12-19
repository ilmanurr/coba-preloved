<?php
// Start the session
session_start();

// Check if the user is logged in
if (isset($_SESSION['username'])) {
    $loggedInUsername = $_SESSION['username'];
}

// Ambil data produk dari session
$checkoutProducts = isset($_SESSION['checkout_products']) ? $_SESSION['checkout_products'] : array();

// Hitung total harga dan jumlah produk
$totalQuantity = 0;
$totalHarga = 0;

foreach ($checkoutProducts as $item) {
    $totalQuantity += $item['quantity'];
    $totalHarga += $item['quantity'] * $item['price'];
}

$hargaOngkir = 15000;

// Ambil pemesanan sebelumnya dari session
$previousOrders = isset($_SESSION['previous_orders']) ? $_SESSION['previous_orders'] : array();

// Simpan pemesanan saat ini
$currentOrder = array(
    'products' => $checkoutProducts,
    'totalQuantity' => $totalQuantity,
    'totalHarga' => $totalHarga,
    'hargaOngkir' => $hargaOngkir
);

// Tambahkan pemesanan saat ini ke pemesanan sebelumnya
$previousOrders[] = $currentOrder;

// Simpan semua pemesanan dalam sesi
$_SESSION['previous_orders'] = $previousOrders;
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
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
    <link rel="stylesheet" href="css/style_checkout.css">
</head>

<body>
    <div class="checkout">
        <h2>CheckOut</h2>
            <div class="row">
                <div class="row-alamat-produk">
                <form action="proses_pembayaran.php" method="POST">
                    <div class="alamat">
                        <p>Nama Penerima</p>
                        <input type="text" placeholder="Nama Penerima" name="nama">
                        <p>Alamat Pengiriman</p>
                        <textarea name="alamat_penerima" id="alamat" cols="30" rows="10" placeholder="Masukkan Alamat Lengkap"></textarea>
                    </div>
                    <hr>
                    <div class="produk-dipilih">
                        <div class="row-produk-dipilih">
                            <?php
                            // Loop untuk menampilkan produk yang dipilih
                            foreach ($checkoutProducts as $item) {
                                echo '<div class="produk-checkout">';
                                echo '<div class="gambar-produk">';
                                echo '<img src="images/' . $item['image'] . '" alt="' . $item['name'] . '">';
                                echo '</div>';
                                echo '<div class="nama-produk">';
                                echo '<p class="nama-produk">' . $item['name'] . '</p>';
                                echo '</div>';
                                echo '<div class="harga-produk">';
                                echo '<p class="harga-produk">Rp ' . number_format($item['price'], 0, ',', '.') . '</p>';
                                echo '</div>';
                                echo '<div class="jumlah-produk">';
                                echo '<p class="jumlah-produk">x' . $item['quantity'] . '</p>';
                                echo '</div>';
                                echo '</div>';
                            }
                            ?>
                        </div>
                    </div>
                    </div>
                    <div class="row-kurir-pembayaran">
                        <div class="input-nohp">
                            <input type="text" placeholder="Masukkan No. HP yang aktif" name="no_hp">
                        </div>
                        <div class="pilih-pembayaran">
                            <p>Pilih Pembayaran</p>
                            <select name="pembayaran" id="pembayaran">
                                <?php
                                // Loop untuk menampilkan pilihan jenis pembayaran
                                $pembayaranOptions = array('COD', 'BNI', 'Mandiri', 'BCA', 'BRI');

                                foreach ($pembayaranOptions as $pembayaran) {
                                    $selected = ($pembayaran == $jenisPembayaran) ? 'selected' : '';
                                    echo "<option value=\"$pembayaran\" $selected>$pembayaran</option>";
                                }
                                ?>
                            </select>
                            <input type="text" placeholder="Jenis Pembayaran" name="jenis_pembayaran">
                        </div>
                        <div class="ringkasan-belanja">
                        <div class="row-belanja">
                            <p>Total Harga (<span id="totalQuantity"><?= $totalQuantity ?></span> Produk)</p>
                            <p class="harga">Rp <?= number_format($totalHarga, 0, ',', '.') ?></p>
                        </div>
                        <div class="row-belanja">
                            <p>Total Ongkos Kirim</p>
                            <p class="harga">Rp <?= number_format($hargaOngkir, 0, ',', '.') ?></p>
                        </div>
                    </div>
                        <hr>
                        <div class="total-belanja">
                            <p>Total Belanja</p>
                            <p class="harga">Rp <?= number_format($totalHarga + $hargaOngkir, 0, ',', '.')?></p>
                        </div>
                        <div>
                        <button type="submit">Bayar</button>
                        </div> 
                </form>
                </div>
            </div>
    </div>

    <!-- Footer start -->
    <footer>
        <div class="isi-footer">
            <a href="index.php">Beranda</a>
            <a href="produk-kami.php">Produk Kami</a>
            <a href="keranjang.php">Pesananmu</a>
            <a href="kontak-kami.php">Kontak Kami</a>
            <p>Created by Preloved.you's team | &copy 2023</p>
        </div>
    </footer>
    <!-- Footer end -->

    <!-- my script -->
    <script src="js/script_checkout.js"></script>
</body>

</html>

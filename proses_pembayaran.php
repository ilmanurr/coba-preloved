<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_SESSION['username'])) {
    // Ambil data dari formulir
    $namaPenerima = $_POST['nama'];
    $alamatPenerima = $_POST['alamat_penerima'];
    $jenisPembayaran = $_POST['jenis_pembayaran'];
    $noHp = $_POST['no_hp'];

    $loggedInUsername = $_SESSION['username'];

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

    // Calculate the total harga including ongkir
    $totalBelanja = $totalHarga + $hargaOngkir;

    // Simpan data ke database
    $servername = "localhost";
    $username_db = "root";
    $password_db = "";
    $dbname = "coba_preloved";

    $conn = new mysqli($servername, $username_db, $password_db, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Escaping input to prevent SQL injection
    $namaPenerima = $conn->real_escape_string($namaPenerima);
    $alamatPenerima = $conn->real_escape_string($alamatPenerima);
    $jenisPembayaran = $conn->real_escape_string($jenisPembayaran);
    $noHp = $conn->real_escape_string($noHp);
    $username = $conn->real_escape_string($loggedInUsername);
    
    // Get the generated order ID
    $orderID = $conn->insert_id;
    
    $statusPemesanan = "Menunggu Konfirmasi";
    // Query untuk menyimpan data ke tabel pemesanan
    $sqlInsertPemesanan = "INSERT INTO pemesanan (username, nama, alamat, no_hp, jenis_pembayaran, 
                        total_harga, harga_ongkir, total_belanja, status_pemesanan) VALUES ('$username', '$namaPenerima', 
                        '$alamatPenerima', '$noHp', '$jenisPembayaran', $totalHarga, $hargaOngkir, $totalBelanja, '$statusPemesanan')";

    if ($conn->query($sqlInsertPemesanan) === TRUE) {
        // Get the generated order ID
        $orderID = $conn->insert_id;

        // Insert details of each product into detail_pemesanan
        foreach ($checkoutProducts as $item) {
            $productName = $conn->real_escape_string($item['name']);
            $productPrice = $item['price'];
            $productQuantity = $item['quantity'];

            $sqlInsertDetail = "INSERT INTO detail_pemesanan (id_pemesanan, username, nama, nama_produk, harga_produk, jumlah_produk)
                VALUES ($orderID, '$username', '$namaPenerima', '$productName', $productPrice, $productQuantity)";

            $conn->query($sqlInsertDetail);
        }

        header('Location: keranjang.php');
        exit();
    } else {
        echo "Error: " . $sqlInsertPemesanan . "<br>" . $conn->error;
    }

    // Fetch status information from the database
    $sqlFetchStatus = "SELECT status_pemesanan FROM pemesanan WHERE id_pemesanan = $orderID";
    $result = $conn->query($sqlFetchStatus);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $statusPemesanan = $row['status_pemesanan'];

        // Store status information in the session
        $_SESSION['status_pemesanan'] = $statusPemesanan;
    } else {
        echo "Error fetching status information.";
    }

}
?>

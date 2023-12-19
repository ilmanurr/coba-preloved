<?php
// Ambil data keranjang dari session
$storedCheckoutCart = $_SESSION['checkout_products'];
//$checkoutCartData = json_decode($storedCheckoutCart, true);

// Ambil data alamat pengiriman dari form
$namaPenerima = $_POST['namaPenerima'];
$alamatPengiriman = $_POST['alamatPengiriman'];

// Hitung total harga produk
$totalHarga = 0;
foreach ($checkoutCartData as $produk) {
    $totalHarga += $produk['harga'] * $produk['jumlah'];
}

// Ambil nilai terpilih dari dropdown kurir dan kota
$jenisKurir = $_POST['kurir'];
$kotaTujuan = $_POST['id'];

// Tentukan harga ongkir berdasarkan jenis kurir dan kota tujuan
$hargaOngkir = 0;
switch ($jenisKurir) {
    case 'Reguler':
        $hargaOngkir = getHargaOngkirReguler($kotaTujuan);
        break;
    case 'Ekonomi':
        $hargaOngkir = getHargaOngkirEkonomi($kotaTujuan);
        break;
    case 'Kargo':
        $hargaOngkir = getHargaOngkirKargo($kotaTujuan);
        break;
    // Tambahkan case untuk jenis kurir lainnya sesuai kebutuhan
    default:
        $hargaOngkir = 0;
        break;
}

// Hitung total belanja
$totalBelanja = $totalHarga + $hargaOngkir;

// Tampilkan hasil atau lakukan sesuatu sesuai kebutuhan
echo "Nama Penerima: $namaPenerima<br>";
echo "Alamat Pengiriman: $alamatPengiriman<br>";
echo "Total Harga Produk: Rp " . number_format($totalHarga, 0, ',', '.') . "<br>";
echo "Ongkos Kirim: Rp " . number_format($hargaOngkir, 0, ',', '.') . "<br>";
echo "Total Belanja: Rp " . number_format($totalBelanja, 0, ',', '.');

// Fungsi untuk mengonversi harga ke dalam format Rupiah
function formatRupiah($angka)
{
    $reverse = strrev($angka);
    $ribuan = preg_replace("/\d{3}(?=\d)/", "$0.", $reverse);
    return 'Rp ' . strrev($ribuan);
}

// Logika penentuan harga ongkir untuk kurir Reguler berdasarkan kota
function getHargaOngkirReguler($kota)
{
    switch ($kota) {
        case 'Surabaya':
            return 5000;
        case 'Sidoarjo':
            return 6000;
        case 'Gresik':
            return 7000;
        // Tambahkan case untuk kota lain sesuai kebutuhan
        default:
            return 0;
    }
}

// Logika penentuan harga ongkir untuk kurir Ekonomi berdasarkan kota
function getHargaOngkirEkonomi($kota)
{
    switch ($kota) {
        case 'Surabaya':
            return 4000;
        case 'Sidoarjo':
            return 5000;
        case 'Gresik':
            return 6000;
        // Tambahkan case untuk kota lain sesuai kebutuhan
        default:
            return 0;
    }
}

// Logika penentuan harga ongkir untuk kurir Kargo berdasarkan kota
function getHargaOngkirKargo($kota)
{
    switch ($kota) {
        case 'Surabaya':
            return 10000;
        case 'Sidoarjo':
            return 12000;
        case 'Gresik':
            return 15000;
        // Tambahkan case untuk kota lain sesuai kebutuhan
        default:
            return 0;
    }
}
?>

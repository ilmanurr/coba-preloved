<?php
    include_once 'register.php';
    $re = new Register();

    if (isset($_GET ['delProduk'])) {
        $id = base64_decode($_GET['delProduk']);
        $deleteProduk = $re->delProduk($id);
    }   
?>

<!DOCTYPE html>
<html>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css" integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l" crossorigin="anonymous">

    <title>Form Produk</title>
  </head>

  <body>
    <br>
    <div class="container">
        <div class="row d-flex justify-content-center">
            <div class="col-md-12">
                <div class="card shadow">

                <?php 
                    if (isset($deleteProduk)) {
                        ?>
                            <div class="alert alert-warning alert-dismissible fade show" role="alert">
                            <strong><?=$deleteProduk?></strong>
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                            </div>
                        <?php 
                    }
                ?>

                    <div class="card-header">
                        <div class="row">
                            <div class="col-md-6">
                                <h3>List Produk</h3>
                            </div>
                            <div class="col-md-6">
                                <a href="tambah.php" class="btn btn-info float-right">Tambah Data Baru</a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <table class="table table-bordered">
                            <tr>
                                <th>Nama Produk</th>
                                <th>Harga Satuan</th>
                                <th>Foto/file</th>
                                <th>Aksi</th>
                            </tr>
                            <?php
                                $allStd = $re->allProduk();
                                if ($allStd) {
                                    while ($row = mysqli_fetch_assoc($allStd)) {
                                        ?>
                                    <tr>
                                        <td><?=$row['nama_produk']?></td>
                                        <td><?=$row['harga_satuan']?></td>
                                        <td><img style="width: 100px;" src="<?=$row['foto']?>" class="img-fluid " alt=""></td>
                                        <td>
                                            <a href="edit.php?id=<?=base64_encode($row['id'])?>" class="btn btn-sm btn-warning">Edit</a>
                                            <a href="?delStd=<?=base64_encode($row['id'])?>" onclick="return confirm('Apakah anda yakin ingin menghapus data ini?')" class="btn btn-sm btn-danger">Hapus</a>
                                        </td>
                                    </tr>
                                        <?php
                                    }
                                }
                            ?>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-Piv4xVNRyMGpqkS2by6br4gNJ7DXjqk09RmUpJ8jgGtD7zP9yug3goQfGII0yAns" crossorigin="anonymous"></script>
  </body>
</html>
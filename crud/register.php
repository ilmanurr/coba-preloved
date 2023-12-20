<?php

    include_once 'database.php';

    class Register{
        
        public $db;
        public function __construct()
        {
            $this->db = new Database();
        }

        public function addProduk($data, $file){
            $name = $data['nama_produk'];
            $harga_satuan = $data['harga_satuan'];

            $permited = array('jpg', 'jpeg', 'img', 'png');
            $file_name = $file['foto']['name'];
            $file_size = $file['foto']['size'];
            $file_temp = $file['foto']['tmp_name'];

            $div = explode('.', $file_name);
            $file_ext = strtolower(end($div));
            $unique_image = substr(md5(time()),0,10).'.'.$file_ext;
            $upload_image = "../images/".$unique_image;

            if (empty($name) || empty($harga_satuan) || empty($file_name)){
                $msg = "Form Tidak Boleh Kosong!";
                return $msg;
            }elseif($file_size > 1048567){
                $msg = "Ukuran file tidak boleh lebih dari 1 mb!";
                return $msg;
            }elseif(in_array($file_ext, $permited) == false){
                $msg = "Anda hanya bisa mengupload file berjenis".implode(', ', $permited);
                return $msg;
            }else{
                move_uploaded_file($file_temp, $upload_image);

                $query = "INSERT INTO `produk`(`nama_produk`, `harga_satuan`, `foto`) VALUES ('$name', '$harga_satuan', '$upload_image')";
            
                $result = $this->db->tambah_data($query);

                if ($result) {
                    $msg = "Data Produk Berhasil Ditambahkan!";
                    return $msg;
                }else {
                    $msg = "Maaf, Gagal Menambahkan Data Produk!";
                    return $msg;
                }
            }
        }

        public function allProduk(){
            $query = "SELECT * FROM produk ORDER BY id DESC";
            $result = $this->db->pilih_data($query);
            return $result;
        }

        public function getProdukById($id){
            $query = "SELECT * FROM produk WHERE id = '$id'";
            $result = $this->db->pilih_data($query);
            return $result;
        }

        // update
        public function updateProduk($data, $file, $id) {
            $name = $data['nama_produk'];
            $harga_satuan = $data['harga_satuan'];

            $permited = array('jpg', 'jpeg', 'img', 'png');
            $file_name = $file['foto']['name'];
            $file_size = $file['foto']['size'];
            $file_temp = $file['foto']['tmp_name'];

            $div = explode('.', $file_name);
            $file_ext = strtolower(end($div));
            $unique_image = substr(md5(time()),0,10).'.'.$file_ext;
            $upload_image = "../images/".$unique_image;

            if (empty($name) || empty($harga_satuan)) {
                $msg = "Form Tidak Boleh Kosong!";
                return $msg;
            }if (!empty($file_name)) {
                if($file_size > 1048567) {
                    $msg = "Ukuran file tidak boleh lebih dari 1 mb!";
                    return $msg;
                } elseif (in_array($file_ext, $permited) == false) {
                    $msg = "Anda hanya bisa mengupload file berjenis ".implode(', ', $permited);
                    return $msg;    
                } else {
                    $img_query = "SELECT * FROM produk WHERE id = '$id'";
                    $img_res = $this->db->pilih_data($img_query);
                    if ($img_res) {
                        while ($row = mysqli_fetch_assoc($img_res)) {
                            $photo = $row['foto'];
                            unlink($photo);
                        }
                    }

                    move_uploaded_file($file_temp, $upload_image);

                    $query = "UPDATE produk SET nama_produk='$name', harga_satuan='$harga_satuan', foto='$upload_image' WHERE id = '$id'";

                    $result = $this->db->tambah_data($query);

                    if ($result) {
                        $msg = "Update Data Produk Berhasil!";
                        return $msg;
                    } else {
                        $msg = "Maaf, Update Data Produk Gagal!";
                        return $msg;
                    }
                }
            } else {
                $query = "UPDATE produk SET nama_produk='$name', harga_satuan='$harga_satuan' WHERE id = '$id'";

                $result = $this->db->tambah_data($query);

                if ($result) {
                    $msg = "Update Data Produk Berhasil!";
                    return $msg;
                } else {
                    $msg = "Maaf, Update Data Produk Gagal!";
                    return $msg;
                }
            }
        }

        // delete
        public function delProduk($id){
            $img_query = "SELECT * FROM produk WHERE id = '$id'";
            $img_res = $this->db->pilih_data($img_query);
            if ($img_res) {
                while ($row = mysqli_fetch_assoc($img_res)) {
                    $photo = $row['foto'];
                    unlink($photo);
                }
            }

            $delete_query = "DELETE FROM produk WHERE id = '$id'";
            $delete = $this->db->hapus_data($delete_query);
            if ($delete) {
                $msg = "Berhasil Menghapus Data Produk!";
                return $msg;
            } else {
                $msg = "Gagal Menghapus Data Produk!";
                return $msg;
            }
        }
    }
?>
<?php
session_start();      // mengaktifkan session

// pengecekan session login user 
// jika user belum login
if (empty($_SESSION['username']) && empty($_SESSION['password'])) {
  // alihkan ke halaman login dan tampilkan pesan peringatan login
  header('location: ../../login.php?pesan=2');
}
// jika user sudah login, maka jalankan perintah untuk insert
else {
  // panggil file "database.php" untuk koneksi ke database
  require_once "../../config/database.php";

  $id_masuk = $_GET['id'];
  $id_barang = $_GET['id_barang'];

    // sql statement untuk insert data ke tabel "tbl_barang_masuk"
    $hapus = mysqli_query($mysqli, "DELETE FROM tbl_detail_barang_masuk WHERE id_masuk='$id_masuk' AND id_barang='$id_barang'")
                                     or die('Ada kesalahan pada query insert : ' . mysqli_error($mysqli));
    // cek query
    // jika proses insert berhasil
    if ($hapus) {
      // alihkan ke halaman barang masuk dan tampilkan pesan berhasil simpan data
      header('location: ../../main.php?module=detail_barang_masuk&id='.$id_masuk.'&pesan=3');
    }
  
}

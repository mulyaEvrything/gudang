<?php
session_start();      // mengaktifkan session

// pengecekan session login user 
// jika user belum login
if (empty($_SESSION['username']) && empty($_SESSION['password'])) {
  // alihkan ke halaman login dan tampilkan pesan peringatan login
  header('location: ../../login.php?pesan=2');
}
// jika user sudah login, maka jalankan perintah untuk delete
else {
  // panggil file "database.php" untuk koneksi ke database
  require_once "../../config/database.php";

  // mengecek data GET "id_barang"
  if (isset($_GET['id'])) {
    // ambil data GET dari tombol hapus
    $id_customer = mysqli_real_escape_string($mysqli, $_GET['id']);

    // sql statement untuk menampilkan data "barang" dari tabel "tbl_barang_masuk" berdasarkan input "id_barang"
    $query = mysqli_query($mysqli, "SELECT nama_perusahaan FROM tbl_customer WHERE nama_perusahaan='$id_customer'")
                                    or die('Ada kesalahan pada query tampil data : ' . mysqli_error($mysqli));
    

      // sql statement untuk delete data dari tabel "tbl_barang" berdasarkan "id_barang"
      $delete = mysqli_query($mysqli, "DELETE FROM tbl_customer WHERE id_customer='$id_customer'")
                                       or die('Ada kesalahan pada query delete : ' . mysqli_error($mysqli));
      // cek query
      // jika proses delete berhasil
      if ($delete) {
        // alihkan ke halaman barang dan tampilkan pesan berhasil hapus data
        header('location: ../../main.php?module=data_customer&pesan=3');
      }
    }
  }


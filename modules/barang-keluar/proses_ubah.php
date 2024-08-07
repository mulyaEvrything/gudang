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

  // mengecek data hasil submit dari form
  if (isset($_POST['simpan'])) {
    
    // ambil data hasil submit dari form
    $id_transaksi  = mysqli_real_escape_string($mysqli, $_POST['id_transaksi']);
    $tanggal       = mysqli_real_escape_string($mysqli, trim($_POST['tanggal']));
    $tanggal_t       = mysqli_real_escape_string($mysqli, trim($_POST['tanggal_tempo']));
    $no_po        = mysqli_real_escape_string($mysqli, $_POST['no_po']);
    $customer        = mysqli_real_escape_string($mysqli, $_POST['id_customer']);

    // ubah format tanggal menjadi Tahun-Bulan-Hari (Y-m-d) sebelum disimpan ke database
    $tanggal_keluar = date('Y-m-d', strtotime($tanggal));
    $tanggal_tempo = date('Y-m-d', strtotime($tanggal_t));

    // sql statement untuk insert data ke tabel "tbl_barang_masuk"
    $insert = mysqli_query($mysqli, "UPDATE tbl_barang_keluar SET tanggal='$tanggal_keluar', tgl_jatuh_tempo='$tanggal_tempo', no_po='$no_po', id_customer=$customer 
                                    WHERE id_transaksi='$id_transaksi'")
                                     or die('Ada kesalahan pada query insert : ' . mysqli_error($mysqli));
    // cek query
    // jika proses insert berhasil
    if ($insert) {
      // alihkan ke halaman barang masuk dan tampilkan pesan berhasil simpan data
      header('location: ../../main.php?module=barang_keluar&pesan=2');
    }
  }
}

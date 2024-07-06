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
    $nama_perusahaan        = mysqli_real_escape_string($mysqli, trim($_POST['nama_perusahaan']));
    $singkatan              = mysqli_real_escape_string($mysqli, trim($_POST['singkatan']));
    $alamat                 = mysqli_real_escape_string($mysqli, trim($_POST['alamat']));
    $kontak                 = mysqli_real_escape_string($mysqli, trim($_POST['kontak']));
    $no_tlp                 = mysqli_real_escape_string($mysqli, $_POST['no_tlp']);
    $site                   = mysqli_real_escape_string($mysqli, $_POST['site']);

    
      // sql statement untuk insert data ke tabel "tbl_customer"
      $insert = mysqli_query($mysqli, "INSERT INTO tbl_customer(nama_perusahaan, alamat, kontak, no_tlp, sites, singkatan) 
                                       VALUES('$nama_perusahaan', '$alamat', '$kontak', '$no_tlp', '$site', '$singkatan')")
                                       or die('Ada kesalahan pada query insert : ' . mysqli_error($mysqli));
      // cek query
      // jika proses insert berhasil
      if ($insert) {
        // alihkan ke halaman barang dan tampilkan pesan berhasil simpan data
        header('location: ../../main.php?module=data_customer&pesan=1');
      }
        
      }
}


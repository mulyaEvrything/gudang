<?php
// pengecekan ajax request untuk mencegah direct access file, agar file tidak bisa diakses secara langsung dari browser
// jika ada ajax request
if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && ($_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest')) {
  // panggil file "database.php" untuk koneksi ke database
  require_once "../../config/database.php";

  // mengecek data GET dari ajax
  if (isset($_GET['id_barang'])) {
    // ambil data GET dari ajax
    $id_barang = $_GET['id_barang'];

    // sql statement untuk menampilkan data dari tabel "tbl_barang" dan tabel "tbl_satuan" dan "tbl_detail_barang_masuk" berdasarkan "id_barang"
    $query = mysqli_query($mysqli, "SELECT a.stok, b.nama_satuan, c.harga FROM tbl_barang as a INNER JOIN tbl_satuan as b INNER JOIN
                                    tbl_detail_barang_masuk as c 
                                    ON a.satuan=b.id_satuan AND c.harga=a.harga
                                    WHERE id_barang='$id_barang'")
                                    or die('Ada kesalahan pada query tampil data : ' . mysqli_error($mysqli));
    // ambil data hasil query
    $data  = mysqli_fetch_assoc($query);

    // kirimkan data
    echo json_encode($data);
  }
}
// jika tidak ada ajax request
else {
  // alihkan ke halaman error 404
  header('location: ../../404.html');
}

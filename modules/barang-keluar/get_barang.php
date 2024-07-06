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
    $tanggal = date('Y-m-d');

    // sql statement untuk menampilkan data dari tabel "tbl_barang" dan tabel "tbl_satuan" berdasarkan "id_barang"
    $query = mysqli_query($mysqli, "SELECT *,
                                      IFNULL((SELECT SUM(jumlah) FROM tbl_detail_barang_masuk dbm, tbl_barang_masuk bm WHERE dbm.id_barang = b.id_barang
                                            AND dbm.id_masuk = bm.id_transaksi AND bm.tanggal <= '$tanggal'),0) as jlh_masuk,
                                      IFNULL((SELECT SUM(jumlah) FROM tbl_detail_barang_keluar dbk, tbl_barang_keluar bk WHERE dbk.id_barang = b.id_barang
                                            AND dbk.id_keluar = bk.id_transaksi AND bk.tanggal <= '$tanggal'),0) as jlh_keluar,
                                      (SELECT jlh_masuk - jlh_keluar) as stoknow
                                      FROM tbl_barang b
                                      LEFT JOIN tbl_satuan s ON s.id_satuan = b.satuan 
                                    WHERE b.id_barang='$id_barang'")
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

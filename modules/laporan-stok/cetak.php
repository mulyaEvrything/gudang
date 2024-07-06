<?php
session_start();      // mengaktifkan session

// panggil file "autoload.inc.php" untuk load dompdf, libraries, dan helper functions
require_once("../../assets/js/plugin/dompdf/autoload.inc.php");
// mereferensikan Dompdf namespace
use Dompdf\Dompdf;

// pengecekan session login user 
// jika user belum login
if (empty($_SESSION['username']) && empty($_SESSION['password'])) {
  // alihkan ke halaman login dan tampilkan pesan peringatan login
  header('location: ../../login.php?pesan=2');
}
// jika user sudah login, maka jalankan perintah untuk cetak
else {
  // panggil file "database.php" untuk koneksi ke database
  require_once "../../config/database.php";
  // panggil file "fungsi_tanggal_indo.php" untuk membuat format tanggal indonesia
  require_once "../../helper/fungsi_tanggal_indo.php";

  // ambil data GET dari tombol cetak
  $tanggal = $_GET['tanggal'];
  $tanggal_keluar = date('Y-m-d', strtotime($tanggal));

  // variabel untuk nomor urut tabel 
  $no = 1;

  // gunakan dompdf class
  $dompdf = new Dompdf();
  // setting options
  $options = $dompdf->getOptions();
  $options->setIsRemoteEnabled(true); // aktifkan akses file untuk bisa mengakses file gambar dan CSS
  $options->setChroot('C:\xampp\htdocs\gudang'); // tentukan path direktori aplikasi
  $dompdf->setOptions($options);

  // mengecek filter data stok
  // jika filter data stok "Seluruh" dipilih, tampilkan laporan stok seluruh barang

    // halaman HTML yang akan diubah ke PDF
    $html = '<!DOCTYPE html>
            <html>
            <head>
              <title>Laporan Stok Barang '.tanggal_indo(date('Y-m-d',strtotime($tanggal_keluar))).'</title>
              <link rel="stylesheet" href="../../assets/css/laporan.css">
            </head>
            <body class="text-dark">
              <div class="text-center mb-4">
                <h1>LAPORAN STOK BARANG</h1>
                <h2>'.tanggal_indo(date('Y-m-d',strtotime($tanggal_keluar))).'</h2>
              </div>
              <hr>
              <div class="mt-4">
                <table class="table table-bordered" width="100%" cellspacing="0">
                  <thead class="bg-secondary text-white text-center">
                    <tr>
                      <th>No.</th>
                      <th>ID Barang</th>
                      <th>Nama Barang</th>
                      <th>Stok</th>
                      <th>Satuan</th>
                    </tr>
                  </thead>
                  <tbody class="text-dark">';
    // sql statement untuk menampilkan data dari tabel "tbl_barang", tabel "tbl_jenis", dan tabel "tbl_satuan"
    $query = mysqli_query($mysqli, "SELECT *,
                                      IFNULL((SELECT SUM(jumlah) FROM tbl_detail_barang_masuk dbm, tbl_barang_masuk bm WHERE dbm.id_barang = b.id_barang
                                            AND dbm.id_masuk = bm.id_transaksi AND bm.tanggal <= '$tanggal_keluar'),0) as jlh_masuk,
                                      IFNULL((SELECT SUM(jumlah) FROM tbl_detail_barang_keluar dbk, tbl_barang_keluar bk WHERE dbk.id_barang = b.id_barang
                                            AND dbk.id_keluar = bk.id_transaksi AND bk.tanggal <= '$tanggal_keluar'),0) as jlh_keluar,
                                      (SELECT jlh_masuk - jlh_keluar) as stoknow
                                      FROM tbl_barang b
                                      LEFT JOIN tbl_satuan s ON s.id_satuan = b.satuan 
                                    ORDER BY b.id_barang ASC")
                                    or die('Ada kesalahan pada query tampil data : ' . mysqli_error($mysqli));
    // ambil data hasil query
    while ($data = mysqli_fetch_assoc($query)) {
      // tampilkan data
      $html .= '		<tr>
                      <td width="50" class="text-center">' . $no++ . '</td>
                      <td class="text-center">' . $data['id_barang'] . '</td>
                      <td>' . $data['nama_barang'] . '</td>
                      <td class="text-center">' . $data['stoknow'] . '</td>
                      <td class="text-center">' . $data['nama_satuan'] . '</td>
								    </tr>';
    }
    $html .= '		</tbody>
                </table>
              </div>
              <div class="text-right mt-5">............, ' . tanggal_indo(date('Y-m-d')) . '</div>
            </body>
            </html>';

    // load html
    $dompdf->loadHtml($html);
    // mengatur ukuran dan orientasi kertas
    $dompdf->setPaper('A4', 'landscape');
    // mengubah dari HTML menjadi PDF
    $dompdf->render();
    // menampilkan file PDF yang dihasilkan ke browser dan berikan nama file "Laporan Stok Seluruh Barang.pdf"
    $dompdf->stream('Laporan Stok Barang '.tanggal_indo(date('Y-m-d')).'.pdf', array('Attachment' => 0));
  
}

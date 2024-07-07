<?php
session_start();      // mengaktifkan session

// include autoloader untuk load dompdf, libraries, dan helper functions
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
  $tanggal_awal  = $_GET['tanggal_awal'];
  $tanggal_akhir = $_GET['tanggal_akhir'];

  // gunakan dompdf class
  $dompdf = new Dompdf();
  // setting options
  $options = $dompdf->getOptions();
  $options->setIsRemoteEnabled(true); // aktifkan akses file untuk bisa mengakses file gambar dan CSS
  $options->setChroot('C:\xampp\htdocs\gudang'); // tentukan path direktori aplikasi
  $dompdf->setOptions($options);

  // halaman HTML yang akan diubah ke PDF
  $html = '<!DOCTYPE html>
          <html>
          <head>
              <title>Laporan Data Barang Keluar</title>
            <link href="../../assets/css/laporan.css" rel="stylesheet">
          </head>
          <body class="text-dark">
            <div class="text-center">
              <h2>LAPORAN DATA BARANG KELUAR</h2>
              <span>Tanggal ' . $tanggal_awal . ' s.d. ' . $tanggal_akhir . '</span>
            </div>
            <hr>
            <div class="mt-4">
              <table class="table table-bordered" width="100%" cellspacing="0">
                <thead class="bg-secondary text-white text-center">
		              <tr>
                    <th>No.</th>
                    <th>No. Faktur</th>
                    <th>Tanggal</th>
                    <th>Nama Barang</th>
                    <th>Jumlah Keluar</th>
                    <th>Satuan</th>
		              </tr>
		            </thead>
						    <tbody class="text-dark">';
  // ubah format tanggal menjadi Tahun-Bulan-Hari (Y-m-d)
  $tanggal_awal  = date('Y-m-d', strtotime($tanggal_awal));
  $tanggal_akhir = date('Y-m-d', strtotime($tanggal_akhir));
  // variabel untuk nomor urut tabel 
  $no = 1;
  // sql statement untuk menampilkan data dari tabel "tbl_barang_keluar", tabel "tbl_barang", dan tabel "tbl_satuan" berdasarkan "tanggal"
  $query = mysqli_query($mysqli, "SELECT * FROM tbl_detail_barang_keluar dbk
                                      INNER JOIN tbl_barang_keluar bk ON bk.id_transaksi = dbk.id_keluar
                                      INNER JOIN tbl_barang b ON b.id_barang = dbk.id_barang
                                      INNER JOIN tbl_satuan s ON s.id_satuan = b.satuan
                                      WHERE bk.tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir'
                                      ORDER BY bk.id_transaksi ASC")
                                  or die('Ada kesalahan pada query tampil data : ' . mysqli_error($mysqli));
  // ambil data hasil query
  while ($data = mysqli_fetch_assoc($query)) {
    // tampilkan data
    $html .= '		<tr>
                    <td width="20" class="text-center">' . $no++ . '</td>
                    <td width="110" class="text-center">' . $data['id_transaksi'] . '</td>
                    <td width="70" class="text-center">' . date('d-m-Y', strtotime($data['tanggal'])) . '</td>
                    <td width="220">' . $data['nama_barang'] . '</td>
                    <td width="70" class="text-right">' . number_format($data['jumlah'], 0, '', '.') . '</td>
                    <td width="70">' . $data['nama_satuan'] . '</td>
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
  // menampilkan file PDF yang dihasilkan ke browser dan berikan nama file "Laporan Data Barang Keluar.pdf"
  $dompdf->stream('Laporan Data Barang Keluar.pdf', array('Attachment' => 0));
}

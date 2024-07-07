<?php
session_start();      // mengaktifkan session

// pengecekan session login user 
// jika user belum login
if (empty($_SESSION['username']) && empty($_SESSION['password'])) {
  // alihkan ke halaman login dan tampilkan pesan peringatan login
  header('location: ../../login.php?pesan=2');
}
// jika user sudah login, maka jalankan perintah untuk export
else {
  // panggil file "database.php" untuk koneksi ke database
  require_once "../../config/database.php";
  // panggil file "fungsi_tanggal_indo.php" untuk membuat format tanggal indonesia
  require_once "../../helper/fungsi_tanggal_indo.php";

  // ambil data GET dari tombol export
  $tanggal = $_GET['tanggal'];
  $tanggal_keluar = date('Y-m-d', strtotime($tanggal));

  // variabel untuk nomor urut tabel 
  $no = 1;

  // mengecek filter data stok
  // jika filter data stok "Seluruh" dipilih, tampilkan laporan stok seluruh barang

    // fungsi header untuk mengirimkan raw data excel
    header("Content-type: application/vnd-ms-excel");
    // mendefinisikan nama file hasil ekspor "Laporan Stok Seluruh Barang.xls"
    header("Content-Disposition: attachment; filename=Laporan Stok Barang ".tanggal_indo(date('Y-m-d',strtotime($tanggal_keluar))).".xls");
?>
    <!-- halaman HTML yang akan diexport ke excel -->
    <!-- judul tabel -->
    <center>
      <h4>LAPORAN STOK BARANG <?= tanggal_indo(date('Y-m-d',strtotime($tanggal_keluar))); ?></h4>
    </center>
    <!-- tabel untuk menampilkan data dari database -->
    <table border="1">
      <thead>
        <tr style="background-color:#6861ce;color:#fff">
          <th height="30" align="center" vertical="center">No.</th>
          <th height="30" align="center" vertical="center">Kode Barang</th>
          <th height="30" align="center" vertical="center">Nama Barang</th>
          <th height="30" align="center" vertical="center">Stok</th>
          <th height="30" align="center" vertical="center">Satuan</th>
        </tr>
      </thead>
      <tbody>
        <?php
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
        while ($data = mysqli_fetch_assoc($query)) { ?>
          <!-- tampilkan data -->
          <tr>
            <td width="70" align="center"><?php echo $no++; ?></td>
            <td width="220" align="center"><?php echo $data['id_barang']; ?></td>
            <td width="400"><?php echo $data['nama_barang']; ?></td>
            <td width="110" align="center"><?php echo $data['stoknow']; ?></td>
            <td width="150"><?php echo $data['nama_satuan']; ?></td>
          </tr>
        <?php } ?>
      </tbody>
    </table>
  <br>
  <div style="text-align:right">............, <?php echo tanggal_indo(date('Y-m-d')); ?></div>
<?php } ?>
<style>
  .kop {
    display: flex;
    justify-content: space-between;
    width: 100%;
  }
</style>
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

  // fungsi header untuk mengirimkan raw data excel
?>
  <!-- halaman HTML yang akan diexport ke excel -->
  <!-- judul tabel -->
  <div class="kop">
    <div class="left">
      <h4>PT. LUMASINDO SUMBER ABADI</h4>
      <h4>AUTHORIZED DISTRIBUTOR REPSOL</h4>
      <p>Jl. Yogyakarta No. 15 RT.001 RW.006, Loktabat Selatan, Banjarbaru Selatan</p>
      <p>Email: lumasindo_sa@yahoo.com</p>
      <p>TGL: <?= date("Y-m-d H:i:s") ?></p>
      <p>NO PO: Pemakaian Oil tanggal 16 Februari - 29 Februari 2024</p>
    </div>
    <div class="right">
      <h4>SURAT JALAN</h4>
      <p>No: 87215981725</p>
      <p>Kepada Yth</p>
      <p>PT. Anugrah Energi Kalimantan</p>
      <p>Citraland Banjarmasin, Comercial I-WALK</p>
      <p>Komplek manhatan No. 48 Kab. Banjar</p>
      <p>up : Maryadi (0621 4334 7691)</p>
      <p>Site Sebamban</p>
    </div>
  </div>
  <!-- tabel untuk menampilkan data dari database -->
  <table border="1">
    <thead>
      <tr>
        <th height="30" align="center" vertical="center">No.</th>
        <th height="30" align="center" vertical="center">Kode Barang</th>
        <th height="30" align="center" vertical="center">Nama Barang</th>
        <th height="30" align="center" vertical="center">Jumlah</th>
        <th height="30" align="center" vertical="center">Satuan</th>
      </tr>
    </thead>
    <tbody>
      <?php
      // variabel untuk nomor urut tabel 
      $no = 1;
      $jumlah = 0;
      // sql statement untuk menampilkan data dari tabel "tbl_jenis"
      $query = mysqli_query($mysqli, "SELECT *
      FROM tbl_barang_keluar INNER JOIN tbl_barang ON tbl_barang.id_barang = tbl_barang_keluar.barang
      INNER JOIN tbl_satuan ON tbl_satuan.id_satuan = tbl_barang.satuan
      WHERE tbl_barang_keluar.tanggal = (SELECT MAX(tanggal) FROM tbl_barang_keluar)")
                                      or die('Ada kesalahan pada query tampil data : ' . mysqli_error($mysqli));
      // ambil data hasil query
      while ($data = mysqli_fetch_assoc($query)) { 
        $jumlah += $data['jumlah'];
        ?>
        <!-- tampilkan data -->
        <tr>
          <td width="70" align="center"><?php echo $no++; ?></td>
          <td width="500"><?= $data['id_barang'] ?></td>
          <td width="500"><?= $data['nama_barang'] ?></td>
          <td width="500"><?= $data['jumlah'] ?></td>
          <td width="500"><?= $data['nama_satuan'] ?></td>
        </tr>
      <?php } ?>
      <tr>
        <td height="30" align="center" vertical="center" colspan="3">Jumlah</td>
        <td width="500" align="center" colspan="2"><?= $jumlah ?></td>
      </tr>
    </tbody>
  </table>
<?php } ?>

<script>
    window.print();
</script>
<style>
  .kop {
    display: flex;
    justify-content: space-between;
    width: 100%;
  }
  p {
    font-family: 'calibri', sans-serif;
    font-size: 12;
    font-style: normal;
  }

  table {
    font-family: 'Arial', sans-serif;
    font-size: 12;
    font-style: normal;
    font-weight: bold;
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

  <?php
  if (isset($_GET['id'])) {
    // ambil data GET dari tombol detail
    $id_transaksi = $_GET['id'];

    // sql statement untuk menampilkan data dari tabel "tbl_barang",  dan tabel "tbl_satuan" berdasarkan "id_barang"
    $query = mysqli_query($mysqli, "SELECT *,
                                    IFNULL((SELECT COUNT(id_barang) FROM tbl_detail_barang_keluar dbk WHERE dbk.id_keluar = bk.id_transaksi),0) as jlh_brg,
                                    IFNULL((SELECT SUM(jumlah) FROM tbl_detail_barang_keluar dbk WHERE dbk.id_keluar = bk.id_transaksi),0) as jlh_item,
                                    IFNULL((SELECT SUM(jumlah*harga) FROM tbl_detail_barang_keluar dbk WHERE dbk.id_keluar = bk.id_transaksi),0) as total 
                                    FROM tbl_barang_keluar bk LEFT JOIN tbl_customer c ON c.id_customer = bk.id_customer WHERE id_transaksi='$id_transaksi'")
                                    or die('Ada kesalahan pada query tampil data : ' . mysqli_error($mysqli));
    // ambil data hasil query
    $data = mysqli_fetch_assoc($query);
  }
?>
    
<table width="100%">
   
<!-- BREAK -->
  <tr>
    <td style="vertical-align: top; padding-top:6px; " >
      <img style="border-radius: 50%;" height="30px" width="55px" src="avatar-1.png" alt="">
    </td>
    <td>
      <div class="kop">
      <div class="left"> 
        <table>
          <tr>
            <td>PT. LUMASINDO SUMBER ABADI</td>
          </tr>
          <tr>
            <td>AUTHORIZED DISTRIBUTOR REPSOL</td>
          </tr>
        </table> <br>
        <table>
          <tr>
            <td>Jl. Yogyakarta No. 15 RT.001 RW.006, Loktabat Selatan, Banjarbaru Selatan</td>
          </tr>
          <tr>
            <td>Telp / Fax : 0812.5801.0000 </td>
          </tr>
          <tr>
            <td>Email: lumasindo_sa@yahoo.com</td>
          </tr>
        </table> <br>
        <table>
          <tr>
            <td>TGL</td>
            <td>:</td>
            <td><?= date("d-m-Y",strtotime($data['tanggal'])); ?></td>
          </tr>
          <tr>
            <td>NO PO</td>
            <td>:</td>
            <td><?= $data['no_po']; ?></td>
          </tr>
        </table>
      </div>
      <div class="right">
        <table>
          <tr>
            <td>SURAT JALAN</td>
          </tr>
          <tr>
            <td>No: <?= $data['id_transaksi']; ?></td>
          </tr>
        </table>
        
        <table border="0" >
          <tr>
            <td>Kepada Yth.</td><br>
          </tr>
          <tr>
            <td width="200"><?= $data['nama_perusahaan']; ?></td>
          </tr>
          <tr>
            <td width="200"><?= $data['alamat']; ?></td>
          </tr>
          <tr>
            <td>No Telp : <?= $data['no_tlp']; ?></td>
          </tr>
          <tr>
            <td>Site : <?= $data['sites']; ?></td>
          </tr>
        </table>
        
      </div>
    </div>
    <!-- tabel untuk menampilkan data dari database -->
    <table border="1px" style="border-collapse: collapse;" width="100%">
      <thead>
        <tr>
          <td height="30" width="4%" align="center" vertical="center">NO</td>
          <td height="30" width="15%"align="center" vertical="center">KODE BARANG</td>
          <td height="30" width="40%"align="center" vertical="center">NAMA BARANG</td>
          <td height="30" width="5%" align="center" vertical="center">QTY</td>
          <td height="30" width="20%" align="center" vertical="center">SATUAN</td>
        </tr>
      </thead>
      <tbody>
      <?php
            // variabel untuk nomor urut tabel
            $no = 1;
            // sql statement untuk menampilkan data dari tabel "tbl_barang" dan tabel "tbl_satuan"
            $query = mysqli_query($mysqli, "SELECT * from tbl_detail_barang_keluar dbk
                                                LEFT JOIN tbl_barang b ON b.id_barang = dbk.id_barang
                                                LEFT JOIN tbl_satuan s ON s.id_satuan = b.satuan
                                                WHERE dbk.id_keluar = '$id_transaksi'")
                                                or die('Ada kesalahan pada query tampil data : ' . mysqli_error($mysqli));
                // ambil data hasil query
                while ($row = mysqli_fetch_assoc($query)) { ?>
          <!-- tampilkan data -->
          <tr>
            <td width="70" align="center"><?= $no++; ?></td>
            <td width="500" align="center"><?= $row['id_barang']; ?></td>
            <td width="500"><?= $row['nama_barang']; ?></td>
            <td width="500" align="center"><?= $row['jumlah']; ?></td>
            <td width="500" align="center"><?= $row['nama_satuan']; ?></td>
          </tr>
          <?php } ?>
        
      </tbody>
      <!-- Terbilang, sub total, ppn dan total -->
      <tr>
          <td colspan="3" style="text-align: center;" width="59%"> TOTAL
          <td colspan="2">(JLH)(SATUAN) + (JLH)(SATUAN)
        </tr>  
    </table>
    <!-- note -->
    <table>
    <tr>
            <td style="padding-left: 2px;" valign="top">
              Note : 
            </td>
            <td colspan="2">
              Bila segel rusak atau Drum  meragukan harap konfirmasi ke kantor <br>
              Barang yang sudah diterima tidak dapat ditukar /
              dikembalikan.
            </td>
          </tr>
    </table>
  </table>
  <!-- table footer --> <br>
  <table width="100%">
        <tr>
            <td style="padding-left: 52px;">
              PENGIRIM/EKSPEDISI
            </td>
            <td>
              DITERIMA OLEH
            </td>
            <td>
              MENGETAHUI
            </td> 
            <td align="right" style="padding-right: 15px;">
              GUDANG
            </td>
          </tr>
    </table>
<?php } ?>

<script>
    window.print();
</script>
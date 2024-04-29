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
 
<table>
  <tr>
    <td style="vertical-align: top; padding-top:6px; " ><img style="border-radius: 50%;" height="30px" width="55px" src="avatar-1.png" alt=""></td>
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
            <td>TGL FAKTUR</td>
            <td>:</td>
            <td></td>
          </tr>
          <tr>
            <td>TGL JATUH TEMPO</td>
            <td>:</td>
            <td></td>
          </tr>
          <tr>
            <td>NO PO</td>
            <td>:</td>
            <td></td>
          </tr>
        </table>
      </div>
      <div class="right">
        <table>
          <tr>
            <td><u>INVOICE/FAKTUR</u></td>
          </tr>
          <tr>
            <td>No :</td>
            <td></td>
          </tr>
        </table>
        
        <table border="0" >
          <tr>
            <td>Kepada Yth</td><br>
          </tr>
          <tr>
            <td width="200">Lorem ipsum dolor sit amet consectetur adipisicing elit. Soluta iure velit optio enim fugit tempora id nulla perspiciatis, maiores molestiae quod magnam repudiandae minima ducimus nam, ex excepturi facilis eligendi.</td>
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
          <td height="30" width="20%" align="center" vertical="center">HARGA SATUAN</td>
          <td height="30" width="5%" align="center" vertical="center">QTY</td>
          <td height="30" width="20%" align="center" vertical="center">JUMLAH</td>
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
            <td width="70" align="center"></td>
            <td width="500"></td>
            <td width="500"></td>
            <td width="500"></td>
            <td width="500"></td>
            <td width="500"></td>
          </tr>
        <?php } ?>
        
      </tbody>
      <!-- Terbilang, sub total, ppn dan total -->
      <tr>
          <td colspan="3" style="padding-left: 5px;" width="59%" rowspan="2"> Terbilang :<br> ..... </td>
          <td colspan="2" rowspan="2"> SUB TOTAL <br> PPN <br> TOTAL </td>
          <td rowspan="2" align="right">... <br> ... <br> ...</td>
        </tr>
        

        
      <tfoot>
      <!-- table footer -->
        <tr>
          <td colspan="4" style="padding-left: 5px;">
            Pembayaran mohon ditransfer ke rekening A/N : PT. Lumasindo Sumber Abadi <br>
            A/C : 031.007.7190.000 Bank Mandiri <br>
            A/C : 800183490900 CIMB Niaga <br>
            Pembayaran dengan Cek/Giro dll. Dianggap lunas setelah di uangkan
          </td>
          <td colspan="2" align="center">Hormat Kami <br> <br> <br> <br> Harris Siagian</td>
        </tr>
      </tfoot>
        
    </table>
      </td>
    </tr>

  </table>
          
  
<?php } ?>

<script>
    window.print();
</script>
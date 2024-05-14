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
            <td>SURAT JALAN</td>
          </tr>
          <tr>
            <td>No :</td>
            <td></td>
          </tr>
        </table>
        
        <table border="0" >
          <tr>
            <td>Kepada Yth.</td><br>
          </tr>
          <tr>
            <td width="200">PT BANJAR MALINDO JAYA</td>
          </tr>
          <tr>
            <td width="200">Citraland Banjarmasin, Commercial I-WALK Komplek manhattan No. 48 Kab.Banjar</td>
          </tr>
          <tr>
            <td>No Telp : </td>
          </tr>
          <tr>
            <td>Site :</td>
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
        
          <!-- tampilkan data -->
          <tr>
            <td width="70" align="center"></td>
            <td width="500"></td>
            <td width="500"></td>
            <td width="500"></td>
            <td width="500"></td>
          </tr>
       
        
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
              Barang yang sudah diterima tidak dapat ditukar/
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
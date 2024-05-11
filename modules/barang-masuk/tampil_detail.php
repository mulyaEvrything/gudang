<?php
// mencegah direct access file PHP agar file PHP tidak bisa diakses secara langsung dari browser dan hanya dapat dijalankan ketika di include oleh file lain
// jika file diakses secara langsung
if (basename($_SERVER['PHP_SELF']) === basename(__FILE__)) {
  // alihkan ke halaman error 404
  header('location: 404.html');
}
// jika file di include oleh file lain, tampilkan isi file
else {
  // mengecek data GET "id_barang"
  if (isset($_GET['id'])) {
    // ambil data GET dari tombol detail
    $id_barang = $_GET['id'];

    // sql statement untuk menampilkan data dari tabel "tbl_barang",  dan tabel "tbl_satuan" berdasarkan "id_barang"
    $query = mysqli_query($mysqli, "SELECT a.id_barang, a.nama_barang, a.stok_minimum, a.stok, a.harga, a.satuan, a.foto, c.nama_satuan
                                    FROM tbl_barang as a INNER JOIN tbl_satuan as c 
                                    ON a.satuan=c.id_satuan 
                                    WHERE a.id_barang='$id_barang'")
                                    or die('Ada kesalahan pada query tampil data : ' . mysqli_error($mysqli));
    // ambil data hasil query
    $data = mysqli_fetch_assoc($query);
  }
?>
  <div class="panel-header bg-secondary-gradient">
    <div class="page-inner py-45">
      <div class="d-flex align-items-left align-items-md-top flex-column flex-md-row">
        <div class="page-header text-white">
          <!-- judul halaman -->
          <h4 class="page-title text-white"><i class="fas fa-sign-in-alt mr-2"></i> Barang Masuk</h4>
          <!-- breadcrumbs -->
          <ul class="breadcrumbs">
            <li class="nav-home"><a href="?module=dashboard"><i class="flaticon-home text-white"></i></a></li>
            <li class="separator"><i class="flaticon-right-arrow"></i></li>
            <li class="nav-item"><a href="?module=barang" class="text-white">Barang Masuk</a></li>
            <li class="separator"><i class="flaticon-right-arrow"></i></li>
            <li class="nav-item"><a>Detail</a></li>
          </ul>
        </div>
        <div class="ml-md-auto py-2 py-md-0">
          <!-- tombol kembali ke halaman data barang -->
          <a href="?module=barang_masuk" class="btn btn-secondary btn-round">
            <span class="btn-label"><i class="far fa-arrow-alt-circle-left mr-2"></i></span> Kembali
          </a>
        </div>
      </div>
    </div>
  </div>

  <div class="page-inner mt--5">
    
        <div class="card">
            <div class="card-header">
            <!-- judul form -->
            <div class="card-title">Detail Barang Masuk</div>
          </div>
          <!-- detail data -->
          <div class="card-body">
            <table class="table table-striped">
              <tr>
                <td width="120">ID Transaksi</td>
                <td width="10">:</td>
                <td></td>
              </tr>
              <tr>
                <td>Tanggal</td>
                <td>:</td>
                <td></td>
              </tr>
              
              <tr>
                <td>Jumlah Barang Masuk</td>
                <td>:</td>
                <td></td>
              </tr>
            </table>
          </div>
        </div>
  </div>
<?php } ?>
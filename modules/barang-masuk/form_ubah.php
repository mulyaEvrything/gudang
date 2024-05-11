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
            <h4 class="page-title text-white"><i class="fas fa-sign-in-alt mr-2"></i> Barang Keluar</h4>
            <!-- breadcrumbs -->
            <ul class="breadcrumbs">
                <li class="nav-home"><a href="?module=dashboard"><i class="flaticon-home text-white"></i></a></li>
                <li class="separator"><i class="flaticon-right-arrow"></i></li>
                <li class="nav-item"><a href="?module=barang" class="text-white">Barang Keluar</a></li>
                <li class="separator"><i class="flaticon-right-arrow"></i></li>
                <li class="nav-item"><a>Ubah</a></li>
            </ul>
            </div>
            
        </div>
        </div>
    </div>

    <div class="page-inner mt--5">
        <div class="card">
            <div class="card-header">
                <!-- judul form -->
                <div class="card-title">Ubah Barang Keluar</div>
            </div>
                <!-- detail data -->
                <div class="card-body">
                <!--  -->
                </div>
                <div class="card-action">
                    <!-- tombol simpan data -->
                    <input type="submit" name="simpan" value="Simpan" class="btn btn-secondary btn-round pl-4 pr-4 mr-2">
                    <!-- tombol kembali ke halaman data barang -->
                    <a href="?module=barang_masuk" class="btn btn-default btn-round pl-4 pr-4">Batal</a>
                </div>
        </div>
    </div>
<?php } ?>
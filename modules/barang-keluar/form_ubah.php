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
    $id_transaksi = $_GET['id'];

    // sql statement untuk menampilkan data dari tabel "tbl_barang",  dan tabel "tbl_satuan" berdasarkan "id_barang"
    $query = mysqli_query($mysqli, "SELECT * FROM tbl_barang_keluar WHERE id_transaksi='$id_transaksi'")
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
            <h4 class="page-title text-white"><i class="fas fa-sign-out-alt mr-2"></i> Barang Keluar</h4>
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
        <div class="card-title">Ubah Data Barang Keluar</div>
      </div>
      <!-- form entri data -->
      <form action="modules/barang-keluar/proses_ubah.php" id="multipleInsertForm" method="post" class="needs-validation" novalidate>
        <div class="card-body">
          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label>No. Nota <span class="text-danger">*</span></label>
                <!-- tampilkan "id_transaksi" -->
                <input type="text" name="id_transaksi" class="form-control" value="<?php echo $data['id_transaksi']; ?>" readonly>
              </div>
            </div>

            <div class="col-md-6 ml-auto">
              <div class="form-group">
                <label>Tanggal <span class="text-danger">*</span></label>
                <input type="text" name="tanggal" class="form-control date-picker" autocomplete="off" value="<?php echo date("d-m-Y", strtotime($data['tanggal'])); ?>" required>
                <div class="invalid-feedback">Tanggal tidak boleh kosong.</div>
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col-md-4">
              <div class="form-group">
                <label>Customer <span class="text-danger">*</span></label>
                <select id="data_cust" name="id_customer" class="form-control chosen-select" autocomplete="off" required>
                  <?php
                  // sql statement untuk menampilkan data dari tabel "tbl_barang"
                  $query_cust = mysqli_query($mysqli, "SELECT * FROM tbl_customer ORDER BY nama_perusahaan ASC")
                                                        or die('Ada kesalahan pada query tampil data : ' . mysqli_error($mysqli));
                  // ambil data hasil query
                  while ($data_cust = mysqli_fetch_assoc($query_cust)) { ?>
                    <!-- tampilkan data -->
                    <option value="<?= $data_cust['id_customer']; ?>" <?php if($data_cust['id_customer'] == $data['id_customer']) { echo "selected"; } ?>>
                      <?= $data_cust['nama_perusahaan']; ?> - <?= $data_cust['sites']; ?></option>
                  <?php }
                  ?>
                  </select>
                  <div class="invalid-feedback">Customer tidak boleh kosong.</div>
              </div>
            </div>

            <div class="col-md-4 ml-auto">
              <div class="form-group">
                <label>No. PO <span class="text-danger">*</span></label>
                <input type="text" name="no_po" class="form-control" autocomplete="off" value="<?php echo $data['no_po']; ?>" required>
                <div class="invalid-feedback">No. PO tidak boleh kosong.</div>
              </div>
            </div>
            
            <div class="col-md-4 ml-auto">
              <div class="form-group">
                <label>Tanggal Jatuh Tempo<span class="text-danger">*</span></label>
                <input type="text" name="tanggal_tempo" class="form-control date-picker" autocomplete="off" value="<?php echo date("d-m-Y",strtotime($data['tgl_jatuh_tempo'])); ?>" required>
                <div class="invalid-feedback">Tanggal tidak boleh kosong.</div>
              </div>
            </div>
          </div>
        </div>

        
        <div class="card-action">
          <!-- tombol simpan data -->
          <button type="submit" name="simpan" class="btn btn-secondary btn-round pl-4 pr-4 mr-2">Simpan</button>
          <!-- tombol kembali ke halaman data barang masuk -->
          <a href="?module=barang_keluar" class="btn btn-default btn-round pl-4 pr-4">Batal</a>
        </div>
      </form>
    </div>
  </div>
<?php } ?>
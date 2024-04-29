<?php
// mencegah direct access file PHP agar file PHP tidak bisa diakses secara langsung dari browser dan hanya dapat dijalankan ketika di include oleh file lain
// jika file diakses secara langsung
if (basename($_SERVER['PHP_SELF']) === basename(__FILE__)) {
  // alihkan ke halaman error 404
  header('location: 404.html');
}
// jika file di include oleh file lain, tampilkan isi file
else {
  // menampilkan pesan sesuai dengan proses yang dijalankan
  // jika pesan tersedia
  if (isset($_GET['pesan'])) {
    // jika pesan = 1
    if ($_GET['pesan'] == 1) {
      // tampilkan pesan sukses simpan data
      echo '<div class="alert alert-notify alert-success alert-dismissible fade show" role="alert">
              <span data-notify="icon" class="fas fa-check"></span> 
              <span data-notify="title" class="text-success">Sukses!</span> 
              <span data-notify="message">Data barang masuk berhasil disimpan.</span>
              <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>';
    }
    // jika pesan = 2
    elseif ($_GET['pesan'] == 2) {
      // tampilkan pesan sukses hapus data
      echo '<div class="alert alert-notify alert-success alert-dismissible fade show" role="alert">
              <span data-notify="icon" class="fas fa-check"></span> 
              <span data-notify="title" class="text-success">Sukses!</span> 
              <span data-notify="message">Data barang masuk berhasil dihapus.</span>
              <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>';
    }
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
            <li class="nav-item"><a href="?module=barang_masuk" class="text-white">Barang Masuk</a></li>
            <li class="separator"><i class="flaticon-right-arrow"></i></li>
            <li class="nav-item"><a>Data</a></li>
          </ul>
        </div>
        <div class="ml-md-auto py-2 py-md-0">
          <!-- tombol entri data -->
          <a href="?module=form_entri_barang_masuk" class="btn btn-secondary btn-round">
            <span class="btn-label"><i class="fa fa-plus mr-2"></i></span> Entri Data
          </a>
          <!-- tombol export data -->
          <!-- <a href="modules/barang-masuk/print.php" target="_blank" class="btn btn-success btn-round">
            <span class="btn-label"><i class="fa fa-file-excel mr-2"></i></span> Cetak Invoice
          </a> -->
        </div>
      </div>
    </div>
  </div>

  <div class="page-inner mt--5">
    <div class="card">
      <div class="card-header">
        <!-- judul tabel -->
        <div class="card-title">Data Barang Masuk</div>
      </div>
      <div class="card-body">
        <div class="table-responsive">
          <!-- tabel untuk menampilkan data dari database -->
          <table id="basic-datatables" class="display table table-bordered table-striped table-hover">
            <thead>
              <tr>
                <th class="text-center">No.</th>
                <th class="text-center">ID Transaksi</th>
                <th class="text-center">Tanggal</th>
                <th class="text-center">Barang</th>
                
                <th class="text-center">Aksi</th>
              </tr>
            </thead>
            <tbody>
              
                <!-- variabel untuk nomor urut tabel -->
              
                <!-- sql statement untuk menampilkan data dari tabel "tbl_barang_masuk", tabel "tbl_barang", dan tabel "tbl_satuan" -->
            
                <!-- ambil data hasil query -->
              
                <!-- tampilkan data -->
                <tr>
                  <td width="50" class="text-center"></td>
                  <td width="90" class="text-center"></td>
                  <td width="70" class="text-center"></td>
                  <td width="220"></td>

                  <td width="50" class="text-center">
                    <div>
                      <!-- tombol hapus data -->
                      <a href="#" class="btn btn-icon btn-round btn-primary btn-sm mr-md-1" data-toggle="tooltip" data-placement="top" title="Detail">
                        <i class="fas fa-clone fa-sm"></i>
                      </a>

                      <!-- tombol ubah data -->
                      <a href="#" class="btn btn-icon btn-round btn-secondary btn-sm mr-md-1" data-toggle="tooltip" data-placement="top" title="Ubah">
                        <i class="fas fa-pencil-alt fa-sm"></i>
                      </a>

                    </div>
                  </td>
                </tr>
      
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
<?php } ?>
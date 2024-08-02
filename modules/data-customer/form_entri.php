<?php
// mencegah direct access file PHP agar file PHP tidak bisa diakses secara langsung dari browser dan hanya dapat dijalankan ketika di include oleh file lain
// jika file diakses secara langsung
if (basename($_SERVER['PHP_SELF']) === basename(__FILE__)) {
  // alihkan ke halaman error 404
  header('location: 404.html');
}
// jika file di include oleh file lain, tampilkan isi file
else { ?>
  <!-- menampilkan pesan kesalahan unggah file -->
  <div id="pesan"></div>

  <div class="panel-header bg-secondary-gradient">
    <div class="page-inner py-4">
      <div class="page-header text-white">
        <!-- judul halaman -->
        <h4 class="page-title text-white"><i class="fas fa-clipboard mr-2"></i>Data Customer</h4>
        <!-- breadcrumbs -->
        <ul class="breadcrumbs">
          <li class="nav-home"><a href="?module=dashboard"><i class="flaticon-home text-white"></i></a></li>
          <li class="separator"><i class="flaticon-right-arrow"></i></li>
          <li class="nav-item"><a href="?module=data_customer" class="text-white">Data Customer</a></li>
          <li class="separator"><i class="flaticon-right-arrow"></i></li>
          <li class="nav-item"><a>Entri</a></li>
        </ul>
      </div>
    </div>
  </div>

  <div class="page-inner mt--5">
    <div class="card">
      <div class="card-header">
        <!-- judul form -->
        <div class="card-title">Entri Data Barang</div>
      </div>
      <!-- form entri data -->
      <form action="modules/data-customer/proses_entri.php" method="post" class="needs-validation" novalidate>
        <div class="card-body">
          <div class="row">
            <div class="col-md-12">
              <div class="form-group">
                <label>Nama Perusahaan <span class="text-danger">*</span></label>
                <input type="text" name="nama_perusahaan" class="form-control" autocomplete="off" required>
                <div class="invalid-feedback">Nama perusahaan tidak boleh kosong.</div>
              </div>

              <div class="form-group">
                <label>Singkatan <span class="text-danger">*</span></label>
                <input type="text" name="singkatan" class="form-control" autocomplete="off" required>
                <div class="invalid-feedback">Singkatan tidak boleh kosong.</div>
              </div>

              <div class="form-group">
                <label>Alamat<span class="text-danger">*</span></label>
                <textarea name="alamat" autocomplete="off" class="form-control"cols="10" rows="10" require></textarea>
                <div class="invalid-feedback">Alamat satuan tidak boleh kosong.</div>
              </div>
              <div class="form-group">
                <label>Site (Jika ada)<span class="text-danger">*</span></label>
                <input type="text" name="site" class="form-control" autocomplete="off">
              </div>

              <div class="form-group">
                <label>Kontak (Jika ada)<span class="text-danger">*</span></label>
                <input type="text" name="kontak" class="form-control" autocomplete="off">
              </div>
              
              <div class="form-group">
                <label>No Telpon (Jika ada)<span class="text-danger">*</span></label>
                <input type="text" name="no_tlp" class="form-control" autocomplete="off" onKeyPress="return goodchars(event,'0123456789',this)">
              </div>
              
              
          </div>
        </div>
        <div class="card-action">
          <!-- tombol simpan data -->
          <input type="submit" name="simpan" value="Simpan" class="btn btn-secondary btn-round pl-4 pr-4 mr-2">
          <!-- tombol kembali ke halaman data barang -->
          <a href="?module=data_customer" class="btn btn-default btn-round pl-4 pr-4">Batal</a>
        </div>
      </form>
    </div>
  </div>
  
    

<?php } ?>
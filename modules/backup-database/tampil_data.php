<?php
// mencegah direct access file PHP agar file PHP tidak bisa diakses secara langsung dari browser dan hanya dapat dijalankan ketika di include oleh file lain
// jika file diakses secara langsung
if (basename($_SERVER['PHP_SELF']) === basename(__FILE__)) {
  // alihkan ke halaman error 404
  header('location: 404.html');
}
// jika file di include oleh file lain, tampilkan isi file
else { ?>
  <div class="panel-header bg-secondary-gradient">
    <div class="page-inner py-4">
      <div class="page-header text-white">
        <!-- judul halaman -->
        <h4 class="page-title text-white"><i class="fas fa-download"></i> Backup Database</h4>
        <!-- breadcrumbs -->
        <ul class="breadcrumbs">
          <li class="nav-home"><a href="?module=dashboard"><i class="flaticon-home text-white"></i></a></li>
          <li class="separator"><i class="flaticon-right-arrow"></i></li>
          <li class="nav-item"><a>Backup Database</a></li>
          <li class="separator"><i class="flaticon-right-arrow"></i></li>
          <li class="nav-item"><a>Data</a></li>
        </ul>
      </div>
    </div>
  </div>

  
    <div class="page-inner mt--5">
        <div class="col-md-3">
            <div class="card">
                <div class="card-header">
                    <!-- judul form -->
                    <div class="card-title">Download Database</div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-11 pr-0">
                            <div class="form-group pt-6">
                            <!-- tombol tampil data -->
                                <button class="btn col-md-11"><i class="fa fa-download"></i> Download</button>
                            </div>
                        </div>
                    </div>
                    
                </div>
            </div>
        </div>
    </div>
 
<?php
}
?>
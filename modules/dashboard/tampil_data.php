<?php
// mencegah direct access file PHP agar file PHP tidak bisa diakses secara langsung dari browser dan hanya dapat dijalankan ketika di include oleh file lain
// jika file diakses secara langsung
if (basename($_SERVER['PHP_SELF']) === basename(__FILE__)) {
  // alihkan ke halaman error 404
  header('location: 404.html');
}
// jika file di include oleh file lain, tampilkan isi file
else {
  // menampilkan pesan selamat datang
  // jika pesan tersedia
  if (isset($_GET['pesan'])) {
    // jika pesan = 1
    if ($_GET['pesan'] == 1) {
      // tampilkan pesan selamat datang
      echo '<div class="alert alert-notify alert-secondary alert-dismissible fade show" role="alert">
              <span data-notify="icon" class="fas fa-user-alt"></span> 
              <span data-notify="title" class="text-secondary">Hi! ' . $_SESSION['nama_user'] . '</span> 
              <span data-notify="message">Selamat Datang di Sistem Informasi Manajemen Penjualan & Stok Barang.</span>
              <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>';
    }
  }
?>
  <div class="panel-header bg-secondary">
    <div class="page-inner py-5">
      <div class="d-flex align-items-left align-items-md-top flex-column flex-md-row">
        <div class="page-header text-white">
          <!-- judul halaman -->
          <h4 class="page-title text-white"><i class="fas fa-home mr-2"></i> Dashboard</h4>
        </div>
      </div>
    </div>
  </div>
  <div class="page-inner mt--5">
    <div class="row row-card-no-pd mt--2">
      <!-- menampilkan informasi jumlah data barang -->
      <div class="col-sm-12 col-md-4">
        <div class="card card-stats card-round">
          <div class="card-body ">
            <div class="row">
              <div class="col-5">
                <div class="icon-big2 text-center">
                  <i class="flaticon-box-2 text-secondary"></i>
                </div>
              </div>
              <div class="col-7 col-stats">
                <div class="numbers">
                  <p class="card-category">Data Barang</p>
                  <?php
                  // sql statement untuk menampilkan jumlah data pada tabel "tbl_barang"
                  $query = mysqli_query($mysqli, "SELECT * FROM tbl_barang")
                                                  or die('Ada kesalahan pada query jumlah data barang : ' . mysqli_error($mysqli));
                  // ambil jumlah data dari hasil query
                  $jumlah_barang = mysqli_num_rows($query);
                  ?>
                  <!-- tampilkan data -->
                  <h4 class="card-title"><?php echo number_format($jumlah_barang, 0, '', '.'); ?></h4>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <!-- menampilkan informasi jumlah data barang masuk -->
      <div class="col-sm-12 col-md-4">
        <div class="card card-stats card-round">
          <div class="card-body ">
            <div class="row">
              <div class="col-5">
                <div class="icon-big2 text-center">
                  <i class="flaticon-inbox text-success"></i>
                </div>
              </div>
              <div class="col-7 col-stats">
                <div class="numbers">
                  <p class="card-category">Data Barang Masuk</p>
                  <?php
                  // sql statement untuk menampilkan jumlah data pada tabel "tbl_barang_masuk"
                  $query = mysqli_query($mysqli, "SELECT * FROM tbl_barang_masuk")
                                                  or die('Ada kesalahan pada query jumlah data barang masuk : ' . mysqli_error($mysqli));
                  // ambil jumlah data dari hasil query
                  $jumlah_barang_masuk = mysqli_num_rows($query);
                  ?>
                  <!-- tampilkan data -->
                  <h4 class="card-title"><?php echo number_format($jumlah_barang_masuk, 0, '', '.'); ?></h4>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <!-- menampilkan informasi jumlah data barang keluar -->
      <div class="col-sm-12 col-md-4">
        <div class="card card-stats card-round">
          <div class="card-body">
            <div class="row">
              <div class="col-5">
                <div class="icon-big2 text-center">
                  <i class="flaticon-archive text-warning"></i>
                </div>
              </div>
              <div class="col-7 col-stats">
                <div class="numbers">
                  <p class="card-category">Data Barang Keluar</p>
                  <?php
                  // sql statement untuk menampilkan jumlah data pada tabel "tbl_barang_keluar"
                  $query = mysqli_query($mysqli, "SELECT * FROM tbl_barang_keluar")
                                                  or die('Ada kesalahan pada query jumlah data barang keluar : ' . mysqli_error($mysqli));
                  // ambil jumlah data dari hasil query
                  $jumlah_barang_keluar = mysqli_num_rows($query);
                  ?>
                  <!-- tampilkan data -->
                  <h4 class="card-title"><?php echo number_format($jumlah_barang_keluar, 0, '', '.'); ?></h4>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

      
    <div class="card">
      <div class="card-body">
        <div class="table-responsive">
        <!-- tabel untuk menampilkan grafik penjualan dari database -->
          <h1>Grafik Penjualan</h1>
          <div>
        
            <?php

            $data_barang = mysqli_query($mysqli, "SELECT a.id_barang, a.jumlah, c.nama_barang, c.id_barang
                                    FROM tbl_detail_barang_keluar as a INNER JOIN tbl_barang as c 
                                    ON a.id_barang=c.id_barang 
                                    GROUP BY c.nama_barang")
                                    or die('Ada kesalahan pada query tampil data : ' . mysqli_error($mysqli));
            $jumlah_penjualan = mysqli_query($mysqli, "SELECT SUM(jumlah) as sold FROM tbl_detail_barang_keluar GROUP BY id_barang")
                                    or die('Ada kesalahan pada query tampil data : ' . mysqli_error($mysqli));
            
            ?>

            
            <canvas id="myChart"></canvas>
          </div>
          <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
          
          <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
            
            <script>

          
              const ctx = document.getElementById('myChart');

              new Chart(ctx, {
                type: 'bar',
                data: {
                  labels: [<?php while($row = mysqli_fetch_array ($data_barang)) {echo '"',$row['nama_barang'].'",';}?>],
                  datasets: [{
                    label: 'Data Penjualan',
                    data: [<?php while($row = mysqli_fetch_array ($jumlah_penjualan)) {echo '"',$row['sold'].'",';}?>],
                    borderWidth: 1
                  }]
                },
                options: {
                  scales: {
                    y: {
                      beginAtZero: true
                    }
                  }
                }
              });
            </script>
            <body>






          
        </div>
      </div>
    </div>
    

    <!-- menampilkan informasi stok barang yang telah mencapai batas minimum -->
    <div class="card">
      <div class="card-header">
        <!-- judul tabel -->
        <div class="card-title"><i class="fas fa-info-circle mr-2"></i> Stok barang telah mencapai batas minimum</div>
      </div>
      <div class="card-body">
        <div class="table-responsive">
          <!-- tabel untuk menampilkan data dari database -->
          <table id="basic-datatables" class="display table table-bordered table-striped table-hover">
            <thead>
              <tr>
                <th class="text-center">No.</th>
                <th class="text-center">Kode Barang</th>
                <th class="text-center">Nama Barang</th>
                <th class="text-center">Stok</th>
                <th class="text-center">Satuan</th>
              </tr>
            </thead>
            <tbody>
              <?php
              // variabel untuk nomor urut tabel
              $no = 1;
              // sql statement untuk menampilkan data dari tabel "tbl_barang", tabel "tbl_jenis", dan tabel "tbl_satuan" berdasarkan "stok"
              $tanggal = date('Y-m-d');
              $query = mysqli_query($mysqli, "SELECT *,
                                      IFNULL((SELECT SUM(jumlah) FROM tbl_detail_barang_masuk dbm, tbl_barang_masuk bm WHERE dbm.id_barang = b.id_barang
                                            AND dbm.id_masuk = bm.id_transaksi AND bm.tanggal <= '$tanggal'),0) as jlh_masuk,
                                      IFNULL((SELECT SUM(jumlah) FROM tbl_detail_barang_keluar dbk, tbl_barang_keluar bk WHERE dbk.id_barang = b.id_barang
                                            AND dbk.id_keluar = bk.id_transaksi AND bk.tanggal <= '$tanggal'),0) as jlh_keluar,
                                      (SELECT jlh_masuk - jlh_keluar) as stoknow
                                      FROM tbl_barang b
                                      LEFT JOIN tbl_satuan s ON s.id_satuan = b.satuan
                                      WHERE (SELECT (IFNULL((SELECT SUM(jumlah) FROM tbl_detail_barang_masuk dbm, tbl_barang_masuk bm WHERE dbm.id_barang = b.id_barang
                                            AND dbm.id_masuk = bm.id_transaksi AND bm.tanggal <= '$tanggal'),0)) - ( IFNULL((SELECT SUM(jumlah) FROM tbl_detail_barang_keluar dbk, tbl_barang_keluar bk WHERE dbk.id_barang = b.id_barang
                                            AND dbk.id_keluar = bk.id_transaksi AND bk.tanggal <= '$tanggal'),0))) <= b.stok_minimum")
                                              or die('Ada kesalahan pada query tampil data : ' . mysqli_error($mysqli));
              // ambil data hasil query
              while ($data = mysqli_fetch_assoc($query)) { ?>
                <!-- tampilkan data -->
                <tr>
                  <td width="50" class="text-center"><?php echo $no++; ?></td>
                  <td width="80" class="text-center"><?php echo $data['id_barang']; ?></td>
                  <td width="200"><?php echo $data['nama_barang']; ?></td>
                  <td width="70" class="text-right"><span class="badge badge-warning"><?php echo $data['stoknow']; ?></span></td>
                  <td width="70"><?php echo $data['nama_satuan']; ?></td>
                </tr>
              <?php } ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
<?php } ?>
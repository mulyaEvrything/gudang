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
              <span data-notify="message">Data barang keluar berhasil disimpan.</span>
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
              <span data-notify="message">Data barang keluar berhasil diubah.</span>
              <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>';
    }
    // jika pesan = 3
    elseif ($_GET['pesan'] == 3) {
      // tampilkan pesan sukses hapus data
      echo '<div class="alert alert-notify alert-success alert-dismissible fade show" role="alert">
              <span data-notify="icon" class="fas fa-trash"></span> 
              <span data-notify="title" class="text-success">Sukses!</span> 
              <span data-notify="message">Data barang keluar berhasil dihapus.</span>
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
          <h4 class="page-title text-white"><i class="fas fa-sign-in-alt mr-2"></i> Barang Keluar</h4>
          <!-- breadcrumbs -->
          <ul class="breadcrumbs">
            <li class="nav-home"><a href="?module=dashboard"><i class="flaticon-home text-white"></i></a></li>
            <li class="separator"><i class="flaticon-right-arrow"></i></li>
            <li class="nav-item"><a href="?module=barang_masuk" class="text-white">Barang Keluar</a></li>
            <li class="separator"><i class="flaticon-right-arrow"></i></li>
            <li class="nav-item"><a>Data</a></li>
          </ul>
        </div>
        <div class="ml-md-auto py-2 py-md-0">
          <!-- tombol entri data -->
          <a href="?module=form_entri_barang_keluar" class="btn btn-secondary btn-round">
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
        <div class="card-title">Data Barang Keluar</div>
      </div>
      <div class="card-body">
        <div class="table-responsive">
          <!-- tabel untuk menampilkan data dari database -->
          <table id="basic-datatables" class="display table table-bordered table-striped table-hover">
            <thead>
              <tr>
                <th class="text-center">No.</th>
                <th class="text-center">No. Nota</th>
                <th class="text-center">Tgl Nota</th>
                <th class="text-center">Tgl Jatuh Tempo</th>
                <th class="text-center">Customer</th>
                <th class="text-center">No. PO</th>
                <th class="text-center">Jlh. Barang</th>
                <th class="text-center">Jlh. Item</th>
                <th class="text-center">Total (Rp.)</th>
                <th class="text-center">Aksi</th>
              </tr>
            </thead>
            <tbody>
            <?php
                // variabel untuk nomor urut tabel
                $no = 1;
                // sql statement untuk menampilkan data dari tabel "tbl_barang" dan tabel "tbl_satuan"
                $query = mysqli_query($mysqli, "SELECT *,
                                                IFNULL((SELECT COUNT(id_barang) FROM tbl_detail_barang_keluar dbk WHERE dbk.id_keluar = bk.id_transaksi),0) as jlh_brg,
                                                IFNULL((SELECT SUM(jumlah) FROM tbl_detail_barang_keluar dbk WHERE dbk.id_keluar = bk.id_transaksi),0) as jlh_item,
                                                IFNULL((SELECT SUM(jumlah*harga) FROM tbl_detail_barang_keluar dbk WHERE dbk.id_keluar = bk.id_transaksi),0) as total
                                                from tbl_barang_keluar bk
                                                LEFT JOIN tbl_customer c ON c.id_customer = bk.id_customer")
                                                or die('Ada kesalahan pada query tampil data : ' . mysqli_error($mysqli));
                // ambil data hasil query
                while ($data = mysqli_fetch_assoc($query)) { ?>
                <tr>
                  <td class="text-center"><?php echo $no++; ?></td>
                  <td class="text-center"><?php echo $data['id_transaksi']; ?></td>
                  <td class="text-center"><?php echo date('d-m-Y', strtotime($data['tanggal'])); ?></td>
                  <td class="text-center"><?php echo date('d-m-Y', strtotime($data['tgl_jatuh_tempo'])); ?></td>
                  <td class="text-left"><?php echo $data['nama_perusahaan'];?></td>
                  <td class="text-center"><?php echo $data['no_po'];?></td>
                  <td class="text-center"><?php echo $data['jlh_brg'];?></td>
                  <td class="text-center"><?php echo $data['jlh_item'];?></td>
                  <td class="text-center"><?php echo number_format($data['total'],0,',','.'); ?></td>
                  <td width="70" class="text-center">
                    <div>
                      <!-- tombol detail data -->
                      <a href="?module=detail_barang_keluar&id=<?= $data['id_transaksi'] ?>" class="btn btn-icon btn-round btn-primary btn-sm mr-md-1" data-toggle="tooltip" data-placement="top" title="Detail">
                        <i class="fas fa-eye fa-sm"></i>
                      </a>

                      <!-- tombol ubah data -->
                      <a href="?module=ubah_barang_keluar&id=<?= $data['id_transaksi'] ?>" class="btn btn-icon btn-round btn-secondary btn-sm mr-md-1" data-toggle="tooltip" data-placement="top" title="Ubah">
                        <i class="fas fa-pencil-alt fa-sm"></i>
                      </a>

                      <!-- tombol cetak invoice -->
                      <a href="modules/barang-keluar/print_invoice.php?id=<?= $data['id_transaksi'] ?>" target="_blank" class="btn btn-icon btn-round btn-success btn-sm mr-md-1" data-toggle="tooltip" data-placement="top" title="Cetak Invoice">
                        <i class="fas fa-print fa-sm "></i>
                      </a>
                      <!-- tombol cetak surat jalan -->
                      <a href="modules/barang-keluar/print_surat_jalan.php?id=<?= $data['id_transaksi'] ?>" target="_blank" class="btn btn-icon btn-round btn-warning btn-sm mr-md-1" data-toggle="tooltip" data-placement="top" title="Cetak Surat Jalan">
                        <i class="fas fa-print fa-sm "></i>
                      </a>

                      
                    </div>
                  </td>
                </tr>
      
                <?php } ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
<?php } ?>
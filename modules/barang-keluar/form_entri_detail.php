<?php
// mencegah direct access file PHP agar file PHP tidak bisa diakses secara langsung dari browser dan hanya dapat dijalankan ketika di include oleh file lain
// jika file diakses secara langsung
if (basename($_SERVER['PHP_SELF']) === basename(__FILE__)) {
  // alihkan ke halaman error 404
  header('location: 404.html');
}
// jika file di include oleh file lain, tampilkan isi file
else { 
  if (isset($_GET['pesan'])) {
    // jika pesan = 1
    if ($_GET['pesan'] == 1) {
      // tampilkan pesan sukses simpan data
      echo '<div class="alert alert-notify alert-success alert-dismissible fade show" role="alert">
              <span data-notify="icon" class="fas fa-check"></span> 
              <span data-notify="title" class="text-success">Sukses!</span> 
              <span data-notify="message">Data Transaksi Barang Keluar berhasil disimpan.</span>
              <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>';
    }
    // jika pesan = 2
    elseif ($_GET['pesan'] == 2) {
      // tampilkan pesan sukses ubah data
      echo '<div class="alert alert-notify alert-success alert-dismissible fade show" role="alert">
              <span data-notify="icon" class="fas fa-check"></span> 
              <span data-notify="title" class="text-success">Sukses!</span> 
              <span data-notify="message">Data Data Transaksi Barang Keluar berhasil diubah.</span>
              <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>';
    }
    // jika pesan = 3
    elseif ($_GET['pesan'] == 3) {
      // tampilkan pesan sukses hapus data
      echo '<div class="alert alert-notify alert-danger alert-dismissible fade show" role="alert">
              <span data-notify="icon" class="fas fa-trash"></span> 
              <span data-notify="title" class="text-success">Sukses!</span> 
              <span data-notify="message">Data Data Transaksi Barang Keluar berhasil dihapus.</span>
              <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>';
    }
    // jika pesan = 4
    elseif ($_GET['pesan'] == 4) {
      // tampilkan pesan gagal hapus data
      echo '<div class="alert alert-notify alert-danger alert-dismissible fade show" role="alert">
              <span data-notify="icon" class="fas fa-times"></span> 
              <span data-notify="title" class="text-danger">Gagal!</span> 
              <span data-notify="message">Data Data Transaksi Barang Keluar tidak bisa dihapus karena sudah tercatat pada Data Transaksi.</span>
              <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>';
    }
  }
  ?>
  <!-- menampilkan pesan kesalahan -->
  <div id="pesan"></div>

  <div class="panel-header bg-secondary-gradient">
    <div class="page-inner py-4">
      <div class="page-header text-white">
        <!-- judul halaman -->
        <h4 class="page-title text-white"><i class="fas fa-sign-out-alt mr-2"></i> Barang Keluar</h4>
        <!-- breadcrumbs -->
        <ul class="breadcrumbs">
          <li class="nav-home"><a href="?module=dashboard"><i class="flaticon-home text-white"></i></a></li>
          <li class="separator"><i class="flaticon-right-arrow"></i></li>
          <li class="nav-item"><a href="?module=barang_keluar" class="text-white">Barang Keluar</a></li>
          <li class="separator"><i class="flaticon-right-arrow"></i></li>
          <li class="nav-item"><a>Entri Detail</a></li>
        </ul>
      </div>
    </div>
  </div>

  <div class="page-inner mt--5">
    <div class="card">
      <div class="card-header">
        <!-- judul form -->
        <div class="card-title">Entri Data Detail Barang Keluar</div>
      </div>
      <!-- form entri data -->
      <form action="modules/barang-keluar/proses_entri_detail.php" method="post" class="needs-validation" novalidate>
        <div class="card-body">
          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <?php
                // mengambil "id_transaksi"
                $id_transaksi = $_GET['id'];
                // sql statement untuk menampilkan 7 digit terakhir dari "id_transaksi" pada tabel "tbl_barang_keluar"
                $query = mysqli_query($mysqli, "SELECT * FROM tbl_barang_keluar 
                                                LEFT JOIN tbl_customer ON tbl_customer.id_customer = tbl_barang_keluar.id_customer
                                                WHERE id_transaksi = '".$id_transaksi."'")
                                                or die('Ada kesalahan pada query tampil data : ' . mysqli_error($mysqli));
                // ambil jumlah baris data hasil query
                $rows = mysqli_num_rows($query);

                // cek hasil query
                // jika "id_transaksi" sudah ada
                if ($rows <> 0) {
                  // ambil data hasil query
                  $data = mysqli_fetch_assoc($query);
                  // nomor urut "id_transaksi" yang terakhir + 1 (contoh nomor urut yang terakhir adalah 2, maka 2 + 1 = 3, dst..)
                  $tanggal = $data['tanggal'];
                  $tanggal_tempo = $data['tgl_jatuh_tempo'];
                  $nama_perusahaan = $data['nama_perusahaan'];
                  $no_po = $data['no_po'];
                }

                ?>
                <label>ID Transaksi <span class="text-danger">*</span></label>
                <!-- tampilkan "id_transaksi" -->
                <input type="text" name="id_transaksi" class="form-control" value="<?php echo $id_transaksi; ?>" readonly>
              </div>
            </div>

            <div class="col-md-6 ml-auto">
              <div class="form-group">
                <label>Tanggal <span class="text-danger">*</span></label>
                <input type="text" name="tanggal" class="form-control" autocomplete="off" value="<?php echo date("d-m-Y", strtotime($data['tanggal'])); ?>" readonly>
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col-md-4">
              <div class="form-group">
                <label>Customer <span class="text-danger">*</span></label>
                <input type="text" name="nama_perusahaan" class="form-control" value="<?php echo $nama_perusahaan; ?>" readonly>
              </div>
            </div>

            <div class="col-md-4 ml-auto">
              <div class="form-group">
                <label>No. PO <span class="text-danger">*</span></label>
                <input type="text" name="no_po" class="form-control" autocomplete="off" value="<?= $no_po; ?>" readonly>
              </div>
            </div>
            
            <div class="col-md-4 ml-auto">
              <div class="form-group">
                <label>Tanggal Jatuh Tempo<span class="text-danger">*</span></label>
                <input type="text" name="tanggal_tempo" class="form-control" autocomplete="off" value="<?php echo date("d-m-Y", strtotime($tanggal_tempo)); ?>" readonly>
              </div>
            </div>
          </div>
        
          <div class="table">
            <!-- tabel untuk menampilkan data dari database -->
            <table class="display table table-bordered table-striped table-hover">
              <thead>
                <tr>
                  <th class="text-center">No.</th>
                  <th class="text-center">Nama Barang</th>
                  <th class="text-center">Qty</th>
                  <th class="text-center">Harga Satuan (Rp)</th>
                  <th class="text-center">Subtotal (Rp.)</th>
                  <th class="text-center">Aksi</th>
                </tr>
              </thead>
              <tbody>
                <?php
                // variabel untuk nomor urut tabel
                $no = 1;
                // sql statement untuk menampilkan data dari tabel "tbl_barang" dan tabel "tbl_satuan"
                $query = mysqli_query($mysqli, "SELECT * from tbl_detail_barang_keluar dbk
                                                LEFT JOIN tbl_barang b ON b.id_barang = dbk.id_barang
                                                WHERE dbk.id_keluar = '$id_transaksi'")
                                                or die('Ada kesalahan pada query tampil data : ' . mysqli_error($mysqli));
                // ambil data hasil query
                while ($data = mysqli_fetch_assoc($query)) { ?>
                <tr>
                  <td class="text-center"><?php echo $no++; ?></td>
                  <td><?php echo $data['nama_barang']; ?></td>
                  <td class="text-right"><?php echo $data['jumlah']; ?></td>
                  <td class="text-right"><?php echo number_format($data['harga'],0,',','.');?></td>
                  <td class="text-right"><?php echo number_format($data['harga']*$data['jumlah'],0,',','.'); ?></td>
                  <td class="text-center">
                    <div>
                      <!-- tombol detail data -->
                      <a href="modules/barang-keluar/proses_hapus_detail.php?id=<?php echo $data['id_keluar']; ?>&id_barang=<?php echo $data['id_barang']; ?>" class="btn btn-icon btn-round btn-danger btn-sm mr-md-1" data-toggle="tooltip" data-placement="top" title="Hapus">
                        <i class="fas fa-trash fa-sm"></i>
                      </a>
                      <!-- tombol ubah data -->
                      <!-- <a href="?module=form_ubah_barang&id=<?php echo $data['id_barang']; ?>" class="btn btn-icon btn-round btn-secondary btn-sm mr-md-1" data-toggle="tooltip" data-placement="top" title="Ubah">
                        <i class="fas fa-pencil-alt fa-sm"></i>
                      </a> -->
                      <!-- tombol hapus data -->
                      <!-- <a href="modules/barang/proses_hapus.php?id=<?php echo $data['id_barang']; ?>" onclick="return confirm('Anda yakin ingin menghapus data barang <?php echo $data['nama_barang']; ?>?')" class="btn btn-icon btn-round btn-danger btn-sm" data-toggle="tooltip" data-placement="top" title="Hapus"> -->
                        <!-- <i class="fas fa-trash fa-sm"></i> -->
                      </a>
                    </div>
                  <!-- </td> -->
                </tr>
                <?php } ?>
                <tr>
                  <td colspan="2">
                    <select id="data_barang" name="barang" class="form-control chosen-select" autocomplete="off" required>
                      <option value="">-- Pilih --</option>
                      <?php
                      // sql statement untuk menampilkan data dari tabel "tbl_barang"
                      $query_barang = mysqli_query($mysqli, "SELECT *,
                                      IFNULL((SELECT SUM(jumlah) FROM tbl_detail_barang_masuk dbm, tbl_barang_masuk bm WHERE dbm.id_barang = b.id_barang
                                            AND dbm.id_masuk = bm.id_transaksi AND bm.tanggal <= '$tanggal'),0) as jlh_masuk,
                                      IFNULL((SELECT SUM(jumlah) FROM tbl_detail_barang_keluar dbk, tbl_barang_keluar bk WHERE dbk.id_barang = b.id_barang
                                            AND dbk.id_keluar = bk.id_transaksi AND bk.tanggal <= '$tanggal'),0) as jlh_keluar,
                                      (SELECT jlh_masuk - jlh_keluar) as stoknow
                                      FROM tbl_barang b
                                      LEFT JOIN tbl_satuan s ON s.id_satuan = b.satuan
                                      WHERE (SELECT (IFNULL((SELECT SUM(jumlah) FROM tbl_detail_barang_masuk dbm, tbl_barang_masuk bm WHERE dbm.id_barang = b.id_barang
                                            AND dbm.id_masuk = bm.id_transaksi AND bm.tanggal <= '$tanggal'),0)) - ( IFNULL((SELECT SUM(jumlah) FROM tbl_detail_barang_keluar dbk, tbl_barang_keluar bk WHERE dbk.id_barang = b.id_barang
                                            AND dbk.id_keluar = bk.id_transaksi AND bk.tanggal <= '$tanggal'),0))) > 0
                                             ORDER BY id_barang ASC")
                                                            or die('Ada kesalahan pada query tampil data : ' . mysqli_error($mysqli));
                      // ambil data hasil query
                      while ($data_barang = mysqli_fetch_assoc($query_barang)) {
                        // tampilkan data
                        echo "<option value='$data_barang[id_barang]'>$data_barang[id_barang] - $data_barang[nama_barang]</option>";
                      }
                      ?>
                      </select>
                      <!-- <div class="invalid-feedback">Barang tidak boleh kosong.</div> -->
                  </td>
                  <td>
                  <input type="hidden" id="sisa" name="sisa">
                    <input type="text" id="jumlah" name="jumlah" class="form-control" autocomplete="off" onKeyPress="return goodchars(event,'0123456789',this)" required>
                    <div class="invalid-feedback">Jumlah tidak boleh kosong.</div>
                  </td>
                  <td>
                  <input type="hidden" id="stoknow" name="stoknow">
                    <input type="text" id="harga" name="harga" class="form-control" autocomplete="off">
                  </td>
                  <td>
                    <input type="text" id="subtotal" name="subtotal" class="form-control" autocomplete="off" readonly>
                  </td>
                  <td class="text-center">
                    <!-- tombol simpan data -->
                    <input type="submit" name="simpan" class="btn btn-icon btn-round btn-primary btn-sm mr-md-1" data-toggle="tooltip" data-placement="top" title="Tambah" value="+">
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
        
        <div class="card-action">
          <!-- tombol kembali ke halaman data barang keluar -->
          <a href="?module=barang_keluar" class="btn btn-default btn-round pl-4 pr-4">Kembali</a>
        </div>
      </form>
    </div>
  </div>

  <script type="text/javascript">
    $(document).ready(function() {
      // Menampilkan data barang dari select box ke textfield
      $('#data_barang').change(function() {
        // mengambil value dari "id_barang"
        var id_barang = $('#data_barang').val();

        $.ajax({
          type: "GET",                                  // mengirim data dengan method GET 
          url: "modules/barang-keluar/get_barang.php",  // proses get data berdasarkan "id_barang"
          data: {id_barang: id_barang},                 // data yang dikirim
          dataType: "JSON",                             // tipe data JSON
          success: function(result) {                   // ketika proses get data selesai
            // tampilkan data
            $('#stoknow').val(result.stoknow);
            $('#harga').val(result.harga);
            $('#data_satuan').html('<span class="input-group-text">' + result.nama_satuan + '</span>');
            // set focus
            $('#jumlah').focus();
          }
        });

         // mengambil data dari form entri
         var stok = $('#harga').val();
        var jumlah = $('#jumlah').val();

        var subtotal = eval(stok) * eval(jumlah);
        $('#subtotal').val(subtotal);
      });

      // menghitung sisa stok
      $('#jumlah').keyup(function() {
        // mengambil data dari form entri
        var harga = $('#harga').val();
        var jumlah = $('#jumlah').val();
        var stok = $('#stoknow').val();

        var subtotal = eval(harga) * eval(jumlah);
        $('#subtotal').val(subtotal);

        // mengecek input data
        // jika data barang belum diisi
        if (stok == "") {
          // tampilkan pesan info
          $('#pesan').html('<div class="alert alert-notify alert-info alert-dismissible fade show" role="alert"><span data-notify="icon" class="fas fa-info"></span><span data-notify="title" class="text-info">Info!</span> <span data-notify="message">Silahkan isi data barang terlebih dahulu.</span><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
          // reset input "jumlah"
          $('#jumlah').val('');
          // sisa stok kosong
          var sisa_stok = "";
        }
        // jika "jumlah" belum diisi
        else if (jumlah == "") {
          // sisa stok kosong
          var sisa_stok = "";
        }
        // jika "jumlah" diisi 0
        else if (jumlah == 0) {
          // tampilkan pesan peringatan
          $('#pesan').html('<div class="alert alert-notify alert-warning alert-dismissible fade show" role="alert"><span data-notify="icon" class="fas fa-exclamation"></span><span data-notify="title" class="text-warning">Peringatan!</span> <span data-notify="message">Jumlah keluar tidak boleh 0 (nol).</span><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
          // reset input "jumlah"
          $('#jumlah').val('');
          // sisa stok kosong
          var sisa_stok = "";
        }
        // jika "jumlah" lebih dari "stok"
        else if (eval(jumlah) > eval(stok)) {
          // tampilkan pesan peringatan
          $('#pesan').html('<div class="alert alert-notify alert-warning alert-dismissible fade show" role="alert"><span data-notify="icon" class="fas fa-exclamation"></span><span data-notify="title" class="text-warning">Peringatan!</span> <span data-notify="message">Stok tidak memenuhi, kurangi jumlah keluar.</span><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
          // reset input "jumlah"
          $('#jumlah').val('');
          // sisa stok kosong
          var sisa_stok = "";
        }
        // jika "jumlah" sudah diisi
        else {
          // hitung sisa stok
          var sisa_stok = eval(stok) - eval(jumlah);
          
        }
        // tampilkan sisa stok
        $('#sisa').val(sisa_stok);
      
      });
    });

    // menghitung total harga
    $('#harga').keyup(function() {
        // mengambil data dari form entri
        var stok = $('#harga').val();
        var jumlah = $('#jumlah').val();

        var subtotal = eval(stok) * eval(jumlah);
        $('#subtotal').val(subtotal);
      
      });
    
  </script>
<?php } ?>
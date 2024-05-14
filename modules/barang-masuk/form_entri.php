<?php
// mencegah direct access file PHP agar file PHP tidak bisa diakses secara langsung dari browser dan hanya dapat dijalankan ketika di include oleh file lain
// jika file diakses secara langsung
if (basename($_SERVER['PHP_SELF']) === basename(__FILE__)) {
  // alihkan ke halaman error 404
  header('location: 404.html');
}
// jika file di include oleh file lain, tampilkan isi file
else { ?>
  <!-- menampilkan pesan kesalahan -->
  <div id="pesan"></div>

  <div class="panel-header bg-secondary-gradient">
    <div class="page-inner py-4">
      <div class="page-header text-white">
        <!-- judul halaman -->
        <h4 class="page-title text-white"><i class="fas fa-sign-in-alt mr-2"></i> Barang Masuk</h4>
        <!-- breadcrumbs -->
        <ul class="breadcrumbs">
          <li class="nav-home"><a href="?module=dashboard"><i class="flaticon-home text-white"></i></a></li>
          <li class="separator"><i class="flaticon-right-arrow"></i></li>
          <li class="nav-item"><a href="?module=barang_masuk" class="text-white">Barang Masuk</a></li>
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
        <div class="card-title">Entri Data Barang Masuk</div>
      </div>
      <!-- form entri data -->
      <form action="modules/barang-masuk/proses_entri.php" method="post" class="needs-validation" novalidate>
        <div class="card-body">
          <div class="row">
            <div class="col-md-7">
              <div class="form-group">
                <?php
                // membuat "id_transaksi"
                // sql statement untuk menampilkan 7 digit terakhir dari "id_transaksi" pada tabel "tbl_barang_masuk"
                $query = mysqli_query($mysqli, "SELECT LEFT(id_transaksi,5) as nomor FROM tbl_barang_masuk ORDER BY id_transaksi DESC LIMIT 1")
                                                or die('Ada kesalahan pada query tampil data : ' . mysqli_error($mysqli));
                // ambil jumlah baris data hasil query
                $rows = mysqli_num_rows($query);

                // cek hasil query
                // jika "id_transaksi" sudah ada
                if ($rows <> 0) {
                  // ambil data hasil query
                  $data = mysqli_fetch_assoc($query);
                  // nomor urut "id_transaksi" yang terakhir + 1 (contoh nomor urut yang terakhir adalah 2, maka 2 + 1 = 3, dst..)
                  $nomor_urut = $data['nomor'] + 1;
                }
                // jika "id_transaksi" belum ada
                else {
                  // nomor urut "id_transaksi" = 1
                  $nomor_urut = 1;
                }
                // menambahkan karakter "TM-" diawal dan karakter "0" disebelah kiri nomor urut
                $id_transaksi =  str_pad($nomor_urut, 5, "0", STR_PAD_LEFT) . "/LSA-AEK/II/24" ;
                ?>
                <label>ID Transaksi <span class="text-danger">*</span></label>
                <!-- tampilkan "id_transaksi" -->
                <input type="text" name="id_transaksi" class="form-control" value="<?php echo $id_transaksi; ?>" readonly>
              </div>
            </div>

            <div class="col-md-5 ml-auto">
              <div class="form-group">
                <label>Tanggal <span class="text-danger">*</span></label>
                <input type="text" name="tanggal" class="form-control date-picker" autocomplete="off" value="<?php echo date("d-m-Y"); ?>" required>
                <div class="invalid-feedback">Tanggal tidak boleh kosong.</div>
              </div>
            </div>
          </div>

          <hr class="mt-3 mb-4">
                  
          <div class="row">
            <div class="col-md-12">
              <div class="form-group">
                <table width="100%" >
                  <!-- label -->
                  <tr>
                    <td>
                      <label>Barang <span class="text-danger">*</span></label>
                    </td>
                    <td width="100" style="padding-left: 50px;">
                      <label>Jumlah Masuk <span class="text-danger">*</span></label>
                    </td>
                    <td width="200" style="padding-left: 50px;">
                      <label>Harga Satuan<span class="text-danger">*</span></label>
                    </td>
                    <td width="200" style="padding-left: 50px;">
                      <label>Total Harga<span class="text-danger">*</span></label>
                    </td>
                  </tr>
                  <!-- form input -->
                  <tr>
                    <td width="365">
                      <select id="data_barang" name="barang" class="form-control chosen-select" autocomplete="off" required>
                        <option selected disabled value="">-- Pilih --</option>
                        <?php
                        // sql statement untuk menampilkan data dari tabel "tbl_barang"
                        $query_barang = mysqli_query($mysqli, "SELECT id_barang, nama_barang FROM tbl_barang ORDER BY id_barang ASC")
                                                              or die('Ada kesalahan pada query tampil data : ' . mysqli_error($mysqli));
                        // ambil data hasil query
                        while ($data_barang = mysqli_fetch_assoc($query_barang)) {
                          // tampilkan data
                          echo "<option value='$data_barang[id_barang]'>$data_barang[id_barang] - $data_barang[nama_barang]</option>";
                        }
                        ?>
                      </select>
                      <div class="invalid-feedback">Barang tidak boleh kosong.</div>
                    </td>

                    <td width="100" style="padding-left: 50px;">
                      <input type="text" id="jumlah" name="jumlah" class="form-control" autocomplete="off" onKeyPress="return goodchars(event,'0123456789',this)" required>
                      <div class="invalid-feedback">Jumlah masuk tidak boleh kosong.</div>
                    </td>

                    <td width="200" style="padding-left: 50px;">
                      <input type="text" id="harga" name="harga" class="form-control" readonly>
                    </td>
                    
                    <td width="200" style="padding-left: 50px;">
                      <input type="text" id="total" name="total" class="form-control" readonly>
                    </td>   
                  </tr>
                </table>
              </div>
            </div>
          </div>
          <!-- tombol tambah dan hapus -->
          <div class="row">
            <div class="col-md-12">
              <table width="100%">
                <tr>
                  <td align="center">
                    <div class="form-group">
                      <input type="" class="btn btn-icon btn-round btn-primary btn-sm mr-md-1" data-toggle="tooltip" data-placement="top" title="Add" value="+">
                    </div>
                  </td>
                </tr>
              </table>
            </div>
          </div>
        </div>

          <div class="table-responsive">
            <!-- tabel untuk menampilkan data dari database -->
            <table class="display table table-bordered table-striped table-hover">
              <thead>
                <tr>
                  <th class="text-center">No.</th>
                  <th class="text-center">Nama Barang</th>
                  <th class="text-center">Qty</th>
                  <th class="text-center">Harga</th>
                  <th class="text-center">Aksi</th>
                </tr>
              </thead>
            </table>
          </div>
        
        <div class="card-action">
          <!-- tombol simpan data -->
          <input type="submit" name="simpan" value="Simpan" class="btn btn-secondary btn-round pl-4 pr-4 mr-2">
          <!-- tombol kembali ke halaman data barang masuk -->
          <a href="?module=barang_masuk" class="btn btn-default btn-round pl-4 pr-4">Batal</a>
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
          url: "modules/barang-masuk/get_barang.php",   // proses get data berdasarkan "id_barang"
          data: {id_barang: id_barang},                 // data yang dikirim
          dataType: "JSON",                             // tipe data JSON
          success: function(result) {                   // ketika proses get data selesai
            // tampilkan data
            $('#data_stok').val(result.stok);
            $('#harga').val(result.harga);
            $('#data_satuan').html('<span class="input-group-text">' + result.nama_satuan + '</span>');
            // set focus
            $('#jumlah').focus();
          }
        });
      });
      // menghitung total stok
      $('#jumlah').keyup(function() {
        // mengambil data dari form entri
        var stok = $('#data_stok').val();
        var jumlah = $('#jumlah').val();

        // mengecek input data
        // jika data barang belum diisi
        if (stok == "") {
          // tampilkan pesan info
          $('#pesan').html('<div class="alert alert-notify alert-info alert-dismissible fade show" role="alert"><span data-notify="icon" class="fas fa-info"></span><span data-notify="title" class="text-info">Info!</span> <span data-notify="message">Silahkan isi data barang terlebih dahulu.</span><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
          // reset input "jumlah"
          $('#jumlah').val('');
          // total stok kosong
          var total_stok = "";
        }
        // jika "jumlah" belum diisi
        else if (jumlah == "") {
          // total stok kosong
          var total_stok = "";
        }
        // jika "jumlah" diisi 0
        else if (jumlah == 0) {
          // tampilkan pesan peringatan
          $('#pesan').html('<div class="alert alert-notify alert-warning alert-dismissible fade show" role="alert"><span data-notify="icon" class="fas fa-exclamation"></span><span data-notify="title" class="text-warning">Peringatan!</span> <span data-notify="message">Jumlah masuk tidak boleh 0 (nol).</span><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
          // reset input "jumlah"
          $('#jumlah').val('');
          // total stok kosong
          var total_stok = "";
        }
        // jika "jumlah" sudah diisi
        else {
          // hitung total stok
          var total_stok = eval(stok) + eval(jumlah);
        }

        // tampilkan total stok
        $('#total').val(total_stok);
      });
    });
  </script>
<?php } ?>
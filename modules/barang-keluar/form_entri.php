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
        <h4 class="page-title text-white"><i class="fas fa-sign-out-alt mr-2"></i> Barang Keluar</h4>
        <!-- breadcrumbs -->
        <ul class="breadcrumbs">
          <li class="nav-home"><a href="?module=dashboard"><i class="flaticon-home text-white"></i></a></li>
          <li class="separator"><i class="flaticon-right-arrow"></i></li>
          <li class="nav-item"><a href="?module=barang_keluar" class="text-white">Barang Keluar</a></li>
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
        <div class="card-title">Entri Data Barang Keluar</div>
      </div>
      <!-- form entri data -->
      <form action="modules/barang-keluar/proses_entri.php" method="post" class="needs-validation" novalidate>
        <div class="card-body">
          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <?php
                // membuat "id_transaksi"
                // sql statement untuk menampilkan 7 digit terakhir dari "id_transaksi" pada tabel "tbl_barang_keluar"
                $query = mysqli_query($mysqli, "SELECT LEFT(id_transaksi,5) as nomor FROM tbl_barang_keluar ORDER BY id_transaksi DESC LIMIT 1")
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

                // menambahkan karakter "TK-" diawal dan karakter "0" disebelah kiri nomor urut
                $id_transaksi = str_pad($nomor_urut, 5, "0", STR_PAD_LEFT) . "/LSA-AEK/II/24";
                ?>
                <label>No. Faktur <span class="text-danger">*</span></label>
                <!-- tampilkan "id_transaksi" -->
                <input type="text" id="id_transaksi" name="id_transaksi" class="form-control" readonly>
              </div>
            </div>

            <div class="col-md-6 ml-auto">
              <div class="form-group">
                <label>Tanggal Faktur<span class="text-danger">*</span></label>
                <input type="text" id="tanggal" name="tanggal" class="form-control date-picker" autocomplete="off" value="<?php echo date("d-m-Y"); ?>" required>
                <div class="invalid-feedback">Tanggal tidak boleh kosong.</div>
              </div>
            </div>
          </div>

          

          <div class="row">
            <div class="col-md-4">
              <div class="form-group">
                <label>Customer <span class="text-danger">*</span></label>
                <select id="id_customer" name="id_customer" class="form-control chosen-select" autocomplete="off" required>
                  <option selected disabled value="">-- Pilih --</option>
                  <?php
                  // sql statement untuk menampilkan data dari tabel "tbl_barang"
                  $query_cust = mysqli_query($mysqli, "SELECT * FROM tbl_customer ORDER BY nama_perusahaan ASC")
                                                        or die('Ada kesalahan pada query tampil data : ' . mysqli_error($mysqli));
                  // ambil data hasil query
                  while ($data_cust = mysqli_fetch_assoc($query_cust)) {
                    // tampilkan data
                    echo "<option value='$data_cust[id_customer]'>$data_cust[nama_perusahaan] - $data_cust[sites]</option>";
                  }
                  ?>
                  </select>
                  <div class="invalid-feedback">Customer tidak boleh kosong.</div>
              </div>
            </div>
            
            <div class="col-md-4 ml-auto">
              <div class="form-group">
                <label>No. PO <span class="text-danger">*</span></label>
                <input type="text" name="no_po" class="form-control" autocomplete="off" required>
                <div class="invalid-feedback">No. PO tidak boleh kosong.</div>
              </div>
            </div>
            
            <div class="col-md-4 ml-auto">
              <div class="form-group">
                <label>Tanggal Jatuh Tempo<span class="text-danger">*</span></label>
                <input type="text" name="tanggal_tempo" class="form-control date-picker" autocomplete="off" value="<?php echo date("d-m-Y"); ?>" required>
                <div class="invalid-feedback">Tanggal tidak boleh kosong.</div>
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col-md-12">
              <div class="form-group">
                <label>Alamat Untuk Surat Jalan<span class="text-danger">*</span></label>
                <textarea name="alamat_srt_jln" autocomplete="off" class="form-control"cols="10" rows="10" require></textarea>
                <div class="invalid-feedback">Alamat tidak boleh kosong.</div>
              </div>
            </div>
          </div>
        </div>
        
        <div class="card-action">
          <!-- tombol simpan data -->
          <input type="submit" name="simpan" value="Simpan" class="btn btn-secondary btn-round pl-4 pr-4 mr-2">
          <!-- tombol kembali ke halaman data barang keluar -->
          <a href="?module=barang_keluar" class="btn btn-default btn-round pl-4 pr-4">Batal</a>
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
            $('#data_stok').val(result.stok);
            $('#harga').val(result.harga);
            $('#data_satuan').html('<span class="input-group-text">' + result.nama_satuan + '</span>');
            // set focus
            $('#jumlah').focus();
          }
        });
      });

      $('#id_customer').change(function() {
        // mengambil value dari "id_barang"
        var id_customer = $('#id_customer').val();

        $.ajax({
          type: "GET",                                  // mengirim data dengan method GET 
          url: "modules/barang-keluar/get_customer.php",  // proses get data berdasarkan "id_barang"
          data: {id_customer: id_customer},                 // data yang dikirim
          dataType: "JSON",                             // tipe data JSON
          success: function(result) {                   // ketika proses get data selesai
            // tampilkan data
            var a = new Date();
            var tahun=a.getFullYear();
            var a=a.getMonth()+1;
            switch (a){
              case 1:bulan="I";break
              case 2:bulan="II";break
              case 3:bulan="III";break
              case 4:bulan="IV";break
              case 5:bulan="V";break
              case 6:bulan="VI";break
              case 7:bulan="VII";break
              case 8:bulan="VIII";break
              case 9:bulan="IX";break
              case 10:bulan="X";break
              case 11:bulan="XI";break
              case 12:bulan="XII"
              }

            $('#id_transaksi').val('<?php echo str_pad($nomor_urut, 5, "0", STR_PAD_LEFT); ?>/LSA-'+result.singkatan + '/' + bulan + '/' + tahun);
            // $('#harga').val(result.harga);
            // $('#data_satuan').html('<span class="input-group-text">' + result.nama_satuan + '</span>');
            // set focus
            // $('#jumlah').focus();
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
        var stok = $('#data_stok').val();
        var jumlah = $('#jumlah').val();

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
    $('#jumlah').keyup(function() {
        // mengambil data dari form entri
        var harga = $('#harga').val();
        var jumlah = $('#jumlah').val();

        // mengecek input data
        // jika data barang belum diisi
        if (harga == "") {
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
          // hitung total harga
          var total_stok = eval(harga) * eval(jumlah);
        }

        // tampilkan total harga
        $('#total').val(total_stok);
      });
    
  </script>
<?php } ?>
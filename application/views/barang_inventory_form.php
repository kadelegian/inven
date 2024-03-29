<!-- Main content -->
<section class='content'>
  <div class='row'>
    <div class='col-xs-12'>
      <div class='box'>
        <div class='box-header'>

          <h3 class='box-title'>Data Barang</h3>
          <div class='box box-primary'>
            <form action="<?php echo $action; ?>" method="post">

              <table class='table table-bordered'>
                <tr>
                  <td>Nomor <?php echo form_error('nomor') ?></td>
                  <td><input type="text" class="form-control" name="nomor" id="nomor" placeholder="Nomor" value="<?php echo $nomor; ?>" readonly />
                  </td>
                <tr>
                  <td>Nama Barang <?php echo form_error('nama_barang') ?></td>
                  <td><input type="text" class="form-control" name="nama_barang" id="nama_barang" placeholder="Nama Barang" value="<?php echo $nama_barang; ?>" />
                  </td>
                <tr>
                  <td>Tanggal Pembelian <?php echo form_error('tanggal_pembelian') ?></td>
                  <td><input type="text" class="datepicker form-control" name="tanggal_pembelian" id="tanggal_pembelian" value="<?php echo $tanggal_pembelian != null ? date_format(date_create_from_format('Y-m-d', $tanggal_pembelian), 'd/m/Y') : '' ?>" />
                  </td>
                </tr>
                <tr>
                  <td>
                    Harga Pembelian
                  </td>
                  <td><input type="text" class="form-control" id="harga_beli" name="harga_beli" value="<?= number_format($harga_beli, 0, ',', '.') ?>"></td>
                </tr>
                <tr>
                  <td>Jenis Inventori <?php echo form_error('id_jenis') ?></td>
                  <td>
                    <div class="form-row form-inline">
                      <div class="form-group col-4">
                        <select class="form-control" name="id_jenis" id="id_jenis">
                          <?php

                          display_category($jenis_inventori, '', $id_jenis);

                          function display_category($data_category, $braket, $idjenis)
                          {
                            foreach ($data_category as $category) {
                              $item = $category['id'];
                              $selected = '';
                              if ($idjenis == $category['id']) {
                                $selected = ' selected';
                              }
                              echo "<option value='" . $item . "'" . $selected . ">" . $braket . $category['jenis_inventory'] . "</option>";
                              if (!empty($category['child'])) {
                                $padd = '- ' . $braket;
                                display_category($category['child'], $padd, $idjenis);
                              }
                            }
                          }
                          ?>
                        </select>

                      </div>
                      <div class="form-group col-2">
                        <a href="<?= site_url('jenis/create') ?>" class="btn btn-success">+</a>

                      </div>

                    </div>
                  </td>
                <tr>
                  <td>Lokasi <?php echo form_error('id_lokasi') ?></td>
                  <td>
                    <div class="form-row form-inline">
                      <div class="form-group">

                        <select class="form-control" name="id_lokasi" id="id_lokasi">
                          <?php foreach ($lokasi as $l) : ?>
                            <?php if ($l->id == $id_lokasi) {
                                $selected = ' selected';
                              } else {
                                $selected = '';
                              } ?>
                            <option value="<?= $l->id ?>" <?= $selected ?>><?= $l->ruang ?></option>
                          <?php endforeach; ?>
                        </select>

                      </div>
                      <div class="form-group">
                        <a href="<?= site_url('lokasi/create') ?>" class="btn btn-success">+</a>
                      </div>

                    </div>

                  </td>
                <tr>
                  <td>Spesifikasi <?php echo form_error('spesifikasi') ?></td>
                  <td><textarea class="form-control" rows="3" name="spesifikasi" id="spesifikasi" placeholder="Spesifikasi"><?php echo $spesifikasi; ?></textarea>
                  </td>
                </tr>
                <tr>
                  <td>Status <?php echo form_error('status') ?></td>
                  <td>
                    <div class="form-check form-switch">
                      <input class="form-check-input" name="status" type="checkbox" role="switch" value="aktif" id="status" <?= ($status == 1 ? 'checked' : '') ?>>
                      <label class="form-check-label" for="status">Aktif</label>
                    </div>
                  </td>
                  <input type="hidden" name="id" value="<?php echo $id; ?>" />
                <tr>
                  <td colspan='2'><button type="submit" class="btn btn-primary"><?php echo $button ?></button>
                    <a href="<?php echo site_url('barang_inventory') ?>" class="btn btn-default">Cancel</a></td>
                </tr>

              </table>
            </form>
          </div><!-- /.box-body -->
        </div><!-- /.box -->
      </div><!-- /.col -->
    </div><!-- /.row -->
</section><!-- /.content -->
<script type="text/javascript">
  var rupiah = document.getElementById('harga_beli');
  rupiah.addEventListener('keyup', function(e) {

    rupiah.value = formatNumber(this.value);
  });

  /* Fungsi formatRupiah */
  function formatNumber(angka, prefix) {
    var number_string = angka.replace(/[^,\d]/g, '').toString(),
      split = number_string.split(','),
      sisa = split[0].length % 3,
      rupiah = split[0].substr(0, sisa),
      ribuan = split[0].substr(sisa).match(/\d{3}/gi);

    // tambahkan titik jika yang di input sudah menjadi angka ribuan
    if (ribuan) {
      separator = sisa ? '.' : '';
      rupiah += separator + ribuan.join('.');
    }

    rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
    return prefix == undefined ? rupiah : (rupiah ? rupiah : '');
  }
</script>
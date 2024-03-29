<!-- Main content -->
<section class='content'>
  <div class='row'>
    <div class='col-xs-12'>
      <div class='box'>
        <div class='box-header'>

          <h3 class='box-title'>FORM MAINTENANCE</h3>
          <div class='box box-primary'>
            <form action="<?php echo $action; ?>" method="post">
              <table class='table table-bordered'>
                <tr>
                  <td>Nama Barang <?php echo form_error('id_barang') ?></td>
                  <td>
                    <input type="text" class="form-control" readonly value="<?= $nama_barang ?>">
                    <input type="hidden" name="id_barang" id="id_barang" value="<?php echo $id_barang; ?>" />
                  </td>
                </tr>
                <tr>
                  <td>
                    Nomor Barang
                  </td>
                  <td>
                    <input type="text" readonly value="<?= $nomor ?>" class="form-control">
                  </td>
                </tr>
                <tr>
                  <td>
                    Lokasi
                  </td>
                  <td>
                    <input type="text" readonly value="<?= $lokasi ?>" class="form-control">
                  </td>
                </tr>
                <tr>
                  <td>Tanggal <?php echo form_error('tanggal') ?></td>
                  <td><input type="text" class="datepicker form-control" name="tanggal" id="tanggal" placeholder="Tanggal" value="<?php echo date_format(date_create_from_format('Y-m-d', $tanggal), 'd/m/Y') ?>" />
                  </td>
                <tr>
                  <td>Keterangan <?php echo form_error('keterangan') ?></td>
                  <td><textarea class="form-control" rows="3" name="keterangan" id="keterangan" placeholder="Keterangan"><?php echo $keterangan; ?></textarea>
                  </td>
                </tr>
                <tr>
                  <td>Next Due Date <?php echo form_error('next_due_date') ?></td>
                  <td><input type="text" class="datepicker form-control" name="next_due_date" id="next_due_date" placeholder="Next Due Date" value="<?php echo $next_due_date <> '' ? date_format(date_create_from_format('Y-m-d', $next_due_date), 'd/m/Y') : '' ?>" />
                  </td>
                  <input type="hidden" name="id" value="<?php echo $id; ?>" />
                <tr>
                  <td colspan='2'><button type="submit" class="btn btn-primary"><?php echo $button ?></button>
                    <a href="<?php echo site_url('maintenance') ?>" class="btn btn-default">Cancel</a></td>
                </tr>

              </table>
            </form>
          </div><!-- /.box-body -->
        </div><!-- /.box -->
      </div><!-- /.col -->
    </div><!-- /.row -->
</section><!-- /.content -->
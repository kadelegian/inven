<!-- Main content -->
<section class='content'>
  <div class='row'>
    <div class='col-xs-12'>
      <div class='box'>
        <div class='box-header'>

          <h3 class='box-title'>LOKASI</h3>
          <div class='box box-primary'>
            <form action="<?php echo $action; ?>" method="post">
              <table class='table table-bordered'>
                <tr>
                  <td>Ruang <?php echo form_error('ruang') ?></td>
                  <td><input type="text" class="form-control" name="ruang" id="ruang" placeholder="Ruang" value="<?php echo $ruang; ?>" />
                  </td>
                <tr>
                  <td>Nomor Lantai <?php echo form_error('nomor_lantai') ?></td>
                  <td><input type="text" class="form-control" name="nomor_lantai" id="nomor_lantai" placeholder="Nomor Lantai" value="<?php echo $nomor_lantai; ?>" />
                  </td>
                <tr>
                  <td>Prefix <?php echo form_error('prefix') ?></td>
                  <td><input type="text" class="form-control" name="prefix" id="prefix" placeholder="Prefix" value="<?php echo $prefix; ?>" />
                  </td>
                  <input type="hidden" name="id" value="<?php echo $id; ?>" />
                <tr>
                  <td colspan='2'><button type="submit" class="btn btn-primary"><?php echo $button ?></button>
                    <a href="<?php echo site_url('lokasi') ?>" class="btn btn-default">Cancel</a></td>
                </tr>

              </table>
            </form>
          </div><!-- /.box-body -->
        </div><!-- /.box -->
      </div><!-- /.col -->
    </div><!-- /.row -->
</section><!-- /.content -->
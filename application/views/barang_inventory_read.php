<!-- Main content -->


<section class='content'>
  <div class="visible-print">
    <table>
      <tr>
        <td colspan="3">
          <img class="profile-user-img img-responsive" width="100" src="<?= base_url($qrcode) ?>" alt="qrcode">
        </td>
      </tr>
      <tr>
        <td colspan="3" style="text-align: center;">
          <h5><b><?php echo $nama_barang; ?><b></h5>
        </td>
      </tr>
      <tr>
        <td>Nomor </td>
        <td>:</td>
        <td><?php echo $nomor; ?></td>
      </tr>

      <tr>
        <td>Tanggal Pembelian</td>
        <td>:</td>
        <td><?php echo date_format(date_create_from_format('Y-m-d', $tanggal_pembelian), 'd/m/Y'); ?></td>
      </tr>

    </table>
  </div>
  <div class="row hidden-print">
    <div class="col-md-3">

      <!-- Profile Image -->
      <div class="box box-primary">
        <div class="box-body box-profile">
          <img class="profile-user-img img-responsive" src="<?= base_url($qrcode) ?>" alt="">
          <h3 class="profile-username text-center"><?php echo $nama_barang; ?></h3>
          <p class="text-muted text-center"><?php echo $nomor; ?></p>
          <hr>
          <p class="text-muted text-center"><?php echo $spesifikasi; ?></p>

          <ul class="list-group list-group-unbordered">
            <li class="list-group-item">
              <b>Tanggal Pembelian</b> <a class="pull-right"><?php echo date_format(date_create_from_format('Y-m-d', $tanggal_pembelian), 'd/m/Y'); ?></a>
            </li>
            <li class="list-group-item">
              <b>Jenis</b> <a class="pull-right"><?= $jenis ?></a>
            </li>
            <li class="list-group-item">
              <b>Lokasi</b> <a class="pull-right"><?= $lokasi ?></a>
            </li>
          </ul>
          <?php if ($this->ion_auth->logged_in()) { ?>
            <a href="<?= site_url('maintenance/create/' . $id) ?>" class="btn btn-primary btn-block"><b>Maintenance</b></a>
          <?php } ?>
          </form>
        </div><!-- /.box-body -->
      </div><!-- /.box -->

      <!-- About Me Box -->
      <div class="box box-primary">
        <div class="box-header with-border">
          <h3 class="box-title">Maintenance History</h3>
        </div><!-- /.box-header -->
        <div class="box-body">
          <?php foreach ($maintenance_history as $history) : ?>
            <strong><i class="fa fa-wrench margin-r-5"></i> <?= $history->tanggal ?></strong>
            <p class="text-muted">
              <?= $history->keterangan ?>
            </p>

            <hr>
          <?php endforeach; ?>

        </div><!-- /.box-body -->
      </div><!-- /.box -->
    </div><!-- /.col -->
  </div>
</section>
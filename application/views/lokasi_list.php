<!-- Main content -->
<section class='content'>
    <div class='row'>
        <div class='col-xs-12'>
            <div class='box'>
                <div class='box-header'>
                    <h3 class='box-title'>Lokasi Barang Inventory

                </div><!-- /.box-header -->
                <div class='box-body'>
                    <div>

                        <?php echo anchor('lokasi/create/', 'Create', array('class' => 'btn btn-success')); ?>
                    </div>
                    <table class="table table-bordered" style="margin-bottom: 10px">
                        <tr>
                            <th>No</th>
                            <th>Ruang</th>
                            <th>Nomor Lantai</th>
                            <th>Prefix</th>
                            <th>Action</th>
                        </tr><?php
                                foreach ($lokasi_data as $lokasi) {
                                    ?>
                            <tr>
                                <td width="80px"><?php echo ++$start ?></td>
                                <td><?php echo $lokasi->ruang ?></td>
                                <td><?php echo $lokasi->nomor_lantai ?></td>
                                <td><?php echo $lokasi->prefix ?></td>
                                <td style="text-align:center" width="200px">
                                    <?php
                                        echo anchor(site_url('lokasi/update/' . $lokasi->id), 'Update');
                                        echo ' | ';
                                        echo anchor(site_url('lokasi/delete/' . $lokasi->id), 'Delete', 'onclick="javasciprt: return confirm(\'Are You Sure ?\')"');
                                        ?>
                                </td>
                            </tr>
                        <?php
                        }
                        ?>
                    </table>
                    <div class="row">
                        <div class="col-md-6">
                            <a href="#" class="btn btn-primary">Total Record : <?php echo $total_rows ?></a>
                        </div>
                        <div class="col-md-6 text-right">
                            <?php echo $pagination ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
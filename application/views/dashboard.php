<!-- Main content -->
<section class='content'>
    <div class='row'>
        <div class='col-xs-12'>
            <div class='box'>
                <div class='box-header'>
                    <h3 class='box-title'>Jadwal Perawatan</h3>

                </div><!-- /.box-header -->
                <div class='box-body'>
                    <?php $start = 0; ?>
                    <table class="table table-bordered" style="margin-bottom: 10px">
                        <tr>
                            <th>No</th>
                            <th>Tanggal Jadwal</th>
                            <th>Nomor Inventori</th>
                            <th>Nama Barang</th>
                            <th>Maintenance Desc.</th>
                            <th>Lokasi</th>
                            <th>Action</th>
                        </tr><?php
                                foreach ($data_maintenance as $barang_inventory) {
                                    ?>
                            <tr>
                                <td width="80px"><?php echo ++$start ?></td>
                                <td><?php echo date_format(date_create_from_format('Y-m-d', $barang_inventory->next_due_date), 'd/m/Y') ?></td>
                                <td><?php echo $barang_inventory->nomor ?></td>
                                <td><?php echo $barang_inventory->nama_barang ?></td>
                                <td><?php echo $barang_inventory->keterangan ?></td>
                                <td><?php echo $barang_inventory->ruang . ', Lantai ' . $barang_inventory->nomor_lantai ?></td>
                                <td style="text-align:center" width="200px">
                                    <a href="<?= site_url('maintenance/selesai/' . $barang_inventory->id) ?>" class="btn btn-success btn-sm" onclick="javasciprt: return confirm('Apakah Anda Yakin ?')"> Selesai</a>

                                </td>
                            </tr>
                        <?php
                        }
                        ?>
                    </table>

                </div>
            </div>
        </div>
    </div>
    <div class='row'>
        <div class='col-xs-12'>
            <div class='box'>
                <div class='box-header'>
                    <h3 class='box-title'>Daftar Perawatan Yang Sudah Berjalan</h3>

                </div><!-- /.box-header -->
                <div class='box-body'>
                    <?php $start = 0; ?>
                    <table class="table table-bordered" style="margin-bottom: 10px">
                        <tr>
                            <th>No</th>
                            <th>Tanggal</th>
                            <th>Nomor Inventori</th>
                            <th>Nama Barang</th>
                            <th>Maintenance Desc.</th>
                            <th>Lokasi</th>

                        </tr><?php
                                foreach ($list_maintenance as $list) {
                                    ?>
                            <tr>
                                <td width="80px"><?php echo ++$start ?></td>
                                <td><?php echo date_format(date_create_from_format('Y-m-d', $list->tanggal), 'd/m/Y') ?></td>
                                <td><?php echo $list->nomor ?></td>
                                <td><?php echo $list->nama_barang ?></td>
                                <td><?php echo $list->keterangan ?></td>
                                <td><?php echo $list->ruang . ', Lantai ' . $list->nomor_lantai ?></td>

                            </tr>
                        <?php
                        }
                        ?>
                    </table>

                </div>
            </div>
        </div>
    </div>
</section>
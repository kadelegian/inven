<!-- Main content -->
<section class='content'>
    <div class='row'>
        <div class='col-xs-12'>
            <div class='box'>
                <div class='box-header'>
                    <h3 class='box-title'>Daftar Barang</h3>

                </div><!-- /.box-header -->
                <div class='box-body'>

                    <div class="row" style="margin-bottom: 10px">
                        <div class="col-md-4">
                            <?php echo anchor(site_url('barang_inventory/create'), 'Create', 'class="btn btn-success"'); ?>
                        </div>
                        <div class="col-md-4 text-center">
                            <div style="margin-top: 8px" id="message">
                                <?php echo $this->session->userdata('message') <> '' ? $this->session->userdata('message') : ''; ?>
                            </div>
                        </div>
                        <div class="col-md-1 text-right">
                        </div>
                        <div class="col-md-3 text-right">
                            <form action="<?php echo site_url('barang_inventory/index'); ?>" class="form-inline" method="get">
                                <div class="input-group">
                                    <input type="text" class="form-control" name="q" value="<?php echo $q; ?>">
                                    <span class="input-group-btn">
                                        <?php
                                        if ($q <> '') {
                                            ?>
                                            <a href="<?php echo site_url('barang_inventory'); ?>" class="btn btn-default">Reset</a>
                                        <?php
                                        }
                                        ?>
                                        <button class="btn btn-primary" type="submit">Search</button>
                                    </span>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover" style="margin-bottom: 10px">
                            <tr>
                                <th>No</th>
                                <th>Nomor Inventori</th>
                                <th>Nama Barang</th>
                                <th>Tanggal Pembelian</th>
                                <th>Harga Beli</th>
                                <th>Jenis</th>
                                <th>Lokasi</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr><?php
                                    foreach ($barang_inventory_data as $barang_inventory) {
                                        ?>
                                <tr>
                                    <td width="80px"><?php echo ++$start ?></td>
                                    <td><?php echo $barang_inventory->nomor ?></td>
                                    <td><?php echo $barang_inventory->nama_barang ?></td>
                                    <td><?php echo date_format(date_create_from_format('Y-m-d', $barang_inventory->tanggal_pembelian), 'd/m/Y') ?></td>
                                    <td><?= number_format($barang_inventory->harga_beli, 0, ',', '.') ?></td>
                                    <td><?php echo $barang_inventory->jenis ?></td>
                                    <td><?php echo $barang_inventory->lokasi ?></td>
                                    <td><?php echo ($barang_inventory->status == 1 ? 'Aktif' : 'Tidak Aktif') ?></td>
                                    <td style="text-align:center" width="200px">
                                        <?php
                                            echo anchor(site_url('barang_inventory/read/' . $barang_inventory->id), 'Read');
                                            echo ' | ';
                                            echo anchor(site_url('barang_inventory/update/' . $barang_inventory->id), 'Update');
                                            echo ' | ';
                                            echo anchor(site_url('barang_inventory/delete/' . $barang_inventory->id), 'Delete', 'onclick="javasciprt: return confirm(\'Are You Sure ?\')"');
                                            ?>
                                    </td>
                                </tr>
                            <?php
                            }
                            ?>
                        </table>

                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <a href="#" class="btn btn-primary">Total Record : <?php echo $total_rows ?></a>
                            <?php echo anchor(site_url('barang_inventory/excel'), 'Excel', 'class="btn btn-primary"'); ?>
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
<section class='content'>
    <div class='row'>
        <div class='col-xs-12'>
            <div class='box'>
                <div class='box-header'>
                    <h3>DAFTAR JENIS INVENTORI</h3>
                    <div class="row" style="margin-bottom: 10px">
                        <div class="col-md-4">
                            <?php echo anchor(site_url('jenis/create'), 'Create', 'class="btn btn-success"'); ?>
                        </div>
                        <div class="col-md-4 text-center">
                            <div style="margin-top: 8px" id="message">
                                <?php echo isset($_SESSION['message'])  ? var_dump($_SESSION['message']) : ''; ?>

                            </div>
                        </div>
                        <div class="col-md-1 text-right">
                        </div>
                        <div class="col-md-3 text-right">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <?php
                            display_category($jenis_data);

                            function display_category($data_category)
                            {
                                echo '<ul>';
                                foreach ($data_category as $category) {
                                    $delbtn = anchor(site_url('jenis/delete/' . $category['id']), '<small class="text-danger"> x</small>', 'onclick="javasciprt: return confirm(\'Are You Sure ?\')"');
                                    echo "<li>";
                                    $link = site_url('jenis/update/' . $category['id']);
                                    echo "<a href='{$link}'>";
                                    echo $category['jenis_inventory'];
                                    echo "</a>";
                                    echo $delbtn;
                                    echo "</li>";
                                    if (!empty($category['child'])) {
                                        display_category($category['child']);
                                    }
                                }
                                echo '</ul>';
                            }
                            ?>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
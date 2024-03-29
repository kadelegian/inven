<!-- Main content -->
<section class='content'>
  <div class='row'>
    <div class='col-xs-12'>
      <div class='box'>
        <div class='box-header'>

          <h3 class='box-title'>JENIS</h3>
          <div class='box box-primary'>
            <form action="<?php echo $action; ?>" method="post">
              <table class='table table-bordered'>
                <tr>
                  <td>Jenis Inventory <?php echo form_error('jenis_inventory') ?></td>
                  <td><input type="text" class="form-control" name="jenis_inventory" id="jenis_inventory" placeholder="Jenis Inventory" value="<?php echo $jenis_inventory; ?>" />
                  </td>
                <tr>
                  <td>Prefix <?php echo form_error('prefix') ?></td>
                  <td><input type="text" class="form-control" name="prefix" id="prefix" placeholder="Prefix" value="<?php echo $prefix; ?>" />
                  </td>
                <tr>
                  <td>Parent <?php echo form_error('parent') ?></td>
                  <td>

                    <select name="parent" class="form-control" id="parent">
                      <option value="0"></option>

                      <?php

                      display_category($list_jenis, '', $parent);

                      function display_category($data_category, $braket, $idjenis)
                      {
                        foreach ($data_category as $category) {
                          $item = $category->id;
                          if ($idjenis == $category->id) {
                            $terpilih = ' selected';
                          } else {
                            $terpilih = '';
                          }
                          echo "<option value='" . $item . "'" . $terpilih . ">" . $braket . $category->jenis_inventory . "</option>";
                          if (!empty($category->child)) {
                            $padd = '- ' . $braket;
                            display_category($category->child, $padd, $idjenis);
                          }
                        }
                      }
                      ?>
                    </select>

                  </td>
                  <input type="hidden" name="id" value="<?php echo $id; ?>" />
                <tr>
                  <td colspan='2'><button type="submit" class="btn btn-primary"><?php echo $button ?></button>
                    <a href="<?php echo site_url('jenis') ?>" class="btn btn-default">Cancel</a></td>
                </tr>

              </table>
            </form>
          </div><!-- /.box-body -->
        </div><!-- /.box -->
      </div><!-- /.col -->
    </div><!-- /.row -->
</section><!-- /.content -->
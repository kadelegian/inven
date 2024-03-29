<!-- Main content -->
<section class='content'>
      <div class='row'>
            <div class='col-xs-12'>
                  <div class='box'>
                        <div class='box-header'>

                              <h3 class='box-title'>Group Management</h3>
                              <div class='box box-primary'>
                                    <form action="create_group" method="post">
                                          <table class='table table-bordered'>
                                                <tr>
                                                      <td>Nama Group <?php echo form_error('group_name') ?></td>
                                                      <td><input type="text" class="form-control" name="group_name" id="group_name" placeholder="Nama Group" />
                                                      </td>
                                                </tr>
                                                <tr>
                                                      <td>Deskripsi <?php echo form_error('description') ?></td>
                                                      <td><input type="text" class="form-control" name="description" id="description" placeholder="Deskripsi" />
                                                      </td>
                                                </tr>
                                                <tr>
                                                      <td colspan='2'><button type="submit" class="btn btn-primary">Simpan</button>
                                                            <a href="<?php echo site_url('auth') ?>" class="btn btn-default">Cancel</a></td>
                                                </tr>

                                          </table>
                                    </form>
                              </div><!-- /.box-body -->
                        </div><!-- /.box -->
                  </div><!-- /.col -->
            </div><!-- /.row -->
</section><!-- /.content -->
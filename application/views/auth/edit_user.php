<!-- Main content -->
<section class='content'>
      <div class='row'>
            <div class='col-xs-12'>
                  <div class='box'>
                        <div class='box-header'>

                              <h3 class='box-title'>Buat User Baru</h3>
                              <div class='box box-primary'>
                                    <?php echo form_open(uri_string()); ?>
                                    <table class='table table-bordered'>
                                          <tr>
                                                <td><?php echo lang('create_user_fname_label', 'first_name'); ?></td>
                                                <td><?php echo form_input($first_name); ?>
                                                </td>
                                          </tr>
                                          <tr>
                                                <td><?php echo lang('create_user_lname_label', 'last_name'); ?></td>
                                                <td><?php echo form_input($last_name); ?>
                                                </td>
                                          </tr>
                                          <tr>
                                                <td><?php echo lang('create_user_company_label', 'company'); ?></td>
                                                <td><?php echo form_input($company); ?>
                                                </td>
                                          </tr>

                                          <tr>
                                                <td><?php echo lang('create_user_phone_label', 'phone'); ?></td>
                                                <td><?php echo form_input($phone); ?>
                                                </td>
                                          </tr>
                                          <tr>
                                                <td><?php echo lang('create_user_password_label', 'password'); ?></td>
                                                <td><?php echo form_input($password); ?>
                                                </td>
                                          </tr>
                                          <tr>
                                                <td><?php echo lang('create_user_password_confirm_label', 'password_confirm'); ?></td>
                                                <td><?php echo form_input($password_confirm); ?>
                                                </td>
                                          </tr>
                                          <?php if ($this->ion_auth->is_admin()) : ?>
                                                <tr>
                                                      <td>User Group</td>
                                                      <td>

                                                            <?php foreach ($groups as $group) : ?>
                                                                  <label class="checkbox">
                                                                        <?php
                                                                                    $gID = $group['id'];
                                                                                    $checked = null;
                                                                                    $item = null;
                                                                                    foreach ($currentGroups as $grp) {
                                                                                          if ($gID == $grp['id']) {
                                                                                                $checked = ' checked="checked"';
                                                                                                break;
                                                                                          }
                                                                                    }
                                                                                    ?>
                                                                        <input type="checkbox" name="groups[]" value="<?php echo $group['id']; ?>" <?php echo $checked; ?>>
                                                                        <?php echo htmlspecialchars($group['name'], ENT_QUOTES, 'UTF-8'); ?>
                                                                  </label>
                                                            <?php endforeach ?>

                                                      </td>
                                                </tr>
                                          <?php endif ?>

                                          <?php echo form_hidden('id', $user->id); ?>


                                          <tr>
                                                <td colspan='2'><?php echo form_submit('submit', 'Simpan', "class='btn btn-success'"); ?>
                                                      <?php if ($this->ion_auth->is_admin()) : ?>
                                                            <a href="<?php echo site_url('auth') ?>" class="btn btn-default">Cancel</a></td>
                                          <?php else : ?>
                                                <a href="<?php echo site_url() ?>" class="btn btn-default">Cancel</a></td>
                                          <?php endif; ?>
                                          </tr>

                                    </table>
                                    <?php echo form_close(); ?>
                              </div><!-- /.box-body -->
                        </div><!-- /.box -->
                  </div><!-- /.col -->
            </div><!-- /.row -->
</section><!-- /.content -->
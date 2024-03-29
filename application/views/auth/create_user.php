<!-- Main content -->
<section class='content'>
      <div class='row'>
            <div class='col-xs-12'>
                  <div class='box'>
                        <div class='box-header'>

                              <h3 class='box-title'>Buat User Baru</h3>
                              <div class='box box-primary'>
                                    <?php echo form_open("auth/create_user"); ?>
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
                                                <td><?php echo lang('create_user_email_label', 'email'); ?></td>
                                                <td><?php echo form_input($email); ?>
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

                                          <tr>
                                                <td colspan='2'><?php echo form_submit('submit', lang('create_user_submit_btn')); ?>
                                                      <a href="<?php echo site_url('auth') ?>" class="btn btn-default">Cancel</a></td>
                                          </tr>

                                    </table>
                                    <?php echo form_close(); ?>
                              </div><!-- /.box-body -->
                        </div><!-- /.box -->
                  </div><!-- /.col -->
            </div><!-- /.row -->
</section><!-- /.content -->
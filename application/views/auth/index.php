<!-- Main content -->
<section class='content'>
	<div class='row'>
		<div class='col-xs-12'>
			<div class='box'>
				<div class='box-header'>
					<h3 class='box-title'>User Management</h3>

				</div><!-- /.box-header -->
				<div class='box-body'>

					<div class="row" style="margin-bottom: 10px">
						<div class="col-md-4">
							<?php echo anchor(site_url('auth/create_user'), 'Create User', 'class="btn btn-success"'); ?>
						</div>
						<div class="col-md-4 text-center">
							<div style="margin-top: 8px" id="message">
								<?php echo $this->session->userdata('message') <> '' ? $this->session->userdata('message') : ''; ?>
							</div>
						</div>
						<div class="col-md-1 text-right">
						</div>
						<div class="col-md-3 text-right">
							<?php echo anchor(site_url('auth/create_group'), 'Create Group', 'class="btn btn-primary"'); ?>
						</div>
					</div>
					<table class="table table-bordered" style="margin-bottom: 10px">
						<tr>
							<th><?php echo lang('index_fname_th'); ?></th>
							<th><?php echo lang('index_lname_th'); ?></th>
							<th><?php echo lang('index_email_th'); ?></th>
							<th><?php echo lang('index_groups_th'); ?></th>
							<th><?php echo lang('index_status_th'); ?></th>
							<th><?php echo lang('index_action_th'); ?></th>

						</tr>
						<?php foreach ($users as $user) : ?>
							<tr>
								<td><?php echo htmlspecialchars($user->first_name, ENT_QUOTES, 'UTF-8'); ?></td>
								<td><?php echo htmlspecialchars($user->last_name, ENT_QUOTES, 'UTF-8'); ?></td>
								<td><?php echo htmlspecialchars($user->email, ENT_QUOTES, 'UTF-8'); ?></td>
								<td>
									<?php foreach ($user->groups as $group) : ?>
										<?php echo anchor("auth/edit_group/" . $group->id, htmlspecialchars($group->name, ENT_QUOTES, 'UTF-8')); ?><br />
									<?php endforeach ?>
								</td>
								<td><?php echo ($user->active) ? anchor("auth/deactivate/" . $user->id, lang('index_active_link')) : anchor("auth/activate/" . $user->id, lang('index_inactive_link')); ?></td>
								<td><?php echo anchor("auth/edit_user/" . $user->id, 'Edit'); ?></td>
							</tr>
						<?php endforeach; ?>
					</table>

				</div>
			</div>
		</div>
	</div>
</section>
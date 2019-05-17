<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class='content-wrapper'>
	<section class='content-header'>
		<h1>Users</h1>
		<ol class='breadcrumb'>
			<li><a href='<?php echo base_url('index.php/Home'); ?>'><i class='fa fa-home'></i> Home</a></li>
			<li class='active'>Users</li>
		</ol>
	</section>
	<section class='content'>
		<div class='box'>
			<div class='box-header with-border'>
				<h3 class='box-title'>Users</h3>
			</div>
			<div class='box-body'>
				<?php if(!empty($this->session->flashdata('success'))){ ?>
				<div class='row'>
					<div class='col-lg-12 col-md-12 col-sm-12'>
						<div class='alert alert-success alert-dismissible'><i class='icon fa fa-check'></i> <?php echo $this->session->flashdata('success'); ?></div>
					</div>
				</div>
				<?php } ?>
				<?php if(!empty($this->session->flashdata('failed'))){ ?>
				<div class='row'>
					<div class='col-lg-12 col-md-12 col-sm-12'>
						<div class='alert alert-danger alert-dismissible'><i class='icon fa fa-warning'></i> <?php echo $this->session->flashdata('failed'); ?></div>
					</div>
				</div>
				<?php } ?>
				<div class='row'>
					<div class='col-lg-12 col-md-12 col-sm-12'>
						<div class='form-group'>
							<button type='button' class='btn btn-sm btn-primary btn-flat' data-toggle='modal' data-target='#tambah'>
								<i class='fa fa-plus'></i> Tambah Data Users
							</button>
						</div>
					</div>
					<div class='col-lg-12 col-md-12 col-sm-12'>
						<div>
							<table id='datatables' class='table table-bordered table-condensed table-hover table-striped small'>
								<thead>
									<tr>
										<th class='center'>ID</th>
										<th class='center'>USERNAME</th>
										<th class='center'>PASSWORD</th>
										<th class='center'>Ops.</th>
									</tr>
								</thead>
								<tbody>
									<?php foreach($tb_users as $key => $value){ ?>
									<tr>
										<input type='hidden' id='id_<?php echo $key; ?>' value='<?php echo $value->id; ?>'>
										<input type='hidden' id='username_<?php echo $key; ?>' value='<?php echo $value->username; ?>'>
										<input type='hidden' id='password_<?php echo $key; ?>' value='<?php echo $value->password; ?>'>
										<td class='center'><?php echo $value->id; ?></td>
										<td class='center'><?php echo $value->username; ?></td>
										<td class='center'>*****</td>
										<td class='center'>
											<button type='button' class='btn btn-xs btn-default btn-flat' data-toggle='modal' data-target='#detail' onclick='detail(<?php echo $key; ?>)'><i class='fa fa-eye'></i> Detail</button>
											<button type='button' class='btn btn-xs btn-primary btn-flat' data-toggle='modal' data-target='#edit' onclick='edit(<?php echo $key; ?>)'><i class='fa fa-key'></i> Reset Password</button>
											<button type='button' class='btn btn-xs btn-danger btn-flat' data-toggle='modal' data-target='#hapus' onclick='hapus(<?php echo $key; ?>)'><i class='fa fa-trash'></i> Hapus</button>
										</td>
									</tr>
									<?php } ?>
								</tbody>
							</table>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
</div>
<div class='modal fade' id='detail' tabindex='-1' role='dialog' aria-hidden='true' style='display: none;'>
	<div class='modal-dialog modal-md'>
		<div class='modal-content'>
			<div class='container-fluid'>
				<div class='modal-header'>
					<h4 class='modal-title'><i class='fa fa-eye'></i> Detail Data Users</h4>
				</div class='table-responsive'>
				<div class='modal-body'>
					<div class='table-responsive'>
						<table class='table table-bordered table-condensed table-hover table-striped'>
							<tbody>
								<tr>
									<td>ID</td>
									<td id='detail_id'></td>
								</tr>
								<tr>
									<td>USERNAME</td>
									<td id='detail_username'></td>
								</tr>
								<tr>
									<td>PASSWORD</td>
									<td id='detail_password'></td>
								</tr>
							</tbody>
						</table>
					</div>
				</div>
				<div class='modal-footer' style='text-align: center;'>
					<button type='button' class='btn btn-primary btn-sm btn-flat' data-dismiss='modal'>Tutup</button>
				</div>
			</div>
		</div>
	</div>
</div>
<div class='modal fade' id='tambah' tabindex='-1' role='dialog' aria-hidden='true' style='display: none;'>
	<div class='modal-dialog modal-md'>
		<div class='modal-content'>
			<div class='container-fluid'>
				<form action='<?php echo base_url('index.php/Tb_users/insert'); ?>' method='POST'>
				<div class='modal-header'>
					<h4 class='modal-title'><i class='fa fa-plus'></i> Tambah Data Users</h4>
				</div>
				<div class='modal-body'>
					<div class='form-group'>
						<label class='small'>Username</label>
						<input type='text' name='username' class='form-control input-sm' placeholder='Tidak boleh kosong!' required='true'>
					</div>
					<div class='form-group'>
						<label class='small'>Password</label>
						<input type='text' name='password' class='form-control input-sm' placeholder='Tidak boleh kosong!' required='true'>
					</div>
				</div>
				<div class='modal-footer'>
					<button type='button' class='btn btn-danger btn-sm btn-flat pull-left' data-dismiss='modal'><i class='fa fa-arrow-left'></i> Batal</button>
					<button type='submit' class='btn btn-primary btn-sm btn-flat pull-right'><i class='fa fa-save'></i> Simpan</button>
				</div>
				</form>
			</div>
		</div>
	</div>
</div>
<div class='modal fade' id='edit' tabindex='-1' role='dialog' aria-hidden='true' style='display: none;'>
	<div class='modal-dialog modal-md'>
		<div class='modal-content'>
			<div class='container-fluid'>
				<form action='<?php echo base_url('index.php/Tb_users/update'); ?>' method='POST'>
				<div class='modal-header'>
					<h4 class='modal-title'><i class='fa fa-edit'></i> Ubah Data Users</h4>
				</div>
				<div class='modal-body'>
					<input type='hidden' id='edit_id' name='id'>
					<div class='form-group'>
						<label class='small'>Username</label>
						<input type='text' id='edit_username' name='username' class='form-control input-sm' placeholder='Tidak boleh kosong!' required='true' readonly="true">
					</div>
					<div class='form-group'>
						<label class='small'>Password</label>
						<input type='text' id='edit_password' name='password' class='form-control input-sm' placeholder='Reset Password?' required='true'>
					</div>
				</div>
				<div class='modal-footer'>
					<button type='button' class='btn btn-danger btn-sm btn-flat pull-left' data-dismiss='modal'><i class='fa fa-arrow-left'></i> Batal</button>
					<button type='submit' class='btn btn-primary btn-sm btn-flat pull-right'><i class='fa fa-save'></i> Simpan</button>
				</div>
				</form>
			</div>
		</div>
	</div>
</div>
<div class='modal fade' id='hapus' tabindex='-1' role='dialog' aria-hidden='true' style='display: none;'>
	<div class='modal-dialog modal-sm'>
		<div class='modal-content'>
			<div class='container-fluid'>
				<form action='<?php echo base_url('index.php/Tb_users/delete'); ?>' method='POST'>
				<div class='modal-header'>
					<h4 class='modal-title'><i class='fa fa-trash'></i> Hapus Data Users</h4>
				</div>
				<div class='modal-body'>
					<input type='hidden' id='hapus_id' name='id'>
					<h4 align='center'>Apakah anda yakin ?<h4>
				</div>
				<div class='modal-footer'>
					<button type='button' class='btn btn-primary btn-sm btn-flat pull-left' data-dismiss='modal'><i class='fa fa-arrow-left'></i> Batal</button>
					<button type='submit' class='btn btn-danger btn-sm btn-flat pull-right'><i class='fa fa-trash'></i> Hapus</button>
				</div>
				</form>
			</div>
		</div>
	</div>
</div>
<script type='text/javascript'>
function detail(key){
	$('#detail_id').html($('#id_'+key).val());
	$('#detail_username').html($('#username_'+key).val());
	$('#detail_password').html('*****');
}
function edit(key){
	$('#edit_id').val($('#id_'+key).val());
	$('#edit_username').val($('#username_'+key).val());
}
function hapus(key){
	$('#hapus_id').val($('#id_'+key).val());
}
</script>

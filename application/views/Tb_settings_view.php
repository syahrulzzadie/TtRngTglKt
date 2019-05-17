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
						<div>
							<table id='datatables' class='table table-bordered table-condensed table-hover table-striped small'>
								<thead>
									<tr>
										<th class='center'>ID</th>
										<th class='center'>JUDUL HALAMAN</th>
										<th class='center'>TEMA HALAMAN</th>
										<th class='center'>Ops.</th>
									</tr>
								</thead>
								<tbody>
									<?php foreach($tb_data_settings as $key => $value){ ?>
									<tr>
										<input type='hidden' id='id_<?php echo $key; ?>' value='<?php echo $value->id; ?>'>
										<input type='hidden' id='title_<?php echo $key; ?>' value='<?php echo $value->title; ?>'>
										<input type='hidden' id='theme_<?php echo $key; ?>' value='<?php echo $value->theme; ?>'>
										<td class='center'><?php echo $value->id; ?></td>
										<td class='center'><?php echo $value->title; ?></td>
										<td class='center'><?php echo $value->theme; ?></td>
										<td class='center'>
											<button type='button' class='btn btn-xs btn-default btn-flat' data-toggle='modal' data-target='#detail' onclick='detail(<?php echo $key; ?>)'><i class='fa fa-eye'></i> Detail</button>
											<button type='button' class='btn btn-xs btn-primary btn-flat' data-toggle='modal' data-target='#edit' onclick='edit(<?php echo $key; ?>)'><i class='fa fa-edit'></i> Edit</button>
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
									<td>JUDUL HALAMAN</td>
									<td id='detail_title'></td>
								</tr>
								<tr>
									<td>TEMA HALAMAN</td>
									<td id='detail_theme'></td>
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
<div class='modal fade' id='edit' tabindex='-1' role='dialog' aria-hidden='true' style='display: none;'>
	<div class='modal-dialog modal-md'>
		<div class='modal-content'>
			<div class='container-fluid'>
				<form action='<?php echo base_url('index.php/Tb_settings/update'); ?>' method='POST'>
				<div class='modal-header'>
					<h4 class='modal-title'><i class='fa fa-edit'></i> Ubah Data Users</h4>
				</div>
				<div class='modal-body'>
					<input type='hidden' id='edit_id' name='id'>
					<div class='form-group'>
						<label class='small'>Judul Halaman</label>
						<input type='text' id='edit_title' name='title' class='form-control input-sm' placeholder='Tidak boleh kosong!' required='true'>
					</div>
					<div class='form-group'>
						<label class='small'>Tema Halaman</label>
						<select id='edit_theme' name='theme' class='form-control input-sm' required='true'>
							<?php foreach($skins as $value){ ?>
							<option value="<?= $value ?>"><?= $value ?></option>
							<?php } ?>
						</select>
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
<script type='text/javascript'>
function detail(key){
	$('#detail_id').html($('#id_'+key).val());
	$('#detail_title').html($('#title_'+key).val());
	$('#detail_theme').html($('#theme_'+key).val());
}
function edit(key){
	$('#edit_id').val($('#id_'+key).val());
	$('#edit_title').val($('#title_'+key).val());
	$('#edit_theme').val($('#theme_'+key).val());
}
</script>

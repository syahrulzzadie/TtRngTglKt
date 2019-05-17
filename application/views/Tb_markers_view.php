<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class='content-wrapper'>
	<section class='content-header'>
		<h1>Markers</h1>
		<ol class='breadcrumb'>
			<li><a href='<?php echo base_url('index.php/Home'); ?>'><i class='fa fa-home'></i> Home</a></li>
			<li class='active'>Markers</li>
		</ol>
	</section>
	<section class='content'>
		<div class='box'>
			<div id='map' style="height: 400px;"></div>
		</div>
		<div class='box'>
			<div class='box-header with-border'>
				<h3 class='box-title'>Markers</h3>
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
							<button type='button' id="btn_tambah" class='btn btn-sm btn-primary btn-flat' data-toggle='modal' data-target='#tambah_manual'>
								<i class='fa fa-plus'></i> Tambah Marker Manual
							</button>
						</div>
					</div>
					<div class='col-lg-12 col-md-12 col-sm-12'>
						<div>
							<table id='datatables' class='table table-bordered table-condensed table-hover table-striped small'>
								<thead>
									<tr>
										<th class='text-center'>ID</th>
										<th class='text-center'>KETERANGAN</th>
										<th class='text-center'>LINK CCTV</th>
										<th class='text-center'>LATITUDE</th>
										<th class='text-center'>LONGITUDE</th>
										<th class='text-center'>SHOW</th>
										<th class='text-center'>Ops.</th>
									</tr>
								</thead>
								<tbody>
									<?php foreach($markers as $key => $value){ ?>
									<tr>
										<input type='hidden' id='id_<?php echo $key; ?>' value='<?php echo $value->id; ?>'>
										<input type='hidden' id='id_kategori_<?php echo $key; ?>' value='<?php echo $value->id_kategori; ?>'>
										<input type='hidden' id='keterangan_<?php echo $key; ?>' value='<?php echo $value->keterangan; ?>'>
										<input type='hidden' id='link_cctv_<?php echo $key; ?>' value='<?php echo $value->link_cctv; ?>'>
										<input type='hidden' id='latitude_<?php echo $key; ?>' value='<?php echo $value->latitude; ?>'>
										<input type='hidden' id='longitude_<?php echo $key; ?>' value='<?php echo $value->longitude; ?>'>
										<input type='hidden' id='del_flags_<?php echo $key; ?>' value='<?php echo $value->del_flags; ?>'>
										<td class='text-center'><?php echo $value->id; ?></td>
										<td class='text-center'><?php echo $value->keterangan; ?></td>
										<td class='text-center'><?php echo !empty($value->link_cctv) ? $value->link_cctv : '-'; ?></td>
										<td class='text-center'><?php echo $value->latitude; ?></td>
										<td class='text-center'><?php echo $value->longitude; ?></td>
										<th class='text-center'>
											<form action="<?php echo base_url('index.php/Tb_markers/is_show'); ?>" method="POST">
												<input type="hidden" name="id" value="<?php echo $value->id; ?>">
												<input type="checkbox" name="isShow" onchange="this.form.submit()" <?php echo $value->show_flags; ?> />
											</form>
										</th>
										<td class='text-center'>
											<button type='button' class='btn btn-xs btn-default btn-flat' data-toggle='modal' data-target='#detail' onclick='detail(<?php echo $key; ?>)'><i class='fa fa-eye'></i> Detail</button>
											<button type='button' class='btn btn-xs btn-primary btn-flat' data-toggle='modal' data-target='#edit' onclick='edit(<?php echo $key; ?>)'><i class='fa fa-edit'></i> Edit</button>
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
					<h4 class='modal-title'><i class='fa fa-eye'></i> Detail Data Markers</h4>
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
									<td>KETERANGAN</td>
									<td id='detail_keterangan'></td>
								</tr>
								<tr>
									<td>LINK CCTV</td>
									<td id='detail_link_cctv'></td>
								</tr>
								<tr>
									<td>LATITUDE</td>
									<td id='detail_latitude'></td>
								</tr>
								<tr>
									<td>LONGITUDE</td>
									<td id='detail_longitude'></td>
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
				<form action='<?php echo base_url('index.php/Tb_markers/insert'); ?>' method='POST'>
				<div class='modal-header'>
					<h4 class='modal-title'><i class='fa fa-plus'></i> Tambah Data Markers</h4>
				</div>
				<div class='modal-body'>
					<div class="form-group">
						<label class="small">Kategori</label>
						<select name="id_kategori" class="form-control input-sm" required="true">
							<option value="">-Pilih-</option>
							<?php foreach($tb_kategori as $value) { ?>
							<option value="<?= $value->id ?>"><?= $value->nama ?></option>
							<?php } ?>
						</select>
					</div>
					<div class='form-group'>
						<label class='small'>Keterangan</label>
						<textarea id="tambah_keterangan" name='keterangan' class='form-control input-sm' placeholder='Tidak boleh kosong!' required='true'></textarea>
					</div>
					<div class='form-group'>
						<label class='small'>Link CCTV</label>
						<input type="text" id="tambah_link_cctv" name='link_cctv' class='form-control input-sm' placeholder='Opsional'/>
					</div>
					<input type='hidden' id="tambah_latitude" name='latitude'>
					<input type='hidden' id="tambah_longitude" name='longitude'>
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
<div class='modal fade' id='tambah_manual' tabindex='-1' role='dialog' aria-hidden='true' style='display: none;'>
	<div class='modal-dialog modal-md'>
		<div class='modal-content'>
			<div class='container-fluid'>
				<form action='<?php echo base_url('index.php/Tb_markers/insert'); ?>' method='POST'>
				<div class='modal-header'>
					<h4 class='modal-title'><i class='fa fa-plus'></i> Tambah Data Markers</h4>
				</div>
				<div class='modal-body'>
					<div class="form-group">
						<label class="small">Kategori</label>
						<select name="id_kategori" class="form-control input-sm" required="true">
							<option value="">-Pilih-</option>
							<?php foreach($tb_kategori as $value) { ?>
							<option value="<?= $value->id ?>"><?= $value->nama ?></option>
							<?php } ?>
						</select>
					</div>
					<div class='form-group'>
						<label class='small'>Keterangan</label>
						<textarea id="tambah_keterangan" name='keterangan' class='form-control input-sm' placeholder='Tidak boleh kosong!' required='true'></textarea>
					</div>
					<div class='form-group'>
						<label class='small'>Link CCTV</label>
						<input type="text" id="tambah_link_cctv" name='link_cctv' class='form-control input-sm' placeholder='Opsional'/>
					</div>
					<div class='form-group'>
						<label class='small'>Latitude</label>
						<input type="text" name='latitude' class='form-control input-sm' placeholder='Tidak boleh kosong!' required="true"/>
					</div>
					<div class='form-group'>
						<label class='small'>Longitude</label>
						<input type="text" name='longitude' class='form-control input-sm' placeholder='Tidak boleh kosong!' required="true"/>
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
				<form action='<?php echo base_url('index.php/Tb_markers/update'); ?>' method='POST'>
				<div class='modal-header'>
					<h4 class='modal-title'><i class='fa fa-edit'></i> Ubah Data Markers</h4>
				</div>
				<div class='modal-body'>
					<input type='hidden' id='edit_id' name='id'>
					<div class="form-group">
						<label class="small">Kategori</label>
						<select id="edit_id_kategori" name="id_kategori" class="form-control input-sm" required="true">
							<option value="">-Pilih-</option>
							<?php foreach($tb_kategori as $value) { ?>
							<option value="<?= $value->id ?>"><?= $value->nama ?></option>
							<?php } ?>
						</select>
					</div>
					<div class='form-group'>
						<label class='small'>Keterangan</label>
						<textarea id='edit_keterangan' name='keterangan' class='form-control input-sm' placeholder='Tidak boleh kosong!' required='true'></textarea>
					</div>
					<div class='form-group'>
						<label class='small'>Link CCTV</label>
						<input type="text" id="edit_link_cctv" name='link_cctv' class='form-control input-sm' placeholder='Opsional'/>
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
				<form action='<?php echo base_url('index.php/Tb_markers/delete'); ?>' method='POST'>
				<div class='modal-header'>
					<h4 class='modal-title'><i class='fa fa-trash'></i> Hapus Data Markers</h4>
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
var map;
function addMarker(Lat, Lng, Ket) {
	var marker = new google.maps.Marker({
		position: { lat: Lat, lng: Lng },
		icon: '<?= base_url('assets/marker/marker-biru.png'); ?>',
		map: map,
	});
	marker.setMap(map);
	var infowindow = new google.maps.InfoWindow({
		content: Ket
	});
	google.maps.event.addListener(marker, "mouseover", function(event) {
		infowindow.setPosition(event.latLng);
		infowindow.open(map, marker);
	});
	google.maps.event.addListener(marker, "mouseout", function(event) {
		infowindow.close();
	});
}
function initMap() {
	map = new google.maps.Map(document.getElementById('map'), {
		center: {lat: -6.8705694, lng: 109.08222},
		zoom: 13,
		gestureHandling: 'greedy',
		fullscreenControl: false,
	});
	google.maps.event.addListener(map, 'click', function(event) {
		var marker = new google.maps.Marker({
			position: {lat: event.latLng.lat(), lng: event.latLng.lng()},
			map: map,
		});
		marker.setMap(map);
		marker.addListener('click', function(events) {
			document.getElementById('btn_tambah').click();
			document.getElementById('tambah_latitude').value = events.latLng.lat();
			document.getElementById('tambah_longitude').value = events.latLng.lng();
		});
	});
	// Show All Markers //
	<?php foreach ($markers_latlng as $key => $value) { ?>
	addMarker(<?php echo $value->latitude; ?>,<?php echo $value->longitude; ?>,'<?php echo $value->keterangan; ?>');
	<?php } ?>
}
function detail(key){
	$('#detail_id').html($('#id_'+key).val());
	$('#detail_keterangan').html($('#keterangan_'+key).val());
	$('#detail_link_cctv').html($('#link_cctv_'+key).val());
	$('#detail_latitude').html($('#latitude_'+key).val());
	$('#detail_longitude').html($('#longitude_'+key).val());
}
function edit(key){
	$('#edit_id').val($('#id_'+key).val());
	$('#edit_id_kategori').val($('#id_kategori_'+key).val());
	$('#edit_keterangan').val($('#keterangan_'+key).val());
	$('#edit_link_cctv').val($('#link_cctv_'+key).val());
	$('#edit_latitude').val($('#latitude_'+key).val());
	$('#edit_longitude').val($('#longitude_'+key).val());
	$('#edit_del_flags').val($('#del_flags_'+key).val());
}
function hapus(key){
	$('#hapus_id').val($('#id_'+key).val());
}
</script>

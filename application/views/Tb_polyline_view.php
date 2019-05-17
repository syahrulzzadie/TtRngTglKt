<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class='content-wrapper'>
	<section class='content-header'>
		<h1>Polyline</h1>
		<ol class='breadcrumb'>
			<li><a href='<?php echo base_url('index.php/Home'); ?>'><i class='fa fa-home'></i> Home</a></li>
			<li class='active'>Polyline</li>
		</ol>
	</section>
	<section class='content'>
		<div class='box'>
			<div class='box-header with-border'>
				<button type="button" class="btn btn-sm btn-success btn-flat" data-toggle='modal' data-target='#upload'>
					<i class="fa fa-upload"></i> Upload CSV
				</button>
				<button type="button" class="btn btn-sm btn-primary btn-flat" data-toggle='modal' data-target='#tambah_array'>
					<i class="fa fa-plus"></i> Tambah Manual
				</button>
				<button type="button" class="btn btn-sm btn-danger btn-flat" onclick="delPoint()">
					<i class="fa fa-undo"></i> Undo
				</button>
			</div>
			<div id='map' style="height: 400px;"></div>
		</div>
		<div class='box'>
			<div class='box-header with-border'>
				<h3 class='box-title'>Polyline</h3>
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
					<div class='col-lg-12 col-md-12 col-sm-12' style="display: none;">
						<div class='form-group'>
							<button type='button' id="btn_tambah" class='btn btn-sm btn-primary btn-flat' data-toggle='modal' data-target='#tambah'>
								<i class='fa fa-plus'></i> Tambah Data Polyline
							</button>
						</div>
					</div>
					<div class='col-lg-12 col-md-12 col-sm-12'>
						<div>
							<table id='datatables' class='table table-bordered table-condensed table-hover table-striped small'>
								<thead>
									<tr>
										<th class='text-center'>ID</th>
										<th class='text-center'>NAMA</th>
										<th class='text-center'>WARNA</th>
										<th class='text-center'>KETERANGAN</th>
										<th class='text-center'>SHOW</th>
										<th class='text-center'>Ops.</th>
									</tr>
								</thead>
								<tbody>
									<?php foreach($polyline as $key => $value){ ?>
									<tr>
										<input type='hidden' id='id_<?php echo $key; ?>' value='<?php echo $value->id; ?>'>
										<input type='hidden' id='id_kategori_<?php echo $key; ?>' value='<?php echo $value->id_kategori; ?>'>
										<input type='hidden' id='nama_<?php echo $key; ?>' value='<?php echo $value->nama; ?>'>
										<input type='hidden' id='warna_<?php echo $key; ?>' value='<?php echo $value->warna; ?>'>
										<input type='hidden' id='keterangan_<?php echo $key; ?>' value='<?php echo $value->keterangan; ?>'>
										<td class='text-center'><?php echo $value->id; ?></td>
										<td class='text-center'><?php echo $value->nama; ?></td>
										<td class='text-center' style='background-color:<?php echo $value->warna; ?>;'><?php echo $value->warna; ?></td>
										<td class='text-center'><?php echo $value->keterangan; ?></td>
										<th class='text-center'>
											<form action="<?php echo base_url('index.php/Tb_polyline/is_show'); ?>" method="POST">
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
					<h4 class='modal-title'><i class='fa fa-eye'></i> Detail Data Polyline</h4>
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
									<td>NAMA</td>
									<td id='detail_nama'></td>
								</tr>
								<tr>
									<td>WARNA</td>
									<td id='detail_warna'></td>
								</tr>
								<tr>
									<td>KETERANGAN</td>
									<td id='detail_keterangan'></td>
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
<div class='modal fade' id='upload' tabindex='-1' role='dialog' aria-hidden='true' style='display: none;'>
	<div class='modal-dialog modal-md'>
		<div class='modal-content'>
			<div class='container-fluid'>
				<form action='<?php echo base_url('index.php/Tb_polyline/upload_csv'); ?>' method='POST' enctype="multipart/form-data">
				<div class='modal-header'>
					<h4 class='modal-title'><i class='fa fa-upload'></i> Upload CSV</h4>
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
						<label class='small'>Nama</label>
						<input type='text' name='nama' class='form-control input-sm' placeholder='Tidak boleh kosong!' required='true'>
					</div>
					<div class='form-group'>
						<label class='small'>Warna</label>
						<input type="text" name='warna' class="form-control input-sm jscolor {hash:true, width:243, height:150, position:'right', borderColor:'#FFF', insetColor:'#FFF', backgroundColor:'#666'}" required='true'>
					</div>
					<div class='form-group'>
						<label class='small'>Keterangan</label>
						<textarea name='keterangan' class='form-control input-sm' placeholder='Tidak boleh kosong!' required='true'></textarea>
					</div>
					<div class='form-group'>
						<label class='small'>File CSV</label>
						<input type='file' name='file_csv' class='form-control input-sm' required='true'>
					</div>
				</div>
				<div class='modal-footer'>
					<button type='button' class='btn btn-danger btn-sm btn-flat pull-left' data-dismiss='modal'><i class='fa fa-arrow-left'></i> Batal</button>
					<button type='submit' class='btn btn-primary btn-sm btn-flat pull-right'><i class='fa fa-upload'></i> Upload</button>
				</div>
				</form>
			</div>
		</div>
	</div>
</div>
<div class='modal fade' id='tambah' tabindex='-1' role='dialog' aria-hidden='true' style='display: none;'>
	<div class='modal-dialog modal-md'>
		<div class='modal-content'>
			<div class='container-fluid'>
				<form action='<?php echo base_url('index.php/Tb_polyline/insert'); ?>' method='POST'>
				<div class='modal-header'>
					<h4 class='modal-title'><i class='fa fa-plus'></i> Tambah Data Polyline</h4>
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
						<label class='small'>Nama</label>
						<input type='text' name='nama' class='form-control input-sm' placeholder='Tidak boleh kosong!' required='true'>
					</div>
					<div class='form-group'>
						<label class='small'>Warna</label>
						<input type="text" name='warna' class="form-control input-sm jscolor {hash:true, width:243, height:150, position:'right', borderColor:'#FFF', insetColor:'#FFF', backgroundColor:'#666'}" required='true'>
					</div>
					<div class='form-group'>
						<label class='small'>Keterangan</label>
						<textarea name='keterangan' class='form-control input-sm' placeholder='Tidak boleh kosong!' required='true'></textarea>
					</div>
					<input type="hidden" id="positions" name='positions'>
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
<div class='modal fade' id='tambah_array' tabindex='-1' role='dialog' aria-hidden='true' style='display: none;'>
	<div class='modal-dialog modal-md'>
		<div class='modal-content'>
			<div class='container-fluid'>
				<form action='<?php echo base_url('index.php/Tb_polyline/insert_array'); ?>' method='POST'>
				<div class='modal-header'>
					<h4 class='modal-title'><i class='fa fa-plus'></i> Tambah Data Polyline</h4>
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
						<label class='small'>Nama</label>
						<input type='text' name='nama' class='form-control input-sm' placeholder='Tidak boleh kosong!' required='true'>
					</div>
					<div class='form-group'>
						<label class='small'>Warna</label>
						<input type="text" name='warna' class="form-control input-sm jscolor {hash:true, width:243, height:150, position:'right', borderColor:'#FFF', insetColor:'#FFF', backgroundColor:'#666'}" required='true'>
					</div>
					<div class='form-group'>
						<label class='small'>Keterangan</label>
						<textarea name='keterangan' class='form-control input-sm' placeholder='Tidak boleh kosong!' required='true'></textarea>
					</div>
					<div class='form-group'>
						<label class='small'>Jenis Data Array :</label>
						<select name="jenis_array" class='form-control input-sm' required='true'>
							<option value="">-Pilih-</option>
							<option value="latlng">Latitude - Longitude</option>
							<option value="lnglat">Longitude - Latitude</option>
						</select>
					</div>
					<div class='form-group'>
						<label class='small'>Delimiter</label>
						<input type='text' name='delimiter' class='form-control input-sm' placeholder='Tidak boleh kosong!' required='true'>
					</div>
					<div class='form-group'>
						<label class='small'>Posisi (Array):</label>
						<textarea name='positions' class='form-control input-sm' placeholder='Tidak boleh kosong!' required='true'></textarea>
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
				<form action='<?php echo base_url('index.php/Tb_polyline/update'); ?>' method='POST'>
				<div class='modal-header'>
					<h4 class='modal-title'><i class='fa fa-edit'></i> Edit Data Polyline</h4>
				</div>
				<div class='modal-body'>
					<input type='hidden' id="edit_id" name='id'>
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
						<label class='small'>Nama</label>
						<input type='text' id="edit_nama" name='nama' class='form-control input-sm' placeholder='Tidak boleh kosong!' required='true'>
					</div>
					<div class='form-group'>
						<label class='small'>Warna</label>
						<input type="text" id="edit_warna" name='warna' class="form-control input-sm jscolor {hash:true, width:243, height:150, position:'right', borderColor:'#FFF', insetColor:'#FFF', backgroundColor:'#666'}" required='true'>
					</div>
					<div class='form-group'>
						<label class='small'>Keterangan</label>
						<textarea id='edit_keterangan' name='keterangan' class='form-control input-sm' placeholder='Tidak boleh kosong!' required='true'></textarea>
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
				<form action='<?php echo base_url('index.php/Tb_polyline/delete'); ?>' method='POST'>
				<div class='modal-header'>
					<h4 class='modal-title'><i class='fa fa-trash'></i> Hapus Data Polyline</h4>
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
var paths = [];
var all_polyline = [];
var all_marker = [];

function addPoint(Lat, Lng) {
	var bounds = new google.maps.LatLngBounds();
	for (var i = 0; i < paths.length; i++) {
		bounds.extend(paths[i]);
	}
	paths.push({lat: Lat, lng: Lng});
	var marker = new google.maps.Marker({
		position: {lat: Lat, lng: Lng},
		map: map,
	});
	marker.setMap(map);
	all_marker.push(marker);
	var polyline = new google.maps.Polyline({
		path: paths,
		strokeColor: 'black',
		strokeOpacity: 1,
		strokeWeight: 2,
		fillColor: 'grey',
		fillOpacity: 0.25
	});
	polyline.setMap(map);
	all_polyline.push(polyline);
	marker.addListener('click', function(event) {
		document.getElementById("btn_tambah").click();
	});
}

function delPoint() {
  if (all_polyline.length > 0) {
  	var last_polyline = all_polyline.length - 1;
  	all_polyline[last_polyline].setMap(null);
  	all_polyline.splice(last_polyline, 1);
  } else {
  	all_polyline[0].setMap(null);
  	all_polyline.splice(0, 1);
  }
  if (paths.length > 0) {
  	var last_paths = paths.length - 1;
  	paths.splice(last_paths, 1);
  } else {
  	paths.splice(0, 1);
  }
  if (all_marker.length > 0) {
  	var last_marker = all_marker.length - 1;
  	all_marker[last_marker].setMap(null);
  	all_marker.splice(last_marker, 1);
  } else {
  	all_marker[0].setMap(null);
  	all_marker.splice(0, 1);
  }
  document.getElementById('positions').value = JSON.stringify(paths);
}
function addPolyline(Path, Nama, Warna, Keterangan) {
	var polyline = new google.maps.Polyline({
		path: Path,
		strokeColor: Warna,
		strokeOpacity: 1,
		strokeWeight: 2
	});
	polyline.setMap(map);
	var infowindow = new google.maps.InfoWindow({
		content: "<b>"+Nama+"</b><br/><p>"+Keterangan+"</p>"
	});
	google.maps.event.addListener(polyline, "mousemove", function(event) {
		infowindow.setPosition(event.latLng);
		infowindow.open(map, polyline);
	});
	google.maps.event.addListener(polyline, "mouseout", function(event) {
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
		addPoint(event.latLng.lat(),event.latLng.lng());
		document.getElementById('positions').value = JSON.stringify(paths);
	});
	// Show All Polyline //
	<?php foreach ($polyline_latlng as $key => $value) { ?>
	var path_<?php echo $key; ?> = <?php echo json_encode($value->data_polyline); ?>;
	addPolyline(path_<?php echo $key; ?>,'<?php echo $value->nama; ?>','<?php echo $value->warna; ?>','<?php echo $value->keterangan; ?>');
	<?php } ?>
}

function detail(key){
	$('#detail_id').html($('#id_'+key).val());
	$('#detail_nama').html($('#nama_'+key).val());
	$('#detail_warna').html($('#warna_'+key).val());
	$('#detail_warna').css({"background-color":$('#warna_'+key).val()});
	$('#detail_keterangan').html($('#keterangan_'+key).val());
}
function edit(key){
	$('#edit_id').val($('#id_'+key).val());
	$('#edit_id_kategori').val($('#id_kategori_'+key).val());
	$('#edit_nama').val($('#nama_'+key).val());
	$('#edit_warna').val($('#warna_'+key).val());
	$('#edit_warna').css({"background-color":$('#warna_'+key).val()});
	$('#edit_keterangan').val($('#keterangan_'+key).val());
}
function hapus(key){
	$('#hapus_id').val($('#id_'+key).val());
}
</script>

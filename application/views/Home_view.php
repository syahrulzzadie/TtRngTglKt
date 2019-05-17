<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class='content-wrapper'>
	<section class='content-header'>
		<h1>Home</h1>
		<ol class='breadcrumb'>
			<li class='active'><i class='fa fa-home'></i> Home</li>
		</ol>
	</section>
	<section class='content-header'>
		<div class="row">
			<?php foreach($total_data as $value){ ?>
			<div class="col-lg-4 col-md-4 col-sm-12">
				<div class="small-box bg-<?php echo str_replace(array('skin-','-light'),'',$tb_settings->theme); ?>">
					<div class="inner">
					 	<h3><?php echo $value['total']; ?></h3>
					 	<p><?php echo $value['data']; ?></p>
					</div>
					<div class="icon">
						<i class="fa fa-database"></i>
					</div>
				</div>
			</div>
			<?php } ?>
		</div>
		<div class="box">
			<div id="map" style="height: 400px;"></div>
		</div>
	</section>
</div>
<script type="text/javascript">
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
function addPolygon(Path, Nama, Warna, Keterangan) {
	var bounds = new google.maps.LatLngBounds();
	for (var i = 0; i < Path.length; i++) {
		bounds.extend(Path[i]);
	}
	var polygon = new google.maps.Polygon({
		path: Path,
		strokeColor: "#222",
		strokeOpacity: 1,
		strokeWeight: 2,
		fillColor: Warna,
		fillOpacity: 0.5
	});
	polygon.setMap(map);
	var infowindow = new google.maps.InfoWindow({
		content: "<b>"+Nama+"</b><br/><p>"+Keterangan+"</p>"
	});
	google.maps.event.addListener(polygon, "click", function(event) {
		infowindow.setPosition(bounds.getCenter());
		infowindow.open(map, polygon);
		setTimeout(() => {
			infowindow.close();
		}, 4000);
	});
	// google.maps.event.addListener(polygon, "mouseout", function(event) {
	// 	infowindow.close();
	// });
}
function addPolyline(Path, Nama, Warna, Keterangan) {
	var bounds = new google.maps.LatLngBounds();
	for (var i = 0; i < Path.length; i++) {
		bounds.extend(Path[i]);
	}
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
	google.maps.event.addListener(polyline, "mouseover", function(event) {
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
	// Show All Markers //
	<?php foreach ($markers as $key => $value) { ?>
	addMarker(<?php echo $value->latitude; ?>,<?php echo $value->longitude; ?>,'<?php echo $value->keterangan; ?>');
	<?php } ?>
	// Show All Polygon //
	<?php foreach ($polygon as $key => $value) { ?>
	var path_<?php echo $key; ?> = <?php echo json_encode($value->data_polygon); ?>;
	addPolygon(path_<?php echo $key; ?>,'<?php echo $value->nama; ?>','<?php echo $value->warna; ?>','<?php echo $value->keterangan; ?>');
	<?php } ?>
	// Show All Polyline //
	<?php foreach ($polyline as $key => $value) { ?>
	var path_<?php echo $key; ?> = <?php echo json_encode($value->data_polyline); ?>;
	addPolyline(path_<?php echo $key; ?>,'<?php echo $value->nama; ?>','<?php echo $value->warna; ?>','<?php echo $value->keterangan; ?>');
	<?php } ?>
}
</script>
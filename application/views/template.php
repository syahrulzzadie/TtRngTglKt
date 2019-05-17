<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<!DOCTYPE html>
<html>
<head>
	<meta charset='utf-8'>
	<meta http-equiv='X-UA-Compatible' content='IE=edge'>
	<meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
	<title><?php echo $tb_settings->title; ?></title>
	<link rel="icon" type="image/png" sizes="32x32" href="<?= base_url('assets/favicon/favicon-32x32.png') ?>">
	<link rel="icon" type="image/png" sizes="96x96" href="<?= base_url('assets/favicon/favicon-96x96.png') ?>">
	<link rel="icon" type="image/png" sizes="16x16" href="<?= base_url('assets/favicon/favicon-16x16.png') ?>">
	<link rel='stylesheet' href='<?php echo base_url('assets/bootstrap/css/bootstrap.min.css'); ?>'>
	<link rel='stylesheet' href='<?php echo base_url('assets/font-awesome/css/font-awesome.min.css'); ?>'>
	<link rel='stylesheet' href='<?php echo base_url('assets/admin-lte/css/admin-lte.min.css'); ?>'>
	<link rel='stylesheet' href='<?php echo base_url('assets/admin-lte/css/skins.min.css'); ?>'>
	<link rel='stylesheet' href='<?php echo base_url('assets/datatables/dataTables.bootstrap.min.css'); ?>'>
	<link rel='stylesheet' href='<?php echo base_url('assets/datepicker/datepicker3.css'); ?>'>
	<style type='text/css'> .dataTables_filter, .dataTables_paginate { float: right !important; } </style>
	<script type='text/javascript' src='<?php echo base_url('assets/jquery/jquery-2.2.3.min.js'); ?>'></script>
	<script type='text/javascript' src='<?php echo base_url('assets/bootstrap/js/bootstrap.min.js'); ?>'></script>
	<script type='text/javascript' src='<?php echo base_url('assets/admin-lte/js/admin-lte.min.js'); ?>'></script>
	<script type='text/javascript' src='<?php echo base_url('assets/datatables/jquery.dataTables.min.js'); ?>'></script>
	<script type='text/javascript' src='<?php echo base_url('assets/datatables/dataTables.bootstrap.min.js'); ?>'></script>
	<script type='text/javascript' src='<?php echo base_url('assets/input-mask/jquery.inputmask.js'); ?>'></script>
	<script type='text/javascript' src='<?php echo base_url('assets/input-mask/jquery.inputmask.date.extensions.js'); ?>'></script>
	<script type='text/javascript' src='<?php echo base_url('assets/input-mask/jquery.inputmask.extensions.js'); ?>'></script>
	<script type='text/javascript' src='<?php echo base_url('assets/datepicker/bootstrap-datepicker.js'); ?>'></script>
	<script type='text/javascript' src='<?php echo base_url('assets/jscolor/jscolor.js'); ?>'></script>
	<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyC_PQoMY6yOgJZ-Sp2nxFXYsj84Rm2yFus" async defer></script>
	<script type='text/javascript'>
	function initMap(){}
	window.onload = function() {
		$('#datatables').DataTable({width:'100%',order:[[0,"desc"]]});
		$('.datetime-mask').inputmask('datetime');
		$('.date-picker').datepicker({autoclose: true});

		initMap();
		$(".alert").click(function() {
			$(this).hide();
		});
	}
	</script>
</head>
<body class='hold-transition <?php echo $tb_settings->theme; ?> sidebar-mini'>
	<div class='wrapper'>
		<header class='main-header'>
			<a href='<?php echo base_url(); ?>' class='logo'>
				<span class='logo-mini'><i class='fa fa-home'></i></span>
				<span class='logo-lg'><?php echo substr($tb_settings->title, 0, 14); ?></span>
			</a>
			<nav class='navbar navbar-static-top'>
				<a class='sidebar-toggle' data-toggle='offcanvas' role='button'>
					<span class='sr-only'>Toggle navigation</span>
					<span class='icon-bar'></span>
					<span class='icon-bar'></span>
					<span class='icon-bar'></span>
				</a>
			</nav>
		</header>
		<aside class='main-sidebar'>
			<section class='sidebar' style='height: auto;'>
				<ul class='sidebar-menu'>
					<li class='header'>MAIN NAVIGATION</li>
					<li><a href='<?php echo base_url('index.php/Tb_users'); ?>'><i class='fa fa-users'></i> <span>USERS</span></a></li>
					<li><a href='<?php echo base_url('index.php/Tb_kategori'); ?>'><i class='fa fa-list'></i> <span>KATEGORI</span></a></li>
					<li><a href='<?php echo base_url('index.php/Tb_markers'); ?>'><i class='fa fa-map-marker'></i> <span>MARKERS</span></a></li>
					<li><a href='<?php echo base_url('index.php/Tb_polygon'); ?>'><i class='fa fa-map'></i> <span>POLYGON</span></a></li>
					<li><a href='<?php echo base_url('index.php/Tb_polyline'); ?>'><i class='fa fa-map-o'></i> <span>POLYLINE</span></a></li>
					<li><a href='<?php echo base_url('index.php/Tb_settings'); ?>'><i class='fa fa-gear'></i> <span>SETTINGS</span></a></li>
					<li><a href='<?php echo base_url('index.php/Home/logout'); ?>'><i class='fa fa-power-off'></i> <span>LOGOUT</span></a></li>
				</ul>
			</section>
		</aside>
		<?php $this->load->view($page_view); ?>
	</div>
</body>
</html>

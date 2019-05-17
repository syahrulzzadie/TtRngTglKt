<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>LOGIN <?php echo strtoupper($tb_settings->title); ?></title>
  <link rel="icon" type="image/png" sizes="32x32" href="<?= base_url('assets/favicon/favicon-32x32.png') ?>">
  <link rel="icon" type="image/png" sizes="96x96" href="<?= base_url('assets/favicon/favicon-96x96.png') ?>">
  <link rel="icon" type="image/png" sizes="16x16" href="<?= base_url('assets/favicon/favicon-16x16.png') ?>">
  <link rel='stylesheet' href='<?php echo base_url('assets/bootstrap/css/bootstrap.min.css'); ?>'>
  <link rel='stylesheet' href='<?php echo base_url('assets/font-awesome/css/font-awesome.min.css'); ?>'>
  <link rel='stylesheet' href='<?php echo base_url('assets/admin-lte/css/admin-lte.min.css'); ?>'>
  <link rel='stylesheet' href='<?php echo base_url('assets/admin-lte/css/skins.min.css'); ?>'>
</head>
<body class="hold-transition login-page">
<div class="login-box">
  <div class="login-logo">
    <a><b><?php echo $tb_settings->title; ?></b></a>
  </div>
  <div class="login-box-body">
    <?php if($this->session->userdata('msg')){ echo '<p class="login-box-msg text-danger">'.$this->session->userdata('msg').'</p>'; } ?>
    <form action="<?php echo base_url('index.php/Login/login'); ?>" method="post">
      <div class="form-group has-feedback">
        <input type="text" name="username" class="form-control" placeholder="Username">
        <span class="fa fa-user form-control-feedback"></span>
      </div>
      <div class="form-group has-feedback">
        <input type="password" name="password" class="form-control" placeholder="Password">
        <span class="fa fa-key form-control-feedback"></span>
      </div>
      <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12">
          <button type="submit" class="btn btn-primary btn-block btn-flat">Login</button>
        </div>
      </div>
    </form>
  </div>
</div>
<script type='text/javascript' src='<?php echo base_url('assets/jquery/jquery-2.2.3.min.js'); ?>'></script>
<script type='text/javascript' src='<?php echo base_url('assets/bootstrap/js/bootstrap.min.js'); ?>'></script>
<script type='text/javascript' src='<?php echo base_url('assets/admin-lte/js/admin-lte.min.js'); ?>'></script>
</body>
</html>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
  <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">
  <title><?= $title; ?></title>

  <!-- Website Icon -->
  <link rel="icon" href="<?= base_url('template/assets/img/ico/unp.png')?>">

  <!-- General CSS Files -->
  <!-- <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous"> -->
  <link rel="stylesheet" href="<?= base_url(); ?>template/node_modules/bootstrap/dist/css/bootstrap.min.css">

  <!-- <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous"> -->
  <link rel="stylesheet" href="<?= base_url(); ?>template/node_modules/@fortawesome/fontawesome-free/css/all.min.css">

  <!-- CSS Libraries -->
  <link rel="stylesheet" href="<?=base_url('template/');?>node_modules/datatables.net-bs4/css/dataTables.bootstrap4.min.css">
  <link rel="stylesheet" href="<?=base_url('template/');?>node_modules/datatables.net-select-bs4/css/select.bootstrap4.min.css">

  <!-- Template CSS -->
  <link rel="stylesheet" href="<?=base_url('template/assets/css/style.css');?>">
  <link rel="stylesheet" href="<?=base_url('template/assets/css/components.css');?>">
  <link rel="stylesheet" href="<?=base_url('template/assets/css/custom.css');?>">

  <!-- css saya -->
  <link rel="stylesheet" href="<?=base_url('template/assets/css/mystyle.css');?>">
  <!-- akhir css saya -->

  <!-- css untuk modal -->
  <!-- <link rel="stylesheet" href="<?= base_url('template'); ?>/node_modules/prismjs/themes/prism.css"> -->

  <!-- General JS Scripts -->
  <!-- datepicker -->
  <link rel="stylesheet" href="<?= base_url(); ?>template/node_modules/bootstrap-daterangepicker/daterangepicker.css">

  <!-- <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs4/dt-1.11.3/b-2.0.1/datatables.min.css"/> -->

  <!-- <script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script> -->
  <script src="<?= base_url(); ?>template/node_modules/jquery/dist/jquery.min.js"></script>

  <style>
    .load_animation{
      width: 100%;
      height: 100%;
      position: fixed;
      text-indent: 100%;
      z-index: 100;
      opacity: 0.4;
      background: #e0e0e0 url('<?= base_url(); ?>/template/assets/img/animasi.gif') no-repeat center;
      background-size: 8%;

    }
  </style>

</head>

<body>
  <div id="app">
    <div class="main-wrapper">

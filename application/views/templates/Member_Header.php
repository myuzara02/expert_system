<!doctype html>
<html lang="en" id="home">

<head>
  <meta charset="utf-8" />
  <link rel="icon" type="image/png" href="<?= base_url('assets2'); ?>/img/Smartfix.png">
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
  <title><?= $judul; ?></title>
  <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0' name='viewport' />
  <meta name="viewport" content="width=device-width" />

  <link href="<?= base_url('assets2'); ?>/css/bootstrap.css" rel="stylesheet" />
  <link href="<?= base_url('assets2'); ?>/css/landing-page.css" rel="stylesheet" />


  <!--     Fonts and icons     -->
  <link href="<?= base_url('assets2'); ?>/css/font-awesome.min.css" rel="stylesheet">
  <link href='http://fonts.googleapis.com/css?family=Open+Sans:300italic,400,300' rel='stylesheet' type='text/css'>
  <link href="<?= base_url('assets2'); ?>/css/pe-icon-7-stroke.css" rel="stylesheet" />
</head>

<body class="landing-page landing-page2">
  <nav class="navbar  navbar-top" role="navigation">
    <div class="container">
      <!-- Brand and toggle get grouped for better mobile display -->
      <div class="navbar-header">
        <button id="menu-toggle" type="button" class="navbar-toggle" data-toggle="collapse" data-target="#example">
          <span class="sr-only">Toggle navigation</span>
          <span class="icon-bar bar1"></span>
          <span class="icon-bar bar2"></span>
          <span class="icon-bar bar3"></span>
        </button>
        <a href="#home">
          <!-- Navbar Judul Pojok Kiri -->
          <div class="logo-container">
            <div class="logo">
              <img src="<?= base_url('assets2'); ?>/img/SmartFix.png" alt="SmartFix">
            </div>
            <div class="brand">
							<h5>SmartFix</h5>
            </div>
          </div>
          <!-- End of Navbar Judul Pojok Kiri -->
        </a>
      </div>
      <!-- Collect the nav links, forms, and other content for toggling -->
      <div class="collapse navbar-collapse" id="example">
        <!-- Navbar Kanan -->
        <ul class="nav navbar-nav navbar-right text-dark">
          <li>
            <a href="<?= base_url('member/index'); ?>" class="page-scroll text-light">
              <i class="fa fa-home"></i>
              Home
            </a>
          </li>
          <!-- <li>
            <a class="page-scroll" href="#">
              <i class="fa fa-user"></i>
              <?= $user['nama_user']; ?>
            </a>
          </li> -->
          <!-- Logout Button -->
					<li>
							<a href="#" data-toggle="modal" data-target="#logoutModal">
									<i class="fa fa-sign-out"></i>
									Logout
							</a>
					</li>

					<!-- Modal Logout Confirmation -->
					<div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="logoutModalLabel" aria-hidden="true">
							<div class="modal-dialog" role="document">
									<div class="modal-content">
											<div class="modal-header">
													<h5 class="modal-title" id="logoutModalLabel">Konfirmasi Logout</h5>
													<button type="button" class="close" data-dismiss="modal" aria-label="Close">
															<span aria-hidden="true">&times;</span>
													</button>
											</div>
											<div class="modal-body">
													Apakah Anda yakin ingin keluar?
											</div>
											<div class="text-right ">
													<button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
													<button type="button" class="btn btn-danger " onclick="window.location.href='<?= base_url('auth/logout'); ?>'">Logout</button>
											</div>
									</div>
							</div>
					</div>

        </ul>
        <!-- End of Navbar Kanan -->
      </div>
      <!-- /.navbar-collapse -->
    </div>
  </nav>

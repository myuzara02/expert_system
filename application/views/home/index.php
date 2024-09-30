	<nav class="navbar navbar-transparent navbar-top" role="navigation">
		<div class="container">
			<!-- Brand and toggle get grouped for better mobile display -->
			<div class="navbar-header">
				<button id="menu-toggle" type="button" class="navbar-toggle" data-toggle="collapse" data-target="#example">
					<span class="sr-only">Toggle navigation</span>
					<span class="icon-bar bar1"></span>
					<span class="icon-bar bar2"></span>
					<span class="icon-bar bar3"></span>
				</button>
				<a href="/">
					<!-- Navbar Judul Pojok Kiri -->
					<div class="logo-container">
						<div class="logo">
							<img src="<?= base_url('assets2'); ?>/img/SmartFix.png" alt="SmartFix">
						</div>
						<div class="brand">
							<h5>Smartfix</h5>
						</div>
					</div>
					<!-- End of Navbar Judul Pojok Kiri -->
				</a>
			</div>
			<!-- Collect the nav links, forms, and other content for toggling -->
			<div class="collapse navbar-collapse" id="example">
				<!-- Navbar Kanan -->
				<ul class="nav navbar-nav navbar-right">
					<li>
						<a href="" class="page-scroll">
							<i class="fa fa-home"></i>
							Home
						</a>
					</li>
					<li>
						<a class="page-scroll" href="#about">
							<i class="fa fa-info-circle"></i>
							About Us
						</a>
					</li>
					<li>
						<a href="<?= base_url('auth'); ?>">
							<i class="fa fa-sign-in"></i>
							Login
						</a>
					</li>
				</ul>
				<!-- End of Navbar Kanan -->
			</div>
			<!-- /.navbar-collapse -->
		</div>
	</nav>
	<div class="wrapper">
		<div class="parallax filter-gradient blue" data-color="blue">
			<div class="container">
				<div class="row">
					<div class="col-md-7  hidden-xs">
						<div class="parallax-image ">
							<div>

								<img src="<?= base_url('assets2'); ?>/img/showcases/showcase-2/Samsung.avif"  />
							</div>
						</div>
					</div>
					<div class="col-md-5">
						<div class="description text-center">
							<h2>Smartfix</h2>
							<br>
							<h5>Aplikasi Untuk Diagnosa Kerusakan Smartphone Samsung </h5>
						</div>
					</div>
				</div>
			</div>
		</div>

		<section class="section section-no-padding page-scroll" id="about">
			<div class="parallax filter-gradient blue" data-color="blue">
				<div class="parallax-background">
					<img class="parallax-background-image flipped" src="<?= base_url('assets2'); ?>/img/showcases/showcase-2/SamsungLandscape.jfif">
				</div>
				<div class="info">
					<h1>About Us</h1>
					<p>Sistem Pakar ini dibangun untuk membantu para pengguna atau teknisi Smartphone Samsung dalam mendiagnosa kerusakan para pelanggan.Sistem ini memiliki 13 jenis kerusakan, berdasarkan 49 gejala yang sering dialami.
					</p>
				</div>
			</div>
		</section>

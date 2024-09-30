

<body data-spy="scroll" data-target=".site-navbar-target" data-offset="300">

  <nav class="navbar navbar-expand-lg navbar-dark ftco_navbar ftco-navbar-light site-navbar-target" id="ftco-navbar">
    <div class="container">
      <a class="navbar-brand" href="/Member"><span>SF</span>SmartFix</a>
      <button class="navbar-toggler js-fh5co-nav-toggle fh5co-nav-toggle" type="button" data-toggle="collapse" data-target="#ftco-nav" aria-controls="ftco-nav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="oi oi-menu"></span> Menu
      </button>

      <div class="collapse navbar-collapse" id="ftco-nav">
        <ul class="navbar-nav nav ml-auto">
          <li class="nav-item"><a href="<?= base_url('member/index'); ?>" class="nav-link"><span>Home</span></a></li>
          <!-- <li class="nav-item"><a href="#" class="nav-link"><span><?= $user['nama_user']; ?></span></a></li> -->
          <li class="nav-item"><a href="<?= base_url('auth'); ?>" class="nav-link"  data-toggle="modal" data-target="#logoutModal"><span>Logout</span></a></li>
        </ul>
      </div>
    </div>
  </nav>

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
  <section class="ftco-section ftco-no-pb goto-here" id="resume-section">
    <div class="container">
      <div class="row">
        <div class="col-lg">

          <div class="page three">
            <h2 class="heading">Hasil Diagnosa</h2>
            <div class="row progress-circle mb-5">
              <?php if (!empty($diagnosa)) : ?>
                <?php foreach ($diagnosa as $diag) : ?>
                  <?php
                  // Cari nama kerusakan berdasarkan id_kerusakan
                  $namaKerusakan = 'Unknown';
                  foreach ($kerusakan as $kerusakanItem) {
                    if ($kerusakanItem['id_kerusakan'] == $diag['id_kerusakan']) {
                      $namaKerusakan = $kerusakanItem['nama_kerusakan'];
                      break;
                    }
                  }
                  $persentase = $diag['hasil_probabilitas'] * 100;
                  ?>
                  <div class="col-lg-4 mb-4">
                    <div class="bg-white rounded-lg shadow p-2">
                      <h2 class="h5 text-center mb-4"><?= $namaKerusakan; ?></h2>
                      <!-- Progress bar -->
                      <div class="progress mx-auto" data-value='<?= $persentase; ?>'>
                        <span class="progress-left">
                          <span class="progress-bar border-primary"></span>
                        </span>
                        <span class="progress-right">
                          <span class="progress-bar border-primary"></span>
                        </span>
                        <div class="progress-value w-100 h-100 rounded-circle d-flex align-items-center justify-content-center">
                          <div class="h2 font-weight-bold"><?= number_format($persentase, 2); ?><sup class="small">%</sup></div>
                        </div>
                      </div>
                      <!-- END -->
                    </div>
                  </div>
                <?php endforeach; ?>
              <?php else : ?>
                <p>No data available.</p>
              <?php endif; ?>
            </div>
          </div>

          <div class="row">
            <h4>Berdasarkan Gejala-Gejala yang telah dipilih, maka Smartphone anda mengalami:</h4>
            <br>
            <?php
            // Mengambil nama-nama kerusakan dari database
            $query = "SELECT id_kerusakan, nama_kerusakan FROM tbl_kerusakan";
            $result = $this->db->query($query)->result_array();

            // Membuat array asosiatif untuk memetakan ID kerusakan ke nama kerusakan
            $kerusakan = [];
            foreach ($result as $row) {
              $kerusakan[$row['id_kerusakan']] = $row['nama_kerusakan'];
            }

            foreach ($tertinggi as $tinggi) : ?>
              <div class="col-md-12 animate-box ">
                <center>
                  <h1 class="text-center"><b>Kerusakan <?= $kerusakan[$tinggi['id_kerusakan']]; ?></b></h1>
                </center>
              </div>
            <?php endforeach; ?>
          </div>
          <br>

          <?php foreach ($detail as $det) : ?>
						<div class="row justify-content-center">
							<div class="col-md-8">
								<div class="blog-entry d-flex flex-column align-items-center text-center" >
									<div class="block-20 mb-3" style="background-image: url('<?= base_url('assets/images/kerusakan/'); ?><?= $det['gambar']; ?>');"></div>
									<div class="text">
											<h3>Solusi</h3>
											<p style="text-align: justify; text-align-last: center; color: gray;"> <?= $det['solusi']; ?></p>
									</div>
									<a href="<?= base_url('auth/logout'); ?>" onclick="return confirm('Yakin Keluar?');"  style="background-color: #3E64FF; border: none; color: white; padding: 12px 24px; text-align: center; text-decoration: none; display: inline-block; font-size: 16px; margin: 4px 2px; cursor: pointer; border-radius: 8px; margin-top:70px;">
											Kembali
									</a>
								</div>
							</div>

						</div>
					<?php endforeach; ?>
        </div>
      </div>
    </div>
  </section>
</body>

<!-- Modal Tambah -->
<div class="modal fade" id="tambahPengetahuan" tabindex="-1" role="dialog" aria-labelledby="forModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
        <h5 class="modal-title" id="apasih">Tambah Basis Pengetahuan</h5>
      </div>
      <div class="modal-body">
        <form action="<?= base_url('pengetahuan/tambah'); ?>" method="post">
          <div class="form-group">
            <input type="hidden" class="form-control" id="kode" name="kode">
          </div>
          <div class="form-group">
            <select name="kerusakan" id="kerusakan" class="form-control" required>
              <option value="">Pilih Kerusakan</option>
              <?php foreach ($kerusakan as $K) : ?>
                <option value="<?= $K['id_kerusakan']; ?>"><?= $K['kode_kerusakan']; ?> - <?= $K['nama_kerusakan']; ?></option>
              <?php endforeach; ?>
            </select>
          </div>
          <div class="form-group">
            <select name="gejala" id="gejala" class="form-control" required>
              <option value="">Pilih Gejala</option>
              <?php foreach ($gejala as $G) : ?>
                <option value="<?= $G['id_gejala']; ?>"><?= $G['kode_gejala']; ?> - <?= $G['nama_gejala']; ?></option>
              <?php endforeach; ?>
            </select>
          </div>
					<div class="form-group">
							<label for="probabilitas">Nilai Probabilitas</label>
							<input type="number" class="form-control" id="probabilitas" name="probabilitas" min="0.1" max="1" step="0.01" required>
					</div>

          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
            <button type="submit" class="btn btn-primary">Tambah</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

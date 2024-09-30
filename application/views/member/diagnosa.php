<div class="section section-features">
  <div class="container">
    <h4 class="header-text text-center">Pilih Gejala</h4>
    <div class="row">
      <div class="col-md-12">
        <?php if ($this->session->flashdata('error')): ?>
          <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <?= $this->session->flashdata('error'); ?>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
        <?php endif; ?>
      </div>
      <form id="gejalaForm" action="<?= base_url('diagnosa/hasil'); ?>" method="POST">
        <div class="boxes">
          <table class="table table-bordered">
            <?php foreach ($gejala as $g) : ?>
              <tr>
                <td>
                  <input type="checkbox" id="checkbox_<?= $g['id_gejala']; ?>" name="id_gejala[]" value="<?= $g['id_gejala']; ?>">
                </td>
                <td colspan="2" class="gejala-label" data-checkbox-id="checkbox_<?= $g['id_gejala']; ?>">
                  <?= $g['kode_gejala']; ?> | Apakah <?= $g['nama_gejala']; ?> ?
                </td>
              </tr>
            <?php endforeach; ?>
          </table>
          <div class="text-center mt-3">
            <button type="submit" class="btn btn-primary">Diagnosa</button>
          </div>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- Modal for warning -->
<div class="modal fade" id="warningModal" tabindex="-1" role="dialog" aria-labelledby="warningModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="warningModalLabel">Peringatan</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <p>Silakan pilih setidaknya satu gejala sebelum mendiagnosa.</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
      </div>
    </div>
  </div>
</div>

<script>
  document.getElementById('gejalaForm').addEventListener('submit', function(event) {
    const checkboxes = document.querySelectorAll('input[name="id_gejala[]"]');
    let checked = false;

    checkboxes.forEach(function(checkbox) {
      if (checkbox.checked) {
        checked = true;
      }
    });

    if (!checked) {
      event.preventDefault(); // Prevent form from submitting
      $('#warningModal').modal('show'); // Show the warning modal
    }
  });

  // Add event listeners to the gejala labels
  document.querySelectorAll('.gejala-label').forEach(function(label) {
    label.addEventListener('click', function() {
      const checkboxId = label.getAttribute('data-checkbox-id');
      const checkbox = document.getElementById(checkboxId);
      checkbox.checked = !checkbox.checked; // Toggle checkbox state
    });
  });
</script>

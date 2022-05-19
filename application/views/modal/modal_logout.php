<!-- Modal -->
<div class="modal fade" id="modalConfirmation" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="modalConfirmationLabel" aria-hidden="true">
  <div class="modal-dialog modal-sm modal-dialog-centered" role="document">
    <div class="modal-content">
      <form id="modalConfirmation-form" action="<?= site_url('logout') ?>" method="POST">
        <div class="modal-body">
          <div class="row">
            <div class="col py-3 text-center">
              <h4 class="mb-4">Anda yakin keluar sekarang?</h4>
              <div>
                <button type="submit" class="btn btn-sm btn-danger btnConfirmation-submit mr-2">Keluar sekarang</button>
                <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">Batal</button>
              </div>
            </div>
          </div>
        </div>
      </form>
    </div>
  </div>
</div>
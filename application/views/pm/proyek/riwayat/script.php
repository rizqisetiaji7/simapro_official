<script>
    const modal = $('#riwayatProjectModal');
    const title = $('#riwayatProjectModalLabel');
    const modalDialog = $('#riwayatProjectModal .modal-dialog');
    const modalBody = $('#riwayatProjectModal .modal-body');
    const formModal = $('#form_modal_riwayatProject');
    const btnSubmit = $('#btnSubmit-riwayatProject');
    const modalFooter = $('#riwayatProjectModal .modal-footer');

    // Year Dropdown Lists
    let start = 2000;
    let end = new Date().getFullYear() + 50;
    let currDate = new Date().getFullYear();
    let options = "";
    for(let year = start ; year <= end; year++){
      options += `<option value="${year}" ${year == currDate ? 'selected' : ''}>${year}</option>`;
    }
    $('#selectYear').append(options);


    function showRiwayatList() {
      $.ajax({
        url: `<?= site_url('pm/riwayat/tampil_riwayat_proyek') ?>`,
        method: 'POST',
        dataType: 'html',
        cache: false,
        success: function(data) {
          $('#listRiwayatProyek').html(data);
        }
      });
    }

    showRiwayatList();

    $(document).on('click', '#btn-filterData', function(e) {
      e.preventDefault();
      let blnAwal = $('#first_month').val();
      let blnAkhir = $('#last_month').val();
      let dataYear = $('#selectYear').val();

      $.ajax({
        url: `<?= site_url('pm/riwayat/filter_data') ?>`,
        method: 'POST',
        dataType: 'html',
        cache: false,
        data: {
          bulan_awal: blnAwal,
          bulan_akhir: blnAkhir,
          tahun: dataYear 
        },
        success: function(data) {
          $('#listRiwayatProyek').empty();
          $('#listRiwayatProyek').html(data);
        }
      });
    });

    modal.on('hidden.bs.modal', function() {
      title.empty();
      modalDialog.removeClass('modal-lg');
      modalBody.empty();
      modalFooter.removeClass('d-none');
      formModal.removeAttr('action');
      btnSubmit.text('Simpan');
    });
</script>
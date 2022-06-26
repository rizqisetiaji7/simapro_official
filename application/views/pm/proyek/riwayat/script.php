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


    // Detail Project Page
   function detailProject(project_id, project_code) {
      title.text('Detail Proyek');
      modalDialog.addClass('modal-xl');
      modalFooter.addClass('d-none');
      $.ajax({
         url: `<?= site_url('pm/riwayat/info_detail_proyek') ?>`,
         method: 'POST',
         dataType: 'html',
         cache: false,
         data: {
            project_id: project_id,
            project_code: project_code
         },
         beforeSend: function() {
            modalBody.html(`<p class="text-secondary mb-0">Memuat konten...</p>`);
         },
         success: function(data) {
            modalBody.empty();
            modalBody.html(data);
         }
      });
      modal.modal({
         show: true,
         backdrop: 'static'
      });
   } 

   function detail_subProject(project_id, subproject_id) {
      title.text('Detail Sub-Proyek');
      modalFooter.addClass('d-none');
      $.ajax({
         url: `<?= site_url('pm/riwayat/info_detail_subproyek') ?>`,
         method: 'POST',
         dataType: 'html',
         cache: false,
         data: {
            project_id: project_id,
            subproject_id: subproject_id
         },
         beforeSend: function() {
            modalBody.html(`<p class="text-secondary mb-0">Memuat konten...</p>`);
         },
         success: function(data) {
            modalBody.empty();
            modalBody.html(data);
         }
      });
      modal.modal({
         show: true,
         backdrop: 'static'
      });
   }

   function showPhotos(project_id, subproject_id, subproject_name) {
      title.html(`Dokumentasi Proyek: <span class="text-secondary small">${subproject_name}</span>`);
      modalDialog.addClass('modal-lg');
      modalFooter.addClass('d-none');
      $.ajax({
         url: `<?= site_url('pm/riwayat/tampil_foto') ?>`,
         method: 'POST',
         dataType: 'html',
         cache: false,
         data: {
            project_id: project_id,
            subproject_id: subproject_id
         },
         beforeSend: function() {
            modalBody.html(`<p class="text-secondary mb-0">Memuat konten...</p>`);
         },
         success: function(data) {
            modalBody.empty();
            modalBody.html(data);
         }
      });
      modal.modal({
         show: true,
         backdrop: 'static'
      });
   }

   function revisiProyek(project_id) {
      Swal.fire({
         icon: 'warning',
         html: `
            <h4>Revisi proyek?</h4>
            <p class="text-muted">Anda akan melakukan revisi terhadap proyek ini.</p>
         `,
         confirmButtonText: 'Ya, Revisi Sekarang!',
         confirmButtonColor: '#28a745',
         showCancelButton: true,
         cancelButtonText: 'Batal'
      }).then((res) => {
         if (res.isConfirmed) {
            $.ajax({
               url: `<?= site_url('pm/proyek/revisi_proyek') ?>`,
               dataType: 'json',
               method: 'POST',
               cache: false,
               data: {
                  project_id: project_id
               },
               success: function(data) {
                  console.log(data);
                  if (data.status == 'success') {
                     Swal.fire({
                        icon: 'success',
                        title: 'Berhasil',
                        text: `${data.message}`,
                        showConfirmButton: false,
                        timer: 2000,
                     }).then((result) => {
                        window.location.href = data.redirect;
                     });   
                  } else if (data.status == 'failed'){
                     Swal.fire({
                        icon: 'error',
                        title: 'Gagal',
                        text: `${data.message}`,
                        showConfirmButton: false,
                        timer: 2000,
                     }).then((result) => {
                        window.location.reload();
                     });
                  }
               }
            });
         }
      });
   }

   modal.on('hidden.bs.modal', function() {
      title.empty();
      modalDialog.removeClass('modal-lg');
      modalDialog.removeClass('modal-xl');
      modalBody.empty();
      modalFooter.removeClass('d-none');
      formModal.removeAttr('action');
      btnSubmit.text('Simpan');
   });
</script>
<?php if ($docs->num_rows() > 0) { ?>
	<div class="row data-img-projects">
		<?php foreach($docs->result() as $doc) { ?>
			<div class="col-12 col-sm-6 col-lg-3 p-2">
				<a href="<?= base_url('uploads/'.$doc->url) ?>" class="image-lists">
					<img src="<?= base_url('uploads/'.$doc->url) ?>" class="w-100 h-100" alt="<?= 'Image: '.$doc->url ?>">
				</a>
				<?php if ($project_status != 'review') { ?>
					<?php $subproject_id = $doc->subproj_ID == null ? 0 : $doc->subproj_ID; ?>
					<button class="btn btn-sm btn-danger btnDeletePhoto" data-toggle="tooltip" title="Hapus foto" onclick="delete_photo(<?= $doc->photo_id ?>, <?= $doc->proj_ID ?>, <?= $subproject_id ?>, <?= "'".$doc->url."'" ?>, <?= "'".$proj_name."'" ?>, <?= "'".$proj_type."'" ?>, <?= "'".$project_status."'" ?>)">
						<i class="fas fa-trash"></i>
					</button>
				<?php } ?>
			</div>
		<?php } ?>
	</div>
<?php } else { ?>
	<div class="text-center py-5">
		<img src="<?= base_url('assets/img/blank.png') ?>" width="120" class="mb-3">
		<h3 class="mb-1">Dokumentasi belum tersedia.</h3>
		<p class="small text-muted">Foto dokumentasi akan ditampilkan, sesuai bukti pengerjaan dilapangan.</p>
	</div>
<?php } ?>

<script>
	// Light Gallery
	lightGallery(document.querySelector('.data-img-projects'), {
	   thumbnail: true,
	   download: false,
	   share: false,
	   selector: '.image-lists',
	   plugins: [lgZoom],
	   speed: 500,
		showZoomInOutIcons: true,
		actualSize: false
	});
</script>
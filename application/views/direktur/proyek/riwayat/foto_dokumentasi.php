<?php if ($docs->num_rows() > 0) { ?>
	<div class="row data-img-subprojects">
		<?php foreach($docs->result() as $doc) { ?>
			<div class="col-12 col-sm-6 col-lg-4 p-2">
				<a href="<?= base_url('uploads/'.$doc->url) ?>" class="image-lists">
					<img src="<?= base_url('uploads/'.$doc->url) ?>" class="w-100 h-100" alt="<?= 'Image: '.$doc->url ?>">
				</a>
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
	lightGallery(document.querySelector('.data-img-subprojects'), {
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
<?php if ($docs->num_rows() > 0) { ?>
	<div class="row data-img-projects">
		<?php foreach($docs->result() as $doc) { ?>
			<div class="col-12 col-sm-6 col-lg-3 p-2">
				<a href="<?= base_url('uploads/'.$doc->url) ?>" class="image-lists">
					<img src="<?= base_url('uploads/'.$doc->url) ?>" class="w-100 h-100" alt="<?= 'Image: '.$doc->url ?>">
				</a>
				<button class="btn btn-sm btn-danger btnDeletePhoto" data-toggle="tooltip" title="Hapus foto" onclick="deleteProjectDesign(<?= $doc->photo_id ?>, <?= $project_id ?>, <?= "'".$project_name."'" ?>, <?= "'".$doc->url."'" ?>, <?= "'".$doc->photo_category."'" ?>)">
					<i class="fas fa-trash"></i>
				</button>
			</div>
		<?php } ?>
	</div>
<?php } else { ?>
	<div class="text-center py-5">
		<img src="<?= base_url('assets/img/blank.png') ?>" width="120" class="mb-3">
		<h3 class="mb-1">Foto desain bangunan belum tersedia.</h3>
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
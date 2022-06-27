<?php if ($docs->num_rows() > 0) { ?>
	<div class="row">
		<?php foreach($docs->result() as $doc) { ?>
		<div class="col-12 col-sm-6 py-2 px-2">
			<img src="<?= base_url('uploads/'.$doc->url) ?>" class="img-fluid rounded">
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
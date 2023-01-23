<div class="container">
	<div class="row my-4" id="projectLists">
	</div>
</div>

<script>
	
	$.ajax({
		url: 'https://simapro.app/api/project',
		method: 'GET',
		dataType: 'json',
		beforeSend: () => {
			$('#projectLists').html(`
				<div class="col-8 m-auto text-center">
					<p class="text-secondary">Memuat data...</p>
				</div>
			`);
		},
		success: (data) => {
			$('#projectLists').empty();
			const dataLists = data.data;
			let html = '';
			for (let i = 0; i < dataLists.length; i++) {
				html += `
					<div class="col-12 col-sm-6 col-md-4 mb-3">
						<div class="card" style="min-height: 268px;">
							<div class="card-body">
								<div style="position: relative; overflow-y: hidden; height: 140px; max-height: 140px;" class="mb-3">
									<img src="${dataLists[i].project.thumbnail}" style="width:100%; height: 100%; object-fit: cover;" alt="${dataLists[i].project.title}">
								</div>
								<h4 class="mb-1">${dataLists[i].project.title}</h4>
								<span class="d-block small text-secondary mb-3">${dataLists[i].project.company.company_name}</span>
								<div class="d-flex align-items-center">
									<img src="${dataLists[i].project.pm.pm_picture}" alt="${dataLists[i].project.pm.pm_name}" class="mr-2 rounded-circle" style="width: 28px; height: 28px; object-fit: cover;">
									<span class="d-block small mb-0">${dataLists[i].project.pm.pm_name}</span>
								</div>
							</div>
						</div>
					</div>
				`;
			}
			$('#projectLists').html(html);
		},
		error: (xhr) => {
			if (xhr.status == 404) {
				$('#projectLists').empty();
				alert(`${JSON.parse(xhr.responseText).message}`)
			}
		}
	})

</script>
<?=$this->extend('layouts\appmaster')?>


<?=$this->section('meta_title')?>
<?=(isset($meta_tit) && trim($meta_tit)!='') ? trim($meta_tit) : config('Achb')->appSiteName?>
<?=$this->endSection('meta_title')?>


<?=$this->section('meta_description')?>
<?=(isset($meta_des) && trim($meta_des)!='') ? trim($meta_des) : config('Achb')->appDescription?>
<?=$this->endSection('meta_description')?>


<?=$this->section('meta_keywords')?>
<?=(isset($meta_key) && trim($meta_key)!='') ? trim($meta_key) : config('Achb')->appKeywords?>
<?=$this->endSection('meta_keywords')?>


<?=$this->section('page_styles')?>
<link rel="stylesheet" type="text/css" href="<?=base_url('public/css/cropper.css')?>">
	<style type="text/css">
		i.fa-medal { font-size:1.6rem; color:#FFC107; }
		.fbox{border: solid 1px #E2ECED; border-radius: 15px; background: rgba(226, 236, 237, .8);}
		.num{background-color: #3DB9B0;}
		.card-j{border: solid 10px #87A2BA;}
	</style>
<?=$this->endSection('page_styles')?>


<?=$this->section('page_content')?>
	<section>
		<div class="card bg-opacity mb-5 shadow">
			<div class="card-body p-lg-4">
				
				<nav class="navbar navbar-light bg-light shadow mb-3">
					<div class="container">
						<span class="navbar-brand mb-0 h1">Registrar Club de futbol</span>
						<div>
							<a class="btn btn-secondary btn-sm" href="<?=site_url('teams')?>">Listado</a>
						</div>
					</div>
				</nav>

				<form action="<?=site_url('teams/create-csv')?>" 
					enctype="multipart/form-data"
					class="needs-validation" 
					autocomplete="off"
					novalidate="">
					<table class="table mb-3">
						<tr>
							<td>
								<a href="<?=site_url('teams/download') ?>" download>
									<img src="<?=base_url('public/img/icons/icon-csv.png')?>" class="img-fluid" width="200px" loading="lazy"/>
								</a>
							</td>
							<td>
								<p class="lead px-3">
									Para registrar el Club deportivo, descarge el formato <b>CVS</b> de registro de jugadores.<br>
									<b>Nota:</b> Diligencie todos los campos solicitados por cada jugador sin modificar ninguno de los encabezados del documento para que el registro sea exitoso.
								</p>
							</td>
						</tr>
					</table>

					<div class="alert my-3" role="alert"></div>

					<div class="row g-3">
						<div class="col-sm-6">
							<label for="country_id" class="form-label">Nombre del Club deportivo</label>
							<select id="country_id" name="country_id" class="form-select" required="">
								<option value="">Choose...</option>
								<?php foreach ($countries as $key => $country): ?>
									<option value="<?=$country['id']?>"><?=$country['country']?></option>
								<?php endforeach; ?>
							</select>
						</div>
						<div class="col-sm-6">
							<label for="team_file" class="form-label">Archivo <b>CSV</b> información del equipo</label>
							<input type="file" id="team_file" name="team_file" class="form-control" required="">
						</div>
					</div>
					<hr class="my-4">
					<button type="submit" class="w-100 btn btn-primary btn-lg">Continue to checkout</button>
				</form>
			</div>
		</div>
	</section>

	<div style="min-height: 50rem;"></div>
<?=$this->endSection('page_content')?>


<?=$this->section('page_scripts')?>
	<script type="text/javascript">

		(function () {
			'use strict'
			var forms = document.querySelectorAll('.needs-validation')

			// Loop over them and prevent submission
			Array.prototype.slice.call(forms).forEach(function (form) {
				form.addEventListener('submit', function (event) {
					event.preventDefault();
					event.stopPropagation();				
					if ( form.checkValidity() ) {

						var alert = $('.alert');
						const formData = new FormData();
                        formData.append("csrf_test_name", $("#csrf_test_name").attr("content") );
                        formData.append("country_id", $('select[name=country_id]').val());
                        formData.append("team_file", $("#team_file")[0].files[0]);
                        $.ajax( "<?=site_url('teams/create-csv')?>", {
                            method: 'POST',
                            data: formData,
                            processData: false,
                            contentType: false,
                            dataType : 'json',
                            success: function ( response ) {
                                //console.log(response);
                                if ( typeof response.message!=='undefined' && response.message!='' ) {
                                    alert.show().addClass('alert-info').text(response.message);
                                }
                            },
                            error: function () {
                                image.src = initialAvatarURL;
                                alert.show().addClass('alert-warning').text('Upload error');
                            },
                            complete: function () {
                                //progress.hide();
                            },
                        });

					}
					form.classList.add('was-validated');
				}, false)
			});
		})();
    </script>
<?=$this->endSection('page_scripts')?>
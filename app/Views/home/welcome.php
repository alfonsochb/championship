<?=$this->extend('layouts\landingpage')?>


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
	<link rel="preconnect" href="https://fonts.gstatic.com">
	<link href="https://fonts.googleapis.com/css2?family=Great+Vibes&display=swap" rel="stylesheet">
	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=Italianno&display=swap" rel="stylesheet">
	<style type="text/css">
		.text-full{ font-family: 'Italianno', cursive; }
		.text-a{color: #5B4254; }
		.text-b{color: #BB2423; }
		#logotext{ font-size: 5.5rem; }
	</style>
<?=$this->endSection('page_styles')?>


<?=$this->section('page_content')?>
	<section>
		<div class="card bg-banner mb-5 shadow">
			<div class="card-body p-lg-4">
				<div class="row flex-lg-row-reverse ">
					<div class="col-10 col-sm-8 col-lg-6">
						<div class="text-center">
							<img src="<?=base_url('public/img/jugador.png')?>" class="img-fluid"/>
							<h1 id="logotext" class="display-4 fw-bold lh-1 my-3 text-full">
								<span class="text-a">Mundial</span>
								<span class="text-b">de Futbol</span>
							</h1>
						</div>
					</div>
					<div class="col-lg-6">
						<img src="<?=base_url('public/img/logo.png')?>" class="mx-lg-auto img-fluid" style="max-height: 320px;"/>
						<h2 class="display-5 fw-bold" style="display: inline-block;">¡¡¡ Bienvenidos !!!</h2> 
						<div class="col-lg-10 fs-5 fw-bold fst-italic" style="color:#6b7b8e;">
							Sistema de información del campeonato mundial de fútbol, en este sitio Usted encontrará: <br><span id="typed"></span><span class="typed-cursor"></span>
						</div>
						<div id="typedText" style="display:none;">
							<p>Información acerca del campeonato Mundial de Fútbol <b>2022</b>^1000 <b style="color:#BB2423">Shampionship</b></p>
							<p>^2000 incluyendo partidos, resultados, estadísticas, goles, campeon, selecciones, jugadores y más datos.^1000</p>
							<p>¡Gracias por tu visita, que tengas un gran día!^2000</p>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>

	<section>
		<div class="card bg-opacity mb-5 shadow">
			<div class="card-body p-lg-4">
				<div class="row gx-5">
					<div class="col-lg-3">
						<img id="imgChange" src="<?=base_url('public/img/jugador-1.png')?>" class="img-fluid" style="max-height: 400px;" loading="lazy"/>
					</div>
					<div class="col-lg-6">
						<h1>El torneo más prestigioso del mundo.</h1>
						<p class="fs-4">En la Copa Mundial de futbol masculino, que se celebra cada cuatro años, <b>32</b> naciones que compiten entre sí por el título. Los distintos clasificatorios continentales dan paso a una fase final de lo más emocionante, que congrega a los aficionados en torno a la pasión y el amor por el deporte rey.</p>
						<p class="fs-4">Esta edición se realizará desde el 21 de noviembre al 18 de diciembre de 2022 en Catar, que consiguió los derechos de organización el 2 de diciembre de 2010</p>
					</div>
					<div class="col-lg-3">
						<img src="<?=base_url('public/img/trofeo.png')?>" class="img-fluid"/>
					</div>
				</div>

				<?php if (isset($teams) and is_array($teams) and !empty($teams) ) :?>
				<div class="text-center my-5">
					<h2 class="mb-4"><?='Aquí '.count($teams).' de los 32 equipos seleccionados';?></h2>
					<?php if ($countGroups==32) : ?>
						<div class="d-grid gap-2 col-8 mx-auto mb-5">
	                        <a href="<?=site_url('groups')?>" class="btn btn-primary">Ver la clasificación de Grupos</a>
	                    </div>
	                <?php endif; ?>

					<div class="">
						<?php foreach ($teams as $key => $info): ?>
							<a href="<?=site_url('teams/'.$info->id)?>" class="text-decoration-none">
								<div class="card mb-4 shadow d-inline-block mx-3" style="min-width: 10rem;">
									<div class="card-body">
										<img src="<?=$info->photo_flag?>" class="img-fluid" />
										<div><b><?=$info->country_name?></b></div>
									</div>
								</div>
							</a>
						<?php endforeach; ?>
					</div>
				</div>
			<?php endif; ?>

			</div>
		</div>
	</section>

	<!--<section>
		<div class="card bg-opacity mb-5 shadow" style="background: gray;">
			<div class="card-body p-lg-4">
			</div>
		</div>
	</section>-->

<?=$this->endSection('page_content')?>


<?=$this->section('page_scripts')?>
<script src="<?=base_url('public/js/typed.min.js')?>" type="text/javascript"></script>
<script type="text/javascript">
	/* Ref: https://mattboldt.com/demos/typed-js/ - https://github.com/mattboldt/typed.js/ */
	if (document.getElementById("typed")) {
		var typed = new Typed("#typed", {
			stringsElement: "#typedText",
			//strings: ['Lorem ipsun.^2000', 'Lorem ipsun dolor.^2000'],
			typeSpeed: 20, // tipo velocidad en milisegundos
			startDelay: 20, // tiempo antes de que comience a escribir en milisegundos
			backDelay: 700, // tiempo antes de retroceder en milisegundos
			backSpeed: 0, // velocidad de retroceso en milisegundos
			cursorChar: '|',
			smartBackspace: true, // solo retrocede lo que no coincide con la cadena anterior
			shuffle: false,
			loop: true
		});
	}

	/* -------- Rotador de imagenes -------- */
	let item=0;
	const images = [
		"<?=base_url('public/img/jugador-1.png')?>", 
		"<?=base_url('public/img/jugador-2.png')?>", 
		"<?=base_url('public/img/jugador-3.png')?>"
	];
	window.onload = () => setInterval(function(){
		document.getElementById("imgChange").src = images[item];
		item = (item<2) ? item + 1 : 0;		
	}, 1000);
</script>
<?=$this->endSection('page_scripts')?>
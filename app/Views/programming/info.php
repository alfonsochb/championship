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
	<style type="text/css"></style>
<?=$this->endSection('page_styles')?>


<?=$this->section('page_content')?>
	<section>
		<div class="card bg-opacity mb-5 shadow">
			<div class="card-body p-lg-4">

				<h1 class="fs-3 mb-4">Informe del campeonato Mundial de futbol</h1>
				<div class="row flex-lg-row-reverse align-items-center mb-4 g-5">
					<div class="col-10 col-sm-8 col-lg-6">
						<a id="articleImage" href="#">
							<img src="<?=base_url('public/img/gol.png')?>" class="d-block mx-lg-auto img-fluid" width="100%" alt="Principios básicos para transformar la Empresa" loading="lazy">
						</a>
					</div>
					<div class="col-lg-6">
						<div class="clearfix">
							<span class="float-end fst-italic mb-3" style="color:#98ABC7;"><?=$date_article?></span>
						</div>
						<p class="lead"><em><?=$resumen?></em></p>
					</div>
				</div>

				<?php if ( is_array($allConf) and !empty($allConf) ) : ?>
					<h2 class="fs-4 mb-3">Los encuentros en su orden y sus resultados</h2>
					<?php foreach ($allConf as $index => $value) : ?>
						<div class="p-3">
							<h3 class="fs-5 mb-4"><?=$titles[$index]?></h3>
							<?php foreach ($value as $key => $info) : ?>
 								<p class="p-0"><?="Programación para el partido del dia ".$info->date." jugado entre las selecciones: ".$info->first_team." (".$info->firts_team_marker.") goles vs ".$info->second_team." (".$info->second_team_marker.") goles."?></p>
							<?php endforeach; ?>
						</div>
					<?php endforeach; ?>
				<?php endif; ?>
			</div>
		</div>
	</section>
<?=$this->endSection('page_content')?>


<?=$this->section('page_scripts')?>
	<script type="text/javascript"></script>
<?=$this->endSection('page_scripts')?>
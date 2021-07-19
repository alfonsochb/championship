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
		<?php if (isset($groups) and is_array($groups) and !empty($groups) ) :?>
			<div class="card bg-opacity mb-5 shadow">
				<div class="card-body p-lg-4">
					<h1 class="display-6">Grupos de la fase de clasificación para el Mundial de 2022</h1>
					<p class="lead mb-5">La clasificación para la Copa Mundial de Fútbol es el proceso realizado previo a cada una de las Copas Mundiales de Fútbol organizadas por la maxima autoridad deportiva en el que se determinan los equipos participantes de dicho evento. El proceso clasificatorio se ha realizado de diferentes formas desde la Copa Mundial de Fútbol de 1934, cuya fase final se disputó en Italia. Con el paso de los años, el número de equipos inscritos ha aumentado, llegando a 32 cupos por participación.</p>
					<table class="table table-bordered table-striped table-hover mb-3">
						<?php foreach ($groups as $group => $teams): ?>
							<tr>
								<td class="bg-secondary">
									<h1 class="display-1 text-white text-center py-4"><?=$group?></h1>
								</td>
								<td>
									<div class="row row-cols-1 row-cols-md-4 g-4">
										<?php foreach ($teams as $position => $team): ?>
											<a href="<?=site_url('teams/'.$team->id)?>" class="text-decoration-none">
												<div class="col">
													<div class="card h-100 border-0">
														<div class="card-body text-center">
															<img src="<?=$team->photo_flag?>" class="img-fluid" width="80%" />
															<h5 class="card-title"><?=$position." - <b>".$team->country_name."</b>"?></h5>
														</div>
													</div>
												</div>
											</a>
										<?php endforeach; ?>
									</div>									
								</td>
							</tr>
						<?php endforeach; ?>
					</table>
				</div>
			</div>
		<?php endif; ?>
	</section>
<?=$this->endSection('page_content')?>


<?=$this->section('page_scripts')?>
	<script type="text/javascript"></script>
<?=$this->endSection('page_scripts')?>
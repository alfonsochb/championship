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
	<style type="text/css">
		#teamsList i.fas { font-size:2rem; }
		#teamsList i.fa-flag-checkered { color:#4C6EF5; }
		#teamsList i.fa-shield-alt { color:#FD7E14; }
		#teamsList i.fa-camera-retro { color:#54AD20; }
		#teamsList i.fa-edit { color:#BE4BDB; }
		#teamsList i.fa-trash-alt { color:#E13834; }
	</style>
<?=$this->endSection('page_styles')?>


<?=$this->section('page_content')?>
	<section id="teamsList">
		<div class="card bg-opacity mb-5 shadow">
			<div class="card-body p-lg-4">
				<nav class="navbar navbar-light bg-light shadow mb-3">
					<div class="container">
						<span class="navbar-brand mb-0 h1">Administración Clubes</span>
						<div>
							<a class="btn btn-secondary btn-sm" href="<?=site_url('teams/new')?>">Nuevo</a>
						</div>
					</div>
				</nav>
				<div class="table-responsive">
					<?php if( is_array($teams) && !empty($teams) ): ?> 
						<table class="table table-striped table-hover table-bordered">
							<tbody>
	                            <?php foreach ($teams as $key => $info): ?>
									<tr>
										<td><img src="<?=$info->photo_team?>" class="img-fluid" width="128px" /></td>
										<td class="pt-3">
											<h4>
												<a href="<?=site_url('teams/'.$info->id)?>" class="text-decoration-none">
													<?=str_pad(($key+1), 2, 0, STR_PAD_LEFT).' - '.$info->country_name?>
												</a>
											</h4>
										</td>
										<td class="pt-3">									
											<a href="<?=site_url('teams/photo/team/'.$info->id)?>" class="btn btn-sm me-1" data-bs-toggle="tooltip" data-bs-placement="top" title="Foto equipo">
												<span><i class="fas fa-camera-retro"></i></span>
											</a>
										</td>										
										<td class="pt-3">									
											<a href="<?=site_url('teams/photo/shield/'.$info->id)?>" class="btn btn-sm me-1" data-bs-toggle="tooltip" data-bs-placement="top" title="Foto escudo">
												<span><i class="fas fa-shield-alt"></i></span>
											</a>
										</td>
										<td class="pt-3">
											<a href="<?=site_url('teams/photo/flag/'.$info->id)?>" class="btn btn-sm me-1" data-bs-toggle="tooltip" data-bs-placement="top" title="Foto bandera">
												<span><i class="fas fa-flag-checkered"></i></span>
											</a>
										</td>
										<!--<td class="pt-3">									
											<a href="#" class="btn btn-sm me-1" data-bs-toggle="tooltip" data-bs-placement="top" title="Editar equipo">
												<span><i class="fas fa-edit"></i></span>
											</a>
										</td>
										<td class="pt-3">									
											<a href="#" class="btn btn-sm me-1" data-bs-toggle="tooltip" data-bs-placement="top" title="Eliminar equipo">
												<span><i class="fas fa-trash-alt"></i></span>
											</a>
										</td>-->
									</tr>
	                            <?php endforeach; ?>
							</tbody>
						</table>
					<?php else: ?>
						<div>
							<h2 class="text-center mt-3">Aún no se han inscrito Clubes deportivos.</h2>
						</div>
					<?php endif; ?>
				</div>
			</div>
		</div>

	</section>
<?=$this->endSection('page_content')?>


<?=$this->section('page_scripts')?>
	<script type="text/javascript"></script>
<?=$this->endSection('page_scripts')?>
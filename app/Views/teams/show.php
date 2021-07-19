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
	<style type="text/css">
		i.fa-medal { font-size:1.6rem; color:#FFC107; }
		i.fa-camera {font-size: 1.6rem; color: Tomato;}
		.card-player{border: solid 10px #87A2BA;}
		.fbox{border: solid 1px #E2ECED; border-radius: 15px; background: rgba(226, 236, 237, .8);}
		.num{background-color: #3DB9B0;}
	</style>
<?=$this->endSection('page_styles')?>


<?=$this->section('page_content')?>
	<section>
		<div class="card bg-opacity mb-5 shadow">
			<div class="card-body p-lg-4">
				<div class="row">
					<div class="col-3">
						<img class="img-fluid" src="<?=base_url('public/img/balon.png')?>"/>
					</div>
					<div class="col-5 text-center">
						<img src="<?=$team->photo_flag?>" class="img-fluid" width="100"/>
						<h3 class="mt-2"><?=!empty($team->group) ? "Grupo ".$team->group : ""?></h3>
						<h5 class="mb-3"><?=$team->country_name?></h5>
                        <div class="d-grid gap-2 col-10 mb-3 mx-auto">
                            <a href="<?=$redirect?>" class="btn btn-primary">Todos los equipos</a>
                        </div>
						<?php if ($countGroups==32) : ?>
							<div class="d-grid gap-2 col-10 mb-3 mx-auto">
		                        <a href="<?=site_url('groups')?>" class="btn btn-primary">Ver la clasificación de Grupos</a>
		                    </div>
		                <?php endif; ?>
		                <div class="d-inline-block">&nbsp;</div>
					</div>
					<div class="col-4">
						<img src="<?=$team->photo_team?>" class="card-img card-img-top"/>
					</div>
				</div>
			</div>
		</div>

		<div class="row row-cols-1 row-cols-md-4 g-4">

			<div class="col">
				<div class="card shadow card-player">
					<div class="position-relative">
						<img src="<?=$team->photo_shield?>" class="card-img card-img-top" />
						<div class="card-img-overlay d-flex align-items-start flex-column p-2">
							<div class="fbox d-flex justify-content-between align-items-center w-100 mt-auto px-2" >
								<a class="my-1 text-decoration-none">
									<span>&nbsp;</span> 
								</a>											
								<b class="text-primary text-decoration-none fs-bold">
									<span><?="Escudo: ".$team->country_name?></span>
								</b>
							</div>
						</div>
					</div>
				</div>
			</div>

			<?php if (isset($players) and is_array($players) and !empty($players) ) :?>
				<?php foreach ($players as $key => $info): ?>
					<div class="col">
						<div class="card shadow card-player">
							<div class="position-relative">
								<img src="<?=$info->photo_player?>" class="card-img card-img-top" />
								<div class="card-img-overlay d-flex align-items-start flex-column p-2">
									<div class="w-100 mb-auto d-flex justify-content-end">
										<h1><span class="badge num"><?=$info->team_number?></span></h1>
									</div>
									<div class="fbox d-flex justify-content-between align-items-center w-100 mt-auto px-2" >
										<a class="my-1 text-decoration-none">
											<span><i class="fas fa-medal"></i></span> 
										</a>
										<?php if ($edit_photo) : ?>
											<a class="my-1 text-decoration-none" href="<?=site_url('teams/photo/player/'.$info->id)?>">
												<span><i class="fas fa-camera"></i></span>
											</a>
										<?php endif; ?>											
										<b class="text-primary text-decoration-none fs-bold">
											<span><?=$info->name." ".$info->surname?></span>
										</b>
									</div>
								</div>
							</div>
						</div>
					</div>
				<?php endforeach; ?>
			<?php endif; ?>

		</div>
	</section>
<?=$this->endSection('page_content')?>


<?=$this->section('page_scripts')?>
<script type="text/javascript"></script>
<?=$this->endSection('page_scripts')?>
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
				<?php if ( is_array($allConf) and !empty($allConf) ) : ?>
					<?php foreach ($allConf as $index => $value) : ?>
						<div class="p-3">
							<h1><?=$titles[$index]?></h1>
							<table class="table table-bordered">
								<thead class="bg-dark text-white">
									<tr>
										<th scope="col">ID</th>
										<th scope="col" width="110">Fecha</th>
										<th scope="col">Descripción</th>
										<th scope="col" colspan="3">Resultados del encuentro</th>
									</tr>
								</thead>
								<tbody>
									<?php foreach ($value as $key => $info) : ?>
										<tr id="<?=$info->id?>">
											<td><?=$info->id?></td>
											<td><?=$info->date?></td>
											<td><?=$info->description?></td>
											<td>
												<div class="input-group input-group-lg">
													<span class="input-group-text"><b><?=$info->first_team?></b></span>
													<input type="text" class="form-control text-end" value="<?=$info->firts_team_marker?>" disabled="true" />
												</div>
											</td>
											<td>
												<?php if ($info->status_play=='ON') : ?>
													<span style="font-size:1.6rem; color:#FFC107;"><i class="fas fa-medal"></i></span>
												<?php else : ?>
													<b class="text-primary">vs</b>
												<?php endif; ?>
											</td>
											<td>
												<div class="input-group input-group-lg">
													<input type="text" class="form-control" value="<?=$info->second_team_marker?>" disabled="true" />
													<span class="input-group-text"><b><?=$info->second_team?></b></span>
												</div>
											</td>
										</tr>
									<?php endforeach; ?>
								</tbody>
							</table>						
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
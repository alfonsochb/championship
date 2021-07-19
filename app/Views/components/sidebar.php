<?php
	$services = \Config\Services::request();
	$segments = $services->uri->getSegments();
	$obj = new \App\Libraries\WorldChampionship;
	$sideAll = $obj->theWorldCup;
	$session = session();
?>
<div class="d-flex flex-column flex-shrink-0 p-3 ">
	<div class="bg-light p-2">
		<a class="d-flex align-items-center mb-3 mb-md-0 me-md-auto link-dark text-decoration-none">
			<span class="fs-4">
				<span style="color:#099546;"><i class="fas fa-futbol"></i> </span>Administración
			</span>
		</a>
	</div>
	<hr>
	<ul class="nav nav-pills flex-column mb-auto">
		<li class="nav-item">
			<a href="<?=site_url('/')?>" class="nav-link <?=(reset($segments)=='user') ? 'active' : 'link-dark'?>" aria-current="page">
				<span style="color:#099546;"><i class="fas fa-house-user"></i> Inicio</span>
			</a>
		</li>
		<?php if ( $sideAll->countGroups==32 ) : ?>
			<li>
				<a href="<?=site_url('groups')?>" class="nav-link link-dark">
					<span><i class="fas fa-futbol"></i> Grupos clasificados</span>
				</a>
			</li>
			<li>
				<a href="<?=site_url('programming')?>" class="nav-link link-dark">
					<span><i class="fas fa-futbol"></i> Partidos programados</span>
				</a>
			</li>			
		<?php endif; ?>
		<?php if ( $session->get('logged_in') and $sideAll->countGroups==32 ) : ?>
			<li>
				<a href="<?=site_url('config')?>" class="nav-link link-dark">
					<span><i class="fas fa-futbol"></i> Administrador</span>
				</a>
			</li>
			<li>
				<a href="<?=site_url('teams')?>" class="nav-link link-dark">
					<span><i class="fas fa-futbol"></i> Equipos registrados</span>
				</a>
			</li>
		<?php endif; ?>
		<?php if( $session->get('logged_in') and $sideAll->countGames==64 ): ?>
			<li>
				<a href="<?=site_url('config/play')?>" class="nav-link link-dark">
					<span><i class="fas fa-futbol"></i> Registrar un juego</span>
				</a>
			</li>
			<li>
				<a href="<?=site_url('programming/info')?>" class="nav-link link-dark">
					<span><i class="fas fa-futbol"></i> Reportes</span>
				</a>
			</li>			
		<?php endif; ?>
	</ul>
	<hr>
</div>
<div class="clearfix">&nbsp;</div>
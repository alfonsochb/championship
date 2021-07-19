<?php
	$services = \Config\Services::request();
	$segments = $services->uri->getSegments();
	$obj = new \App\Libraries\WorldChampionship;
	$champs = $obj->theWorldCup;
	//echo "<pre>"; print_r($champs); die;
	$session = session();
?>
<nav class="navbar navbar-expand-md fixed-top navbar-light nav-achb">
	<div class="container-fluid">
		<a href="<?=site_url('/')?>" class="navbar-brand">
			<img src="<?=base_url('public/svg/championship.svg')?>" style="max-height: 52px;" />
		</a>
		<button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
			<span class="navbar-toggler-icon"></span>
		</button>
		<div id="navbarCollapse" class="collapse navbar-collapse">
			<ul class="navbar-nav me-auto mb-2 mb-md-0">
				<li class="nav-item"><a href="<?=site_url('/')?>" class="nav-link active" aria-current="page">Inicio</a></li>
				<?php if( $champs->countGroups==32) : ?>
					<li class="nav-item">
						<a href="<?=site_url('groups')?>" class="nav-link">Grupos</a>
					</li>
					<li class="nav-item">
						<a href="<?=site_url('programming')?>" class="nav-link">Partidos</a>
					</li>					
				<?php endif; ?>

				<?php if( $session->get('logged_in') and $champs->countGames==64) : ?>
					<li class="nav-item">
						<a href="<?=site_url('teams')?>" class="nav-link">Equipos</a>
					</li>
					<li class="nav-item">
						<a href="<?=site_url('config/play')?>" class="nav-link">Jugar</a>
					</li>
					<li class="nav-item">
						<a href="<?=site_url('programming/info')?>" class="nav-link">Reportes</a>
					</li>					
				<?php endif; ?>
			</ul>
            <ul class="navbar-nav ml-auto">
                <?php 
                if( $session->get('logged_in') && $session->get('user_email') ): 
                    $name = explode(' ', $session->get('user_name'));
                    $surname = explode(' ', $session->get('user_surname'));
                    $fullname = $name[0].' '.$surname[0];
                    ?>
					<li class="nav-item">
						<a href="<?=site_url('config')?>" class="nav-link">Administrador</a>
					</li>
                    <li class="nav-item dropdown">
						<a id="dropdown_dos" href="#" class="nav-link dropdown-toggle" role="button" data-bs-toggle="dropdown" aria-expanded="false">
							<b><?=$fullname;?></b>
						</a>
						<ul class="dropdown-menu dropdown-menu-end bg-light" aria-labelledby="dropdown_dos">
							<li><a href="<?=site_url('user/profile')?>" class="dropdown-item">Mi perfil de usuario</a></li>
							<div style="background: #F0F4FA;">
	                            <form id="logout-form" action="<?=site_url('logout')?>" method="POST" style="display: none;">
	                                <input type="hidden" name="logout" value="LOGOUT">
	                                <input type="hidden" name="<?=csrf_token()?>" value="<?=csrf_hash()?>" />
	                            </form>
	                            <a class="dropdown-item text-primary" href="<?=site_url('logout')?>" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Cerrar sesión</a>
		                    </div>
						</ul>
					</li>
                <?php else: ?>
                    <li class="nav-item">
                        <a id="btnlogin" href="<?=site_url('login')?>" class="btn btn-sm btn-secondary mt-1 ml-3">
                            <i class="fa fa-user"></i> Ingresar
                        </a>
                    </li>
                <?php endif; ?>
            </ul>
		</div>
	</div>
</nav>
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
	#formLogin {
		position: relative; 
		background: #DAE5EC url("./public/img/form-login.jpg") no-repeat scroll center top; 
		background-repeat:no-repeat; 
		background-size:cover;
		width: 100%; 
		max-width: 330px; 
		padding: 15px; 
		margin: auto;
	}
	.logo{font-family: 'Great Vibes', cursive;}
</style>
<?=$this->endSection('page_styles')?>


<?=$this->section('page_content')?>
<section class="py-5">
	<div class="container">
		<form id="formLogin" method="POST" action="<?=site_url('login')?>" class="p-4 bg-light border rounded-5 shadow" autocomplete="OFF">
			<input type="hidden" name="<?= csrf_token() ?>" value="<?=csrf_hash()?>" />
			<center class="py-3">
				<h2 class="navbar-brand app-text font-weight-bold" style="font-size: 2rem;">
					Acceso al sistema
				</h2>
			</center>
			<?php
				$session = session();
				if($session->has('errores')) {
					$errores = $session->getFlashdata('errores');
					echo '<div class="alert alert-danger" role="alert">'.$errores.'</div>';
				}
			?>
			<div class="form-group my-3">
				<input type="email" 
					id="email" 
					name="email" 
					value="<?=old('email')?>" 
					class="form-control" 
					placeholder="Correo electrónico" 
					required="true" 
					oninvalid="setCustomValidity('Este campo es obligatorio.')" 
					oninput="setCustomValidity('')" 
					autofocus="true"
				/>
			</div>
			<div class="form-group my-3">
				<input type="password" 
					id="password" 
					name="password" 
					value="<?=old('password')?>" 
					class="form-control" 
					placeholder="Password" 
					minlength="6" 
					maxlength="12" 
					required="true" 
					oninvalid="setCustomValidity('Este campo es obligatorio.')" 
					oninput="setCustomValidity('')" 
				/>
			</div>
			<div class="form-group my-3">
				<button type="submit" class="w-100 btn btn-md btn-secondary">Iniciar sesión</button>
			</div>
		</form>
	</div>
</section>
<?=$this->endSection('page_content') ?>


<?=$this->section('page_scripts')?>
<script type="text/javascript"></script>
<?=$this->endSection('page_scripts')?>
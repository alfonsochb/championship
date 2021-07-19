<!doctype html>
<html class="h-100" lang="es">

	<head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="author" content="<?=config('Achb')->appAutor?>">
        <meta name="description" content="<?=$this->renderSection('meta_description')?>"/>
        <meta name="keywords" content="<?=$this->renderSection('meta_keywords')?>"/>
        <meta name="<?=csrf_token()?>" id="<?=csrf_token()?>" content="<?=csrf_hash()?>"/>
        <title><?=$this->renderSection('meta_title') ?></title>
        <link rel="canonical" href="<?=current_url()?>" />
        <link rel="icon" href="<?=base_url('public/img/favicon.png')?>"/>
		<link rel="stylesheet" type="text/css" href="<?=base_url('public/bootstrap/css/bootstrap.min.css')?>">
		<link rel="stylesheet" type="text/css" href="<?=base_url('public/fontawesome/css/all.css')?>">
        <link rel="stylesheet" type="text/css" href="<?=base_url('public/css/appstyles.css')?>">
        <?=$this->renderSection('page_styles')?>
        <?=$this->include('components/info_json.php')?>
	</head>

	<body class="d-flex flex-column h-100">

		<header>
			<?=$this->include('components/navbar.php')?>
		</header>

		<main class="flex-shrink-0">
			<div class="container-fluid">
    			<?=$this->renderSection('page_content')?>
            </div>
		</main>

		<footer class="footer mt-auto py-3 shadow">
			<?=$this->include('components/footer')?>
		</footer>

		<?=$this->include('components/modal')?>
		
		<!-- Option 1: Bootstrap Bundle with Popper -->
		<script type="text/javascript" src="<?=base_url('public/bootstrap/js/bootstrap.bundle.min.js')?>"></script>
		<script type="text/javascript" src="<?=base_url('public/js/jquery-3.6.0.min.js')?>"></script>
		<script type="text/javascript" src="<?=base_url('public/js/sweetalert.min.js')?>"></script>
		<script type="text/javascript" src="<?=base_url('public/js/appscripts.js')?>"></script>
        <?=$this->renderSection('page_scripts')?>
        <?=$this->include('components/sweetalert')?>

	</body>
</html>
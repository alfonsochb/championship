<!DOCTYPE html>
<html lang="es">
	<head>
	    <meta charset="utf-8">
	    <title>404 Page Not Found</title>
	    <link rel="icon" href="<?=base_url('public/img/favicon.png')?>"/>
	    <style type="text/css">
			div.logo{height:200px;width:155px;display:inline-block;opacity:.08;position:absolute;top:2rem;left:50%;margin-left:-73px}
			body{height:100%;background:#EEF2F4;font-family:"Helvetica Neue",Helvetica,Arial,sans-serif;color:#777;font-weight:300}
			h1{font-weight:lighter;letter-spacing:.8;font-size:3rem;margin-top:20px;margin-bottom:20px;color:#6b7b8e}
			pre{white-space:normal;margin-top:1.5rem}
			code{background:#fafafa;border:1px solid #efefef;padding:.5rem 1rem;border-radius:5px;display:block}
			p{margin-top:1.5rem}.footer{margin-top:2rem;border-top:1px solid #efefef;padding:1em 2em 0 2em;font-size:85%;color:#999}
			a:active,a:link,a:visited{color:#0c7b93; text-decoration: none; font-weight: bold;}
			.wrap{max-width:800px;margin:5rem auto; padding:3rem;background:#fff;text-align:center;border:1px solid #efefef;border-radius:.5rem;position:relative}
		</style>
	</head>
	<body>
	    <div class="wrap">
	        <h1>Disculpe las molestias</h1>
	        <p>
	            <?php if (! empty($message) && $message!=='(null)') : ?>
	                <p><?=esc($message)?></p>
	            <?php else : ?>
	                <p>¡Perdón! No parece que tenemos problemas técnicos en la página.</p>
	            <?php endif ?>
	            <a class="text-decoration-none" href="<?=site_url('/')?>">Volver al inicio</a>
	        </p>
	    </div>
	</body>
</html>
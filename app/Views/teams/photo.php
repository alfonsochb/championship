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
<link rel="stylesheet" type="text/css" href="<?=base_url('public/css/cropper.css')?>">
	<style type="text/css">
		#whidthImg{height: 1px;}
        .box-img{background-color: #B5C6CE; cursor: pointer;}
	</style>
<?=$this->endSection('page_styles')?>


<?=$this->section('page_content')?>
	<section>
		<div class="card bg-opacity mb-5 shadow">
			<div class="card-body p-lg-4">
				
				<nav class="navbar navbar-light bg-light shadow mb-5">
					<div class="container">
						<span class="navbar-brand mb-0 h1">Registrar Club de futbol</span>
						<div>
							<a class="btn btn-secondary btn-sm" href="<?=site_url('teams')?>">Listado</a>
						</div>
					</div>
				</nav>

				<form class="needs-validation" novalidate="">
					<div class="row g-3">
						<h5 class="text-center"><?=$resumen?></h5>
                        <div class="row row-cols-1 row-cols-md-2 g-3">
                            <div class="col">
                                <div class="card shadow-sm">
                                    <div class="card-body">
                                        <div id="whidthImg" class="d-block"></div>
                                        <label class="label" data-toggle="tooltip" title="Actualizar imágen">
                                            <div class="box-img">
                                                <img id="imgCropper" src="<?=base_url('public/img/icons/5px.png')?>" class="img-fluid rounded" width="100%" />
                                                <input type="file" id="input_image" name="input_image" class="sr-only" accept="image/*" />
                                            </div>
                                        </label>
                                        <div class="progress">
                                            <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">0%</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col">
                                <div class="card shadow-sm">
                                    <div class="card-body">
                                        <ul class="list-group list-group-flush">
                                            <li class="list-group-item">Para subir foto, de clic en el area de la imagen.</li>
                                            <li class="list-group-item">Seleccione la foto desde su Computador.</li>
                                            <li class="list-group-item">Ajuste y recorte la imagen tratando de dejar una foto legible</li>
                                            <li class="list-group-item">Presioné el botón <strong>Cortar foto</strong></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="alert my-3" role="alert"></div> 
					</div>
				</form>

			</div>
		</div>
	</section>


    <div id="modal" class="modal fade" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-dialog-scrollable modal-lg">
            <div class="modal-content">
                <div class="modal-header" style="background: #EAF0EE;">
                    <h5 class="modal-title" id="staticBackdropLabel">Modal title</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <img id="modal_image" src="<?=base_url('public/flags/co.png')?>" />
                </div>
                <div class="modal-footer">
                    <button type="button" id="btn_cancel" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="button" id="btn_cropper" class="btn btn-primary">Cortar foto</button>
                </div>
            </div>
        </div>
    </div>	
<?=$this->endSection('page_content')?>


<?=$this->section('page_scripts')?>
<script type="text/javascript" src="<?=base_url('/public/js/cropper.js')?>"></script>
<script type="text/javascript">


        $(document).ready(function(){
            const w = Math.round( $("#whidthImg").width() );
            <?php if ($orientation=='H') : ?>
                const h = Math.round( ( w * 3 ) / 4 );
            <?php else: ?>
                const h = Math.round( ( w * 4 ) / 3 );
            <?php endif; ?>
            $("#imgCropper").css({'width': w+'px', 'height': h+'px'});
        }); 

        window.addEventListener('DOMContentLoaded', function () {
            var image = document.getElementById('imgCropper');
            var input_image = document.getElementById('input_image');
            var modal_image = document.getElementById('modal_image');
            
            var $progress = $('.progress');
            var $progressBar = $('.progress-bar');
            var $alert = $('.alert');
            var $modal = $('#modal');
            var cropper;

            $('[data-toggle="tooltip"]').tooltip();

            input_image.addEventListener('change', function (e) {
                var files = e.target.files;
                var done = function (url) {
                    input_image.value = '';
                    modal_image.src = url;
                    $alert.hide();
                    $modal.modal('show');
                };
                var reader;
                var file;
                var url;
                if (files && files.length > 0) {
                    file = files[0];
                    if (URL) {
                        done(URL.createObjectURL(file));
                    } else if (FileReader) {
                        reader = new FileReader();
                        reader.onload = function (e) {
                            done(reader.result);
                        };
                        reader.readAsDataURL(file);
                    }
                }
            });

            $modal.on('shown.bs.modal', function () {
                cropper = new Cropper(modal_image, {
                    <?php if ($orientation=='H') : ?>
                        aspectRatio: 4/3,
                    <?php else: ?>
                        aspectRatio: 3/4,
                    <?php endif; ?>
                    viewMode: 0,
                });
            }).on('hidden.bs.modal', function () {
                cropper.destroy();
                cropper = null;
            });

            document.getElementById('btn_cropper').addEventListener('click', function () {
                var initialAvatarURL;
                var canvas;
                $modal.modal('hide');
                if (cropper) {
                    canvas = cropper.getCroppedCanvas({
                        <?php if ($orientation=='H') : ?>
                            width: 334,
                            height: 250,
                        <?php else: ?>
                            width: 250,
                            height: 334,
                        <?php endif; ?>
                    });
                    initialAvatarURL = image.src;
                    image.src = canvas.toDataURL();
                    $progress.show();
                    $alert.removeClass('alert-success alert-warning');
                    canvas.toBlob(function (blob) {

                        var formData = new FormData();
                        formData.append("csrf_test_name", "<?=csrf_hash()?>" );
                        formData.append('photo_upload', blob, 'new_photo.jpg');
                        formData.append("orientation", "<?=$orientation?>");
                        formData.append("resumen", "<?=$resumen?>");
                        formData.append("photo", "<?=$photo?>");
                        formData.append("id", "<?=$id?>");
                        //formData.append("team_file", $("#team_file")[0].files[0]);//para otros archivos.
                        
                        $.ajax( "<?=site_url('teams/cropper')?>", {
                            method: 'POST',
                            data: formData,
                            processData: false,
                            contentType: false,
                            dataType : 'json',
                            xhr: function () {
                                var xhr = new XMLHttpRequest();
                                xhr.upload.onprogress = function (e) {
                                    var percent = '0';
                                    var percentage = '0%';
                                    if (e.lengthComputable) {
                                        percent = Math.round((e.loaded / e.total) * 100);
                                        percentage = percent + '%';
                                        $progressBar.width(percentage).attr('aria-valuenow', percent).text(percentage);
                                    }
                                };
                                return xhr;
                            },
                            success: function ( response ) {
                                console.log(response);
                                /*if ( typeof response.status!=='undefined' && response.status=='success' ) {
                                    $alert.show().addClass('alert-success').text('Avatar con carga exitosa.');
                                }else{
                                    $alert.show().addClass('alert-warning').text('No se puede actualizar el avatar.');
                                }
                                if ( response.data.length>=6 ) {
                                    $("#toolsCropper").hide();
                                    $("#maxNumImages").show();
                                }else{
                                    $("#toolsCropper").show();
                                    $("#maxNumImages").hide();
                                }*/
                            },
                            error: function () {
                                image.src = initialAvatarURL;
                                $alert.show().addClass('alert-warning').text('Upload error');
                            },
                            complete: function () {
                                $progress.hide();
                            },
                        });
                    });
                }
            });
        });
    </script>
<?=$this->endSection('page_scripts')?>
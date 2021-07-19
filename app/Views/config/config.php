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
    <style type="text/css"></style>
<?=$this->endSection('page_styles')?>


<?=$this->section('page_content')?>
    <section class="mb-3">
        <h1 class="visually-hidden"><?=@$meta_tit?></h1>
        <div class="card bg-light shadow">
            <div class="card-body p-4">
                <div class="row">
                    <div class="col-12 col-md-2">
                        <img class="rotar img-fluid" src="<?=base_url('public/img/balon-2.png')?>"/>
                    </div>
                    <div class="col-12 col-md-10">
                        <h1 class="text-center pt-3">Configuraciones del campeonato</h1>
                    </div> 
                </div> 
            </div>
        </div>
    </section>



    <section class="mb-3">

        <div class="row row-cols-1 row-cols-md-2 g-4">
            
            <div class="col">
                <div class="card h-100 border-0 bg-opacity shadow">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-3">
                                <img class="img-fluid d-inline-block" src="<?=base_url('public/img/nums/1.png')?>" width="100"/>
                            </div>
                            <div class="col-9">
                                <h2 class="d-inline-block">Registrar equipos</h2>
                            </div>
                            <div class="col-12">
                                <p>Los clubes deportivos son entidades que participarán en el campeonato del mundo, por lo que es necesario solicitar la inscripción del mismo en la Federación Deportiva.</p>
                            </div>
                        </div>
                        <?php if( $config->status['inscription']=='OFF' and $config->countTeams<32 ): ?>
                            <div class="d-grid gap-2 col-10 mx-auto">
                                <a href="<?=site_url('teams')?>" class="btn btn-primary">Inscripciones</a>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <div class="col">
                <div class="card h-100 border-0 bg-opacity shadow">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-3">
                                <img class="img-fluid d-inline-block" src="<?=base_url('public/img/nums/2.png')?>" width="100"/>
                            </div>
                            <div class="col-9">
                                <h2 class="d-inline-block">Sorteo Grupos</h2>
                            </div>
                            <div class="col-12">
                                <p>El sorteo de la competición final se lleva a cabo una ves que esten registrados los 32 Clubes deportivos, este sorteo dará lugar a ocho grandes grupos cada uno conformado por cuatro equipos quienes jugaran entre si para superar la primera ronda.</p>
                            </div> 
                        </div>
                        <?php if( $config->countTeams==32 and $config->countGroups==0 ): ?>
                            <div class="d-grid gap-2 col-10 mx-auto">
                                <a href="<?=site_url('config/lottery')?>" class="btn btn-primary">Realizar sorteo</a>
                            </div> 
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <div class="col">
                <div class="card h-100 border-0 bg-opacity shadow">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-3">
                                <img class="img-fluid d-inline-block" src="<?=base_url('public/img/nums/3.png')?>" width="100"/>
                            </div>
                            <div class="col-9">
                                <h2 class="d-inline-block">Establecer fechas</h2>
                            </div>
                            <div class="col-12">
                                <p>El campeonato esta programado para dar inicio 30 días a partir de la programación en esta sección, se hace una distrribusión de tres partidos por día.</p>
                            </div> 
                        </div>
                        <?php if( $config->countTeams==32 and $config->countGroups==32 and $config->countGames==0 ): ?>
                            <div class="d-grid gap-2 col-10 mx-auto">
                                <a href="<?=site_url('config/dates')?>" class="btn btn-primary">Programar las fechas</a>
                            </div>
                        <?php endif; ?> 
                    </div>
                </div>
            </div>

            <div class="col">
                <div class="card h-100 border-0 bg-opacity shadow">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-3">
                                <img class="img-fluid d-inline-block" src="<?=base_url('public/img/nums/4.png')?>" width="100"/>
                            </div>
                            <div class="col-9">
                                <h2 class="d-inline-block">Jugar partidos</h2>
                            </div>
                            <div class="col-12">
                                <p>El <b>Administrador</b> es el encargado de llenar la información que se va presentando en el transcurso del desarrollo de los partidos</p>
                            </div> 
                        </div>
                        <?php if( $config->countGroups==32 and $config->countGames==64 ): ?>
                            <div class="d-grid gap-2 col-10 mx-auto">
                                <a href="<?=site_url('config/play')?>" class="btn btn-primary">Registrar información de los partidos</a>
                            </div> 
                        <?php endif; ?>
                    </div>
                </div>
            </div>

        </div>
        <div style="min-height: 10rem;"></div>
    </section>
<?=$this->endSection('page_content') ?>


<?=$this->section('page_scripts')?>
    <script type="text/javascript">
    </script>
<?=$this->endSection('page_scripts')?>
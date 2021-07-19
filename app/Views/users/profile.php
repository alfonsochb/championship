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
    <div class="bg-white p-3 mb-5 shadow">
        <h1 class="titulo mb-4 apptext"><?=($user->name.' '.$user->surname)?></h1>
        
        <div class="row">
            <div class="col-md-3">
                <img class="img-fluid" width="100%" src="<?=$user->foto?>" alt="<?=$user->name?>">
            </div>
            <div class="col-md-9">
                <ul class="list-group">
                    <li class="list-group-item">Identificador: <span class="text-success"><?=$user->id?></span></li>
                    <li class="list-group-item">Nombres: <span class="text-success"><?=$user->name?></span></li>
                    <li class="list-group-item">Apellidos: <span class="text-success"><?=$user->surname?></span></li>
                    <li class="list-group-item">Email: <span class="text-success"><?=$user->email?></span></li>
                    <li class="list-group-item">Creado: <span class="text-success"><?=$user->date?></span></li>
                </ul>
            </div>
        </div>
    </div>
</section>
<?=$this->endSection('page_content') ?>


<?=$this->section('page_scripts')?>
<script type="text/javascript"></script>
<?=$this->endSection('page_scripts')?>
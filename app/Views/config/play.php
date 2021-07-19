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
    <form id="formAdd" method="POST" action="<?=site_url('config/play-add')?>" autocomplete="off" novalidate>
        <input type="hidden" name="_method" value="POST" readonly="readonly" required="true" />
        <input type="hidden" name="<?=csrf_token()?>" value="<?=csrf_hash()?>" readonly="readonly" required="true" />
        <input type="hidden" name="game_id" value="<?=$config->id?>" readonly="readonly" required="true" />
        <section class="mb-3">
            <h1 class="visually-hidden"><?=@$meta_tit?></h1>
            <div class="card bg-light shadow">
                <div class="card-body p-4">
                    <table class="mb-4">
                        <tr>
                            <td width="20%">
                                <img class="rotar img-fluid" src="<?=base_url('public/img/balon-2.png')?>"/>
                            </td>
                            <td class="text-center">
                                <h4 class="text-center"><?=$config->description?></h4>
                                <h3 class="text-center"><?=$config->date?></h3>
                                <div class="d-grid gap-2 col-10 mx-auto">
                                    <button type="submit" class="btn btn-primary">Registrar pertido</button>
                                </div>
                            </td>
                            <td width="30%">
                                <img class="img-fluid" src="<?=base_url('public/img/campo.png')?>"/>
                            </td>
                        </tr>
                    </table>

                    <table class="table table-bordered">
                        <thead class="bg-dark text-white">
                            <tr>
                                <th class="text-center" scope="col" colspan="2">
                                    <?=$config->firts_team->country_name?>
                                </th>
                                <th class="text-center" width="2%"><b class="text-primary">vs</b></th>
                                <th class="text-center" scope="col" colspan="2">
                                    <?=$config->second_team->country_name?>
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="text-center pt-3"><b>GOLES</b></td>
                                <td width="15%">
                                    <input type="number" 
                                        name="firts_team_marker"
                                        class="form-control text-center form-control-lg" 
                                        pattern="[0-9]+" 
                                        maxlength="2" 
                                        value="0" 
                                        oninput="(this.value.length>this.maxLength) ? this.value=this.value.slice(0,this.maxLength) : this.value=this.value" 
                                    />
                                </td>
                                <td class="text-center pt-3"><b class="text-primary">vs</b></td>
                                <td width="15%">
                                    <input type="number" 
                                        name="second_team_marker"
                                        class="form-control text-center form-control-lg" 
                                        pattern="[0-9]+" 
                                        maxlength="2" 
                                        value="0" 
                                        oninput="(this.value.length>this.maxLength) ? this.value=this.value.slice(0,this.maxLength) : this.value=this.value" 
                                    />
                                </td>
                                <td class="text-center pt-3"><b>GOLES</b></td>
                            </tr>
                            <tr>
                                <td colspan="2">
                                    <ul class="list-group list-group-flush">
                                        <?php foreach ($config->firts_team->players as $key => $info) : ?>
                                        <li class="list-group-item d-flex justify-content-between">
                                            <span><?=$info->team_position." - ".$info->name." ".$info->surname?></span>
                                            <span>
                                                <label for="<?='yellow-'.$info->id?>" class="form-check-label">
                                                    <span class="badge bg-warning pt-1 pb-0 px-2">
                                                        <div class="form-check">
                                                            <input 
                                                                id="<?='yellow-'.$info->id?>" 
                                                                type="checkbox" 
                                                                name="yellow[<?=$config->firts_team->id?>][<?=$info->id?>]"
                                                                class="form-check-input"
                                                            />&nbsp;
                                                        </div>
                                                    </span>
                                                </label>
                                                <label for="<?='red-'.$info->id?>" class="form-check-label">
                                                    <span class="badge bg-danger pt-1 pb-0 px-2">
                                                        <div class="form-check">
                                                            <input 
                                                                id="<?='red-'.$info->id?>" 
                                                                type="checkbox" 
                                                                name="red[<?=$config->firts_team->id?>][<?=$info->id?>]"
                                                                class="form-check-input"
                                                            />&nbsp;
                                                        </div>
                                                    </span>
                                                </label>
                                            </span>
                                        </li>
                                        <?php endforeach; ?>
                                    </ul>
                                </td>
                                <td>&nbsp;</td>
                                <td colspan="2">
                                    <ul class="list-group list-group-flush">
                                        <?php foreach ($config->second_team->players as $key => $info) : ?>
                                        <li class="list-group-item d-flex justify-content-between">
                                            <span><?=$info->team_position." - ".$info->name." ".$info->surname?></span>
                                            <span>
                                                <label for="<?='yellow-'.$info->id?>" class="form-check-label">
                                                    <span class="badge bg-warning pt-1 pb-0 px-2">
                                                        <div class="form-check">
                                                            <input 
                                                                id="<?='yellow-'.$info->id?>" 
                                                                type="checkbox" 
                                                                name="yellow[<?=$config->second_team->id?>][<?=$info->id?>]"
                                                                class="form-check-input"
                                                            />&nbsp;
                                                        </div>
                                                    </span>
                                                </label>
                                                <label for="<?='red-'.$info->id?>" class="form-check-label">
                                                    <span class="badge bg-danger pt-1 pb-0 px-2">
                                                        <div class="form-check">
                                                            <input 
                                                                id="<?='red-'.$info->id?>" 
                                                                type="checkbox" 
                                                                name="red[<?=$config->second_team->id?>][<?=$info->id?>]"
                                                                class="form-check-input"
                                                            />&nbsp;
                                                        </div>
                                                    </span>
                                                </label>
                                            </span>
                                        </li>
                                        <?php endforeach; ?>
                                    </ul>
                                </td>
                            </tr>
                        </tbody>
                    </table> 
                </div>
            </div>
        </section>
    </form>
<?=$this->endSection('page_content') ?>


<?=$this->section('page_scripts')?>
    <script type="text/javascript">
        $("input[type=number]").change(function() {
            $(this).val( $(this).val()<0 ? 0 : $(this).val() );
            if ($(this).val()=='') $(this).val(0);
        });

        const form = document.querySelector('#formAdd');
        form.addEventListener('submit', function (event) {
            event.preventDefault();
            event.stopPropagation();
            swal({
                title: 'Registrar partido jugado!',
                text: 'Esta seguro de registrar esta información? Esta acción no se podrá revertir.',
                icon: 'warning',
                buttons: true,
                dangerMode: true,
                closeOnClickOutside: false,
                buttons: {
                    cancel: {
                        text: "Cancelar",
                        value: false,
                        visible: true,
                        className: "",
                        closeModal: true,
                    },
                    confirm: {
                        text: "OK Registrar",
                        value: true,
                        visible: true,
                        className: "",
                        closeModal: true
                    }
                }
            }).then((estaConfirmado) => {
                if (estaConfirmado) {
                    $( "#formAdd" ).submit();
                    console.log("confirmado");
                }else{
                    console.log("no confirmado");
                }
            });
        });
    </script>
<?=$this->endSection('page_scripts')?>
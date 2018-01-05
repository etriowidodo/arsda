<?php
	use yii\helpers\Html;
	use yii\grid\GridView;
	use yii\widgets\Pjax;
	use yii\widgets\ActiveForm;
	use yii\helpers\ArrayHelper;
	use app\modules\pidsus\models\Spdp as pilih;
	$isNewRecord = ($model["no_urut"])?'0':'1';
?>
<div id="wrapper-modal-tsk">
    <form class="form-horizontal" id="frm-m1">
        <div class="row">
            <div class="col-md-12">
                <div class="form-group form-group-sm">
                    <label class="control-label col-md-2">No Urut Tersangka</label>
                    <div class="col-md-2">
                        <input type="text" name="no_urut" id="no_urut" class="form-control" value="<?= $model["no_urut"]?>" />
                    </div>
                    <label class="control-label col-md-1">Nama</label>
                    <div class="col-md-7">
                        <input type="text" name="nama" id="nama" class="form-control" value="<?= $model["nama"]?>" />
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="form-group form-group-sm">
                    <label class="control-label col-md-2">Tempat Lahir</label>
                    <div class="col-md-4">
                        <input type="text" name="tmpt_lahir" id="tmpt_lahir" class="form-control" value="<?= $model["tmpt_lahir"]?>" />
                    </div>
                    <label class="control-label col-md-2">Tanggal Lahir</label>
                    <div class="col-md-4">
                         <div class="input-group">
                            <div class="input-group-addon"><i class="fa fa-calendar"></i></div>
                            <input type="text" name="tgl_lahir" id="tgl_lahir" class="form-control datepicker" placeholder="DD-MM-YYYY" value="<?= $model["tgl_lahir"]?>" />
							<div class="input-group-addon" style="border:none; font-size:12px;">Umur</div>
							<input type="text" name="umur" id="umur" class="form-control" style="width:60px;" value="<?= ($model["umur"]?$model["umur"]:'')?>" />
						</div>                            	
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="form-group form-group-sm">
                    <label class="control-label col-md-2">Kewarganegaraan</label>
                    <div class="col-md-4">
                        <input type="hidden" name="id_warganegara" id="id_warganegara" class="form-control" value="<?= $model["id_warganegara"]?>"/>
                        <input type="text" name="warganegara" id="warganegara" class="form-control" value="<?= $model["kebangsaan"]?>" placeholder="-Pilih Kewarganegaraan-"/>
                    </div>
                    <label class="control-label col-md-2">Suku</label>
                    <div class="col-md-4">
                        <input type="text" name="suku" id="suku" class="form-control" value="<?= $model["suku"]?>" />
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="form-group form-group-sm">
                    <label class="control-label col-md-2">Identitas</label>
                    <div class="col-md-4">
                        <select id="id_identitas" name="id_identitas" class="select2" style="width:100%;">
                            <option></option>
                            <?php 
                                $idn = pilih::findBySql("select * from public.ms_identitas order by id_identitas")->asArray()->all();
                                foreach($idn as $id){
                                    $selected = ($id['id_identitas'] == $model['id_identitas'])?'selected':'';
                                    echo '<option value="'.$id['id_identitas'].'" '.$selected.'>'.$id['nama'].'</option>';
                                }
                            ?>
                        </select>
                    </div>
                    <label class="control-label col-md-2">No Identitas</label>
                    <div class="col-md-4">
                        <input type="text" name="no_identitas" value="<?= $model["no_identitas"]?>" id="no_identitas" class="form-control" placeholder="No Identitas"/>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="form-group form-group-sm">
                    <label class="control-label col-md-2">Jenis Kelamin</label>
                    <div class="col-md-4">
                        <input type="radio" name="id_jkl" id="id_jkl[1]" value="0" <?php echo (!$model["id_jkl"])?'checked':'';?> class="simple" style="display:none;" />
                        <input type="radio" name="id_jkl" id="id_jkl[1]" value="1" <?php echo ($model["id_jkl"] == "1")?'checked':'';?> />
                        <label for="id_jkl[1]" class="control-label jarak-kanan">Laki-Laki</label>
                        
                        <input type="radio" name="id_jkl" id="id_jkl[2]" value="2" <?php echo ($model["id_jkl"] == "2")?'checked':'';?> />
                        <label for="id_jkl[2]" class="control-label">Perempuan</label>
                    </div>
                    <label class="control-label col-md-2">Agama</label>
                    <div class="col-md-4">
                    <select id="id_agama" name="id_agama" class="select2" style="width:100%;">
                        <option></option>
                        <?php 
                             $agm = pilih::findBySql("select * from public.ms_agama order by id_agama")->asArray()->all();
                            foreach($agm as $ag){
                                $selected = ($ag['id_agama'] == $model['id_agama'])?'selected':'';
                                echo '<option value="'.$ag['id_agama'].'" '.$selected.'>'.$ag['nama'].'</option>';
                            }
                        ?>
                    </select>
                </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="form-group form-group-sm">
                    <label class="control-label col-md-2">Alamat</label>
                    <div class="col-md-4">
                        <textarea style="height: 100px" name="alamat" id="alamat" class="form-control"><?= $model["alamat"]?></textarea>
                    </div>
                    <label class="control-label col-md-2">No HP</label>
                    <div class="col-md-4">
                        <input type="text" name="no_hp" id="no_hp" class="form-control" value="<?= $model["no_hp"]?>"/>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="form-group form-group-sm">
                    <label class="control-label col-md-2">Pendidikan</label>
                        <div class="col-md-4">
                            <select id="pendidikan" name="pendidikan" class="select2" style="width:100%;">
                            <option></option>
                            <?php 
                                $pdd = pilih::findBySql("select * from public.ms_pendidikan order by id_pendidikan")->asArray()->all();
                                foreach($pdd as $pd){
                                    $selected = ($pd['id_pendidikan'] === $model['id_pendidikan'])?'selected':'';
                                	echo '<option value="'.$pd['id_pendidikan'].'" '.$selected.'>'.$pd['nama'].'</option>';
                                }
                            ?>
                        </select>
                    </div>
                    <label class="control-label col-md-2">Pekerjaan</label>
                    <div class="col-md-4">
                        <input type="text" name="pekerjaan" id="pekerjaan" class="form-control" value="<?= $model["pekerjaan"]?>"/>
                    </div>
                </div>
            </div>
        </div>
        <hr style="border-color: #c7c7c7;margin: 10px 0;">
        <div class="box-footer text-center"> 
            <input type="hidden" name="isNewRecord" id="isNewRecord" value="<?php echo $isNewRecord;?>" />
            <input type="hidden" name="tr_id" id="tr_id" value="" />
            <button type="button" id="simpan_form_tersangka" class="btn btn-warning btn-sm jarak-kanan"><i class="fa fa-floppy-o jarak-kanan"></i><?php echo ($isNewRecord)?'Simpan':'Ubah';?></button>
            <a data-dismiss="modal" class="btn btn-danger btn-sm" id="form_keluar"><i class="fa fa-reply jarak-kanan"></i>Kembali</a>
        </div>
    </form>
    <div class="modal-loading-new"></div>
</div>
<style>
	#wrapper-modal-tsk.loading {overflow: hidden;}
	#wrapper-modal-tsk.loading .modal-loading-new {display: block;}

	.form-horizontal .form-group-sm .control-label{
		font-size: 12px;
	}
	.help-block{
		margin-bottom: 0px;
		margin-top: 0px;
		font-size: 12px;
	}
	.select2-search--dropdown .select2-search__field{
		font-family: arial;
		font-size: 11px;
		padding: 4px 3px;
	}
	.form-group-sm .select2-container > .selection,
	.select2-results__option{
		font-family: arial;
		font-size: 11px;
	}
</style>

<script type="text/javascript">
$(function(){
    var tglASDF123 = '<?php echo date("Y").",".date("m").",".date("d");?>';
   
    $(".select2").select2({placeholder:"Pilih salah satu", allowClear:true});
    
    $("input[type='radio']:not(.simple)").iCheck({radioClass: 'iradio_square-pink'}); 
    
    $("#tgl_lahir").datepicker({								  
		defaultDate: new Date(tglASDF123),
		dateFormat: 'dd-mm-yy',
		changeMonth: true,
		changeYear: true,
		yearRange: "c-80:c+10",
		dayNamesMin: ['Min', 'Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab'],
		monthNamesShort: ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'],
    });
    
    $("#tgl_lahir").on('change',function (){
        var tgl = $('#tgl_lahir').val();
        var str = tgl.split('-');
        var firstdate=new Date(str[2],str[1],str[0]);
        var tglSkr ='<?php echo date("d-m-Y");?>';

        var start = tglSkr.split('-');
        var Endate=new Date(start[2],start[1],start[0]);
        var today = new Date(Endate);
        var dayDiff = Math.ceil(today.getTime() - firstdate.getTime()) / (1000 * 60 * 60 * 24 * 365);
        var age = parseInt(dayDiff);
        $('#umur').val(age);
    });
});
</script>

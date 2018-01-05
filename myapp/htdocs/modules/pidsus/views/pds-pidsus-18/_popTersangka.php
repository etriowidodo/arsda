<?php
	use yii\helpers\Html;
	use yii\grid\GridView;
	use yii\widgets\Pjax;
	use yii\widgets\ActiveForm;
	use yii\helpers\ArrayHelper;
	use app\modules\pidsus\models\Spdp as pilih;
?>
<div id="wrapper-modal-tsk">
    <form class="form-horizontal" id="form-modal-tsk">
        <div class="row">
            <div class="col-md-6">
                <div class="form-group form-group-sm">
                    <label class="control-label col-md-4">Nama</label>        
                    <div class="col-md-8">
                        <input type="text" name="modal_nama" id="modal_nama" class="form-control" value="<?php echo $model['nama'];?>" required data-error="Kolom [Nama] belum diisi" />
                        <div class="help-block with-errors"></div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="row">
                    <div class="col-md-10">
                        <div class="form-group form-group-sm">
                            <label class="control-label col-md-5">Tanggal Lahir</label>        
                            <div class="col-md-7">
                                <div class="input-group">
                                    <div class="input-group-addon"><i class="fa fa-calendar"></i></div>
                                    <input type="text" name="modal_tgl_lahir" id="modal_tgl_lahir" class="form-control datepicker" placeholder="DD-MM-YYYY" value="<?php echo $model["tgl_lahir"];?>" required data-error="Kolom [Tanggal Lahir] belum diisi"/>
                                        <div class="input-group-addon" style="border:none; font-size:12px;">Umur</div>

                                    </div> 
                                <div class="help-block with-errors"></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <input type="text" name="modal_umur" id="modal_umur" class="form-control" value="<?php echo $model["umur"];?>" />
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group form-group-sm">
                    <label class="control-label col-md-4">Tempat Lahir</label>        
                    <div class="col-md-8">
                        <input type="text" name="modal_tmpt_lahir" id="modal_tmpt_lahir" class="form-control" value="<?php echo $model['tmpt_lahir'];?>" required data-error="Kolom [Tempat Lahir] belum diisi" />
                        <div class="help-block with-errors"></div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group form-group-sm">
                    <label class="control-label col-md-4">Suku</label>        
                    <div class="col-md-8">
                        <input type="text" name="modal_suku" id="modal_suku" class="form-control" value="<?php echo $model['suku'];?>" maxlength="32" />
                        <div class="help-block with-errors"></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group form-group-sm">
                    <label class="control-label col-md-4">Kewarganegaraan</label>        
                    <div class="col-md-8">
                        <input type="hidden" name="modal_warganegara" id="modal_warganegara" class="form-control" value="<?php echo $model["modal_warganegara"];?>"/>
                        <input type="text" name="modal_kebangsaan" id="modal_kebangsaan" class="form-control" value="<?php echo $model["kebangsaan"]?>" placeholder="-Pilih Kewarganegaraan-"/>
                        <div class="help-block with-errors"></div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group form-group-sm">
                    <label class="control-label col-md-4">No Identitas</label>        
                    <div class="col-md-8">
                        <input type="text" name="modal_no_identitas" id="modal_no_identitas" class="form-control" value="<?php echo $model['no_identitas'];?>" maxlength="24" />
                        <div class="help-block with-errors"></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group form-group-sm">
                    <label class="control-label col-md-4">Identitas</label>        
                    <div class="col-md-8">
                        <select id="modal_id_identitas" name="modal_id_identitas" class="select2" style="width:100%;">
                            <option></option>
                            <?php 
                                $idn = pilih::findBySql("select * from public.ms_identitas order by id_identitas")->asArray()->all();
                                foreach($idn as $id){
                                    $selected = ($id['id_identitas'] == $model['id_identitas'])?'selected':'';
                                    echo '<option value="'.$id['id_identitas'].'" '.$selected.'>'.$id['nama'].'</option>';
                                }
                            ?>
                        </select>
                        <div class="help-block with-errors"></div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group form-group-sm">
                    <label class="control-label col-md-4">Agama</label>        
                    <div class="col-md-8">
                        <select id="modal_id_agama" name="modal_id_agama" class="select2" style="width:100%;">
                            <option></option>
                            <?php 
                                 $agm = pilih::findBySql("select * from public.ms_agama order by id_agama")->asArray()->all();
                                foreach($agm as $ag){
                                    $selected = ($ag['id_agama'] == $model['id_agama'])?'selected':'';
                                    echo '<option value="'.$ag['id_agama'].'" '.$selected.'>'.$ag['nama'].'</option>';
                                }
                            ?>
                        </select>
                        <div class="help-block with-errors"></div>
                    </div>
                </div>
            </div>            
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group form-group-sm">
                    <label class="control-label col-md-4">Jenis Kelamin</label>
                    <div class="col-md-8">
                        <input type="radio" name="modal_id_jkl" id="modal_id_jkl[1]" value="1" <?php echo ($model["id_jkl"] == "1")?'checked':'';?> />
                        <label for="modal_id_jkl[1]" class="control-label jarak-kanan">Laki-Laki</label>
                        
                        <input type="radio" name="modal_id_jkl" id="modal_id_jkl[2]" value="2" <?php echo ($model["id_jkl"] == "2")?'checked':'';?> />
                        <label for="modal_id_jkl[2]" class="control-label">Perempuan</label>
                        <div class="help-block with-errors"></div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group form-group-sm">
                    <label class="control-label col-md-4">Pekerjaan</label>        
                    <div class="col-md-8">
                        <input type="text" name="modal_pekerjaan" id="modal_pekerjaan" class="form-control" value="<?php echo $model['pekerjaan'];?>" maxlength="64" />
                        <div class="help-block with-errors"></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group form-group-sm">
                    <label class="control-label col-md-4">Alamat</label>        
                    <div class="col-md-8">
                        <textarea style="height: 100px" name="modal_alamat" id="modal_alamat" class="form-control"><?php echo $model["alamat"];?></textarea>
                        <div class="help-block with-errors"></div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group form-group-sm">
                            <label class="control-label col-md-4">Pendidikan</label>        
                            <div class="col-md-8">
                                <select id="modal_id_pendidikan" name="modal_id_pendidikan" class="select2" style="width:100%;">
                                    <option></option>
                                    <?php 
                                        $pdd = pilih::findBySql("select * from public.ms_pendidikan order by id_pendidikan")->asArray()->all();
                                        foreach($pdd as $pd){
                                            $selected = ($pd['id_pendidikan'] === $model['id_pendidikan'])?'selected':'';
                                                echo '<option value="'.$pd['id_pendidikan'].'" '.$selected.'>'.$pd['nama'].'</option>';
                                        }
                                    ?>
                                </select>
                                <div class="help-block with-errors"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group form-group-sm">
                            <label class="control-label col-md-4">No HP.</label>        
                            <div class="col-md-8">
                                <input type="text" name="modal_no_hp" id="modal_no_hp" class="form-control" value="<?php echo $model['no_hp'];?>" maxlength="32" />
                                <div class="help-block with-errors"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <hr style="border-color: #c7c7c7;margin: 10px 0;">
        <div class="box-footer text-center"> 
            <input type="hidden" name="evt_tersangka_sukses" id="evt_tersangka_sukses" />
            <input type="hidden" name="nurec_tersangka" id="nurec_tersangka" value="" />
            <input type="hidden" name="tr_id_tersangka" id="tr_id_tersangka" value="" />
            <button type="submit" id="simpan_form_tersangka" class="btn btn-warning btn-sm jarak-kanan"></button>
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
    
    $("#modal_tgl_lahir").datepicker({								  
		defaultDate: new Date(tglASDF123),
		dateFormat: 'dd-mm-yy',
		changeMonth: true,
		changeYear: true,
		yearRange: "c-80:c+10",
		dayNamesMin: ['Min', 'Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab'],
		monthNamesShort: ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'],
    });
    
    $("#modal_tgl_lahir").on('change',function (){
        var tgl = $('#modal_tgl_lahir').val();
        var str = tgl.split('-');
        var firstdate=new Date(str[2],str[1],str[0]);
        var tglSkr ='<?php echo date("d-m-Y");?>';

        var start = tglSkr.split('-');
        var Endate=new Date(start[2],start[1],start[0]);
        var today = new Date(Endate);
        var dayDiff = Math.ceil(today.getTime() - firstdate.getTime()) / (1000 * 60 * 60 * 24 * 365);
        var age = parseInt(dayDiff);
        $('#modal_umur').val(age);
    });
});
</script>

<?php
	use yii\helpers\Html;
	use yii\widgets\ActiveForm;
	use yii\bootstrap\Modal;
	use yii\widgets\Pjax;
	use yii\grid\GridView;
	use app\modules\pidsus\models\BaKonsultasi;

	$this->params['idtitle'] = Yii::$app->inspektur->getHeaderPraPenuntutan();
	$whereDefault 	= "id_kejati = '".$_SESSION["kode_kejati"]."' and id_kejari = '".$_SESSION["kode_kejari"]."' and id_cabjari = '".$_SESSION["kode_cabjari"]."' 
						and no_spdp = '".$_SESSION["no_spdp"]."' and tgl_spdp = '".$_SESSION["tgl_spdp"]."'";
	$linkBatal		= '/pidsus/ba-konsultasi/index';
	$linkCetak		= '/pidsus/ba-konsultasi/cetak?id='.$model['id_ba_konsultasi'];
	$tgl_pelaksanaan	= ($model['tgl_pelaksanaan'])?date('d-m-Y',strtotime($model['tgl_pelaksanaan'])):'';
?>

<?php if($_SESSION['no_spdp'] && $_SESSION['tgl_spdp']){ ?>
<form id="role-form" name="role-form" class="form-validasi form-horizontal" method="post" action="/pidsus/ba-konsultasi/simpan" enctype="multipart/form-data">
<input type="hidden" name="_csrf" value="<?=Yii::$app->request->getCsrfToken()?>" />

<div class="row">
    <div class="col-md-12">
        <div class="box box-primary">
            <div class="box-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group form-group-sm">
                            <label class="control-label col-md-4">Nama Jaksa Penuntut Umum</label>        
                            <div class="col-md-8">
                                <input type="hidden" name="id_ba_konsultasi" id="id_ba_konsultasi" value="<?php echo $model['id_ba_konsultasi'];?>" />
                                <select id="jaksa" name="jaksa" class="select2" style="width:100%;" required data-error="Instansi Penyidik belum dipilih">
                                    <option></option>
                                    <?php 
                                        $jns = BaKonsultasi::findBySql("select * from pidsus.pds_p16_jaksa where ".$whereDefault)->asArray()->all();
                                        foreach($jns as $ji){
                                            $selected = ($ji['nip'] == $model['nip_jaksa'])?'selected':'';
                                            echo '<option value="'.$ji['nip'].'|#|'.$ji['nama'].'|#|'.$ji['gol_jaksa'].'|#|'.$ji['pangkat_jaksa'].'|#|'.$ji['jabatan_jaksa'].'" '.$selected.'>'.$ji['nama'].'</option>';
                                        }
                                    ?>
                                </select>
                            </div>
                            <div class="col-md-offset-4 col-md-8"><div class="help-block with-errors"></div></div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group form-group-sm">
                            <label class="control-label col-md-4">Nama Penyidik</label>        
                            <div class="col-md-8">
                                <input type="text" name="nama_penyidik" id="nama_penyidik" class="form-control" value="<?php echo $model['nama_penyidik'];?>" maxlength="128" />
                            </div>
                            <div class="col-md-offset-4 col-md-8"><div class="help-block with-errors"></div></div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group form-group-sm">
                            <label class="control-label col-md-4">Tanggal Pelaksanaan</label>        
                            <div class="col-md-8">
                                <div class="input-group">
                                    <div class="input-group-addon"><i class="fa fa-calendar"></i></div>
                                    <input type="text" name="tgl_pelaksanaan" id="tgl_pelaksanaan" class="form-control datepicker" placeholder="DD-MM-YYYY" value="<?php echo $tgl_pelaksanaan;?>"/>
                                </div>
                            </div>
                            <div class="col-md-offset-4 col-md-8"><div class="help-block with-errors" id="error_custom_tglpelaksanaan"></div></div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group form-group-sm">
                            <label class="control-label col-md-4">NIP Penyidik</label>        
                            <div class="col-md-8">
                                <input type="text" name="nip_penyidik" id="nip_penyidik" class="form-control" value="<?php echo $model['nip_penyidik'];?>" maxlength="20" />
                            </div>
                            <div class="col-md-offset-4 col-md-8"><div class="help-block with-errors"></div></div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-offset-6 col-md-6">
                        <div class="form-group form-group-sm">
                            <label class="control-label col-md-4">Jabatan</label>        
                            <div class="col-md-8">
                                <input type="text" name="jabatan_penyidik" id="jabatan_penyidik" class="form-control" value="<?php echo $model['jabatan_penyidik'];?>" maxlength="200" />
                            </div>
                            <div class="col-md-offset-4 col-md-8"><div class="help-block with-errors"></div></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="box box-primary">
            <div class="box-body">
                <div class="row">
                    <div class="col-md-8">
                        <div class="form-group form-group-sm">
                            <label class="control-label col-md-3">Konsultasi Formil</label>        
                            <div class="col-md-9">
                                <textarea style="height:150px" name="konsultasi_formil" id="konsultasi_formil" class="form-control"><?php echo $model['konsultasi_formil'];?></textarea>
                            </div>
                            <div class="col-md-offset-4 col-md-8"><div class="help-block with-errors"></div></div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-8">
                        <div class="form-group form-group-sm">
                            <label class="control-label col-md-3">Konsultasi Materil</label>        
                            <div class="col-md-9">
                                <textarea style="height:150px" name="konsultasi_materil" id="konsultasi_materil" class="form-control"><?php echo $model['konsultasi_materil'];?></textarea>
                            </div>
                            <div class="col-md-offset-4 col-md-8"><div class="help-block with-errors"></div></div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-8">
                        <div class="form-group form-group-sm">
                            <label class="control-label col-md-3">Kesimpulan</label>        
                            <div class="col-md-9">
                                <textarea style="height:150px" name="kesimpulan" id="kesimpulan" class="form-control"><?php echo $model['kesimpulan'];?></textarea>
                            </div>
                            <div class="col-md-offset-4 col-md-8"><div class="help-block with-errors"></div></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
	
<hr style="border-color: #c7c7c7;margin: 10px 0;">
<div class="box-footer" style="text-align: center;"> 
	<input type="hidden" name="tgl_spdp" id="tgl_spdp" value="<?php echo date("d-m-Y", strtotime($_SESSION["tgl_spdp"]));?>" />
    <input type="hidden" name="isNewRecord" id="isNewRecord" value="<?php echo $isNewRecord;?>" />
    <button class="btn btn-warning jarak-kanan" type="submit" name="simpan" id="simpan" value="simpan"><?php echo ($isNewRecord)?'Simpan':'Ubah';?></button>
	<a class="btn btn-danger" href="<?php echo $linkBatal;?>">Batal</a>
</div>
</form>

<style>
	h3.box-title{
		font-weight: bold;
	}
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
	fieldset.scheduler-border{
		border: 1px solid #ddd;
		margin:0;
		padding:10px;
	}
	legend.scheduler-border{
		border-bottom: none;
		width: inherit;
		margin:0;
		padding:0px 5px;
		font-size: 14px;
		font-weight: bold;
	}
</style>
<script type="text/javascript">
$(document).ready(function(){
	
});
	
</script>
<?php } ?>
<?php
	use yii\helpers\Html;
	use yii\widgets\ActiveForm;
	use yii\bootstrap\Modal;
	use yii\widgets\Pjax;
	use yii\grid\GridView;
	use app\modules\pidsus\models\PdsPenyelesaianPratut;

	$this->title = 'Penyelesaian Pra Penuntutan';
	$this->params['idtitle'] = Yii::$app->inspektur->getHeaderPraPenuntutan();
	$whereDefault 	= "a.id_kejati = '".$_SESSION["kode_kejati"]."' and a.id_kejari = '".$_SESSION["kode_kejari"]."' and a.id_cabjari = '".$_SESSION["kode_cabjari"]."' 
						and a.no_spdp = '".$_SESSION["no_spdp"]."' and a.tgl_spdp = '".$_SESSION["tgl_spdp"]."'";
	$linkBatal		= '/pidsus/pds-penyelesaian-pratut/index';
	$linkCetak		= '/pidsus/pds-penyelesaian-pratut/cetak';
	$tgl_surat 		= ($model['tgl_surat'])?date('d-m-Y',strtotime($model['tgl_surat'])):'';
	$tgl_berkas 	= ($model['tgl_berkas'])?date('d-m-Y',strtotime($model['tgl_berkas'])):'';
	$tgl_terima 	= ($model['tgl_terima'])?date('d-m-Y',strtotime($model['tgl_terima'])):'';
?>

<?php if($_SESSION['no_spdp'] && $_SESSION['tgl_spdp']){ ?>
<form id="role-form" name="role-form" class="form-validasi form-horizontal" method="post" action="/pidsus/pds-penyelesaian-pratut/simpan" enctype="multipart/form-data">
<input type="hidden" name="_csrf" value="<?=Yii::$app->request->getCsrfToken()?>" />
	
<div class="row">        
    <div class="col-md-12">
        <div class="box box-primary">
            <div class="box-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group form-group-sm">
                            <label class="control-label col-md-4">Nomor Berkas</label>        
                            <div class="col-md-8">
                                <input readonly=""type="text" name="no_berkas" id="no_berkas" class="form-control" value="<?php echo $model['no_berkas'];?>" required data-error="Berkas belum diisi" maxlength="50" />
                                <div class="help-block with-errors"></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group form-group-sm">
                            <label class="control-label col-md-4">Tanggal Berkas</label>        
                            <div class="col-md-8">
                                <div class="input-group">
                                    <div class="input-group-addon"><i class="fa fa-calendar"></i></div>
                                    <input readonly=""type="text" name="tgl_berkas" id="tgl_berkas" class="form-control" value="<?php echo $tgl_berkas;?>" required data-error="Tanggal Berkas belum diisi" maxlength="50" />
                                </div>
                                <div class="help-block with-errors"></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group form-group-sm">
                            <label class="control-label col-md-4">Tanggal Terima</label>        
                            <div class="col-md-8">
                                <div class="input-group">
                                    <div class="input-group-addon"><i class="fa fa-calendar"></i></div>
                                    <input readonly=""type="text" name="tgl_terima" id="tgl_terima" class="form-control" value="<?php echo $tgl_terima;?>" required data-error="Tanggal Terima Berkas belum diisi" maxlength="50" />
                                </div>
                                <div class="help-block with-errors"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="box box-primary">
    <div class="box-header with-border">
        <h3 class="box-title">Tersangka</h3>
    </div>
    <div class="box-body">
        <div class="table-responsive">
            <table class="table table-bordered table-hover">
                <thead>
                    <tr>
                        <th class="text-center" width="8%">No</th>
                        <th class="text-center" width="35%">Nama</th>
                        <th class="text-center" width="27%">Tempat &amp; Tanggal Lahir</th>
                        <th class="text-center" width="15%">Jenis Kelamin</th>
                        <th class="text-center" width="15%">Umur</th>
                    </tr>
                </thead>
                <tbody>
                <?php 
                    $sqlnya = "select distinct a.no_urut, a.nama, a.tmpt_lahir, to_char(a.tgl_lahir, 'DD-MM-YYYY') as tgl_lahir, a.id_jkl, a.umur 
								from pidsus.pds_terima_berkas_tersangka a where ".$whereDefault." and a.no_berkas = '".$model['no_berkas']."' order by a.no_urut";
                    $hasil1 = PdsPenyelesaianPratut::findBySql($sqlnya)->asArray()->all();
                    if(count($hasil1) == 0)
                        echo '<tr><td colspan="5">Data tidak ditemukan</td></tr>';
                    else{
                        $ajk = array(1=>"Laki-laki", "Perempuan");
						$nom = 0;
                        foreach($hasil1 as $data1){
                 ?>	
                      <tr>
                        <td class="text-center"><?php echo $data1['no_urut'];?></td>
                        <td class="text-left"><?php echo $data1['nama'];?></td>
                        <td class="text-left"><?php echo $data1['tmpt_lahir'].', '.$data1['tgl_lahir'];?></td>
                        <td class="text-left"><?php echo $ajk[$data1['id_jkl']];?></td>
                        <td class="text-left"><?php echo ($data1['umur']?$data1['umur'].' Tahun':'');?></td>
                     </tr>
                 <?php } } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>			

<div class="box box-primary">
    <div class="box-body">
        <div class="row">
            <div class="col-md-6">
                <div class="form-group form-group-sm">
                    <label class="control-label col-md-4">Status</label>
                    <div class="col-md-8">
                        <select name="status" id="status" class="select2" style="width:100%" required data-error="Status belum diisi">
                            <option></option>
                            <option value="1" <?php echo ($model['status'] == 1)?'selected':'';?>>Lanjut Ke Penuntutan</option>
                            <option value="2" <?php echo ($model['status'] == 2)?'selected':'';?>>Diversi</option>
                            <option value="3" <?php echo ($model['status'] == 3)?'selected':'';?>>SP-3</option>
                            <option value="4" <?php echo ($model['status'] == 4)?'selected':'';?>>Optimal</option>
                        </select>
                        <div class="help-block with-errors"></div>
                    </div>
                </div>
            </div>
		</div>
		<div class="row jaksa" <?php echo ($model['status'] == 3)?'':'hidden=""';?>>
            <div class="col-md-6">
                <div class="form-group form-group-sm">
                    <label class="control-label col-md-4">Sikap Jaksa</label>
                    <div class="col-md-8">
                        <input type="radio" name="sikap_jpu" id="sikap_jpu[1]" value="1" <?php echo ($model["sikap_jpu"] == "1")?'checked':'';?> />
                        <label for="sikap_jpu[1]" class="control-label jarak-kanan">Tepat</label>

                        <input type="radio" name="sikap_jpu" id="sikap_jpu[2]" value="2" <?php echo ($model["sikap_jpu"] == "2")?'checked':'';?> />
                        <label for="sikap_jpu[2]" class="control-label">Tidak Tepat</label>
                        <div class="help-block with-errors"></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row surat" <?php echo (in_array($model['status'],array("2","3","4")))?'':'hidden=""';?>>
            <div class="col-md-6">
                <div class="form-group form-group-sm">
                    <label class="control-label col-md-4">Nomor</label>        
                    <div class="col-md-8">
                        <input type="text" name="nomor" id="nomor" class="form-control" value="<?php echo $model['nomor'];?>" maxlength="50" />
                        <div class="help-block with-errors"></div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group form-group-sm">
                    <label class="control-label col-md-4">Tanggal</label>        
                    <div class="col-md-8">
                        <div class="input-group">
                            <div class="input-group-addon"><i class="fa fa-calendar"></i></div>
                            <input type="text" name="tgl_surat" id="tgl_surat" class="form-control datepicker" value="<?php echo $tgl_surat;?>" />
                        </div>
                        <div class="help-block with-errors"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row surat" <?php echo (in_array($model['status'],array("2","3","4")))?'':'hidden=""';?>>
    <div class="col-md-12">
        <div class="form-group form-group-sm">
            <div class="col-md-12">
                <input type="file" name="file_template" id="file_template" class="form-inputfile" />                    
                <label for="file_template" class="label-inputfile">
                    <?php 
                        $pathFile 	= Yii::$app->params['penyelesaian_pratut'].$model['file_upload_penyelesaian_pratut'];
                        $labelFile 	= 'Pilih File Penyelesaian Pratut';
                        if($model['file_upload_penyelesaian_pratut'] && file_exists($pathFile)){
                            $labelFile 	= 'Ubah File Penyelesaian Pratut';
                            $param1  	= chunk_split(base64_encode($pathFile));
                            $param2  	= chunk_split(base64_encode($model['file_upload_penyelesaian_pratut']));
                            $linkPt 	= "/pidsus/download-file/index?id=".$param1."&fn=".$param2;
                            $extPt		= substr($model['file_upload_penyelesaian_pratut'], strrpos($model['file_upload_penyelesaian_pratut'],'.'));
                            echo '<a href="'.$linkPt.'" title="'.$model['file_upload_penyelesaian_pratut'].'" style="float:left; margin-right:10px;">
                            <img src="'.Yii::$app->inspektur->getIconFile($extPt).'" /></a>';
                        }
                    ?>
                    <div class="input-group">
                        <div class="input-group-addon btn-blue"><i class="fa fa-upload jarak-kanan"></i><?php echo $labelFile;?></div>
                        <input type="text" class="form-control" readonly />
                    </div>
                    <div class="help-block with-errors" id="error_custom_file_template"></div>
                </label>
            </div>
        </div>
    </div>
</div>
	
<hr style="border-color: #c7c7c7;margin: 10px 0;">
<div class="box-footer" style="text-align: center;"> 
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
	$('#status').on('change',function(){
		var status = $(this).val();
		if(status == 1 || status == ""){
			$('.surat').hide();
			$('.jaksa').hide();
			$('#tgl_surat').val("");
			$('#nomor').val("");
			$('#file_template').val('');
			$("[name='sikap_jpu']").iCheck("uncheck");
		} else if(status == 2){
			$('.surat').show();
			$('.jaksa').hide();
			$("[name='sikap_jpu']").iCheck("uncheck");
		} else if(status == 3){
			$('.surat').show();
			$('.jaksa').show();
		} else if(status == 4){
			$('.surat').show();
			$('.jaksa').hide();
			$("[name='sikap_jpu']").iCheck("uncheck");
		}
	});

});	
</script>
<?php } ?>
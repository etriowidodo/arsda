<?php
	use yii\helpers\Html;
	use yii\widgets\ActiveForm;
?>
<form id="role-form" name="role-form" class="form-validasi form-horizontal" method="post" action="/pidsus/template-surat/simpan" enctype="multipart/form-data">
<input type="hidden" name="_csrf" value="<?=Yii::$app->request->getCsrfToken()?>" />
<div style="border-color: #f39c12;padding: 15px;overflow: hidden;" class="box box-primary">
    <div class="row">
        <div class="col-md-12">
            <div class="form-group">
                <label class="control-label col-md-2">Kode</label>
                <div class="col-md-2">
                	<input type="text" name="kode_template_surat" id="kode_template_surat" value="<?php echo $model['kode_template_surat']; ?>" class="form-control" required data-error="Kode template surat belum diisi" <?php echo (!$isNewRecord?'readonly':''); ?> />
				</div>
                <div class="col-md-offset-2 col-md-12"><div class="help-block with-errors" id="kodenya"></div></div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="form-group">
                <label class="control-label col-md-2">Deskripsi</label>
                <div class="col-md-6">
                    <input type="text" name="deskripsi_template_surat" id="deskripsi_template_surat" value="<?php echo $model['deskripsi_template_surat']; ?>" class="form-control" required data-error="Deskripsi template surat belum diisi" />
                	<div class="help-block with-errors"></div>
				</div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="form-group">
                <label class="control-label col-md-2">Template File</label>
                <div class="col-md-4">
                    <input type="file" name="file_template" id="file_template" class="form-inputfile" />                    
                    <label for="file_template" class="label-inputfile">
                        <?php 
							$pathFile 	= Yii::$app->params['pathTemplate'].$model['file_template_surat'];
							$labelFile 	= 'Pilih File';
							if($model['file_template_surat'] && file_exists($pathFile)){
								$labelFile 	= 'Ubah File';
								$param1  	= chunk_split(base64_encode($pathFile));
								$param2  	= chunk_split(base64_encode($model['file_template_surat']));
								$linkPt 	= "/pidsus/download-file/index?id=".$param1."&fn=".$param2;
								$extPt		= substr($model['file_template_surat'], strrpos($model['file_template_surat'],'.'));
								echo '<a href="'.$linkPt.'" title="'.$model['file_template_surat'].'" style="float:left; margin-right:10px;">
								<img src="'.Yii::$app->inspektur->getIconFile($extPt).'" /></a>';
							}
						?>
                        <div class="input-group">
                            <div class="input-group-addon btn-blue"><i class="fa fa-upload jarak-kanan"></i><?php echo $labelFile;?></div>
                            <input type="text" class="form-control" readonly />
                        </div>
                		<div class="help-block with-errors"></div>
                    </label>
				</div>
            </div>
        </div>
    </div>
</div>
<hr style="border-color: #c7c7c7;margin: 10px 0;">

<div class="box-footer text-center"> 
	<input type="hidden" name="isNewRecord" id="isNewRecord" value="<?php echo $isNewRecord;?>" />
    <button class="btn btn-warning jarak-kanan" type="submit" id="simpan" name="simpan"><?php echo ($isNewRecord)?'Simpan':'Ubah';?></button>
    <a href="/pidsus/template-surat/index" class="btn btn-danger">Batal</a>
</div>
</form>
<div class="modal-loading-new"></div>


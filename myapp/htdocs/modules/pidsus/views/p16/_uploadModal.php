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
<form id="role-form-modal-upload" name="role-form-modal-upload" class="form-validasi form-horizontal" method="post" enctype="multipart/form-data">
<input type="hidden" name="_csrf" value="<?=Yii::$app->request->getCsrfToken()?>" />
<div class="row">
    <div class="col-md-12">
        <div class="form-group form-group-sm">
            <div class="col-md-12">
                <input type="file" name="file_template" id="file_template" class="form-inputfile" />                    
                <label for="file_template" class="label-inputfile">
                    <?php 
                        $pathFile 	= Yii::$app->params['p16'].$model['file_upload_p16'];
                        $labelFile 	= 'Unggah File P-16';
                        if($model['file_upload_p16'] && file_exists($pathFile)){
                            $labelFile 	= 'Ubah File P-16';
                            $param1  	= chunk_split(base64_encode($pathFile));
                            $param2  	= chunk_split(base64_encode($model['file_upload_p16']));
                            $linkPt 	= "/pidsus/download-file/index?id=".$param1."&fn=".$param2;
                            $extPt		= substr($model['file_upload_p16'], strrpos($model['file_upload_p16'],'.'));
                            echo '<a href="'.$linkPt.'" title="'.$model['file_upload_p16'].'" style="float:left; margin-right:10px;">
                            <img src="'.Yii::$app->inspektur->getIconFile($extPt).'" /></a>';
                        }
                    ?>
                    <div class="input-group">
                        <div class="input-group-addon btn-blue"><i class="fa fa-upload jarak-kanan"></i><?php echo $labelFile;?></div>
                        <input type="text" class="form-control" readonly />
                    </div>
					<h6 style="margin:5px 0px;">[ Tipe file .doc, .docx, .pdf, .jpg dengan ukuran maks. 2Mb]</h6>
                    <div class="help-block with-errors" id="error_custom_file_template"></div>
                </label>
            </div>
        </div>
    </div>
</div>

<hr style="border-color: #c7c7c7;margin: 10px 0;">
<div class="box-footer" style="text-align: center;"> 
	<input type="hidden" name="id_kejati" id="id_kejati" value="<?php echo $model['id_kejati'];?>" />
	<input type="hidden" name="id_kejari" id="id_kejari" value="<?php echo $model['id_kejari'];?>" />
	<input type="hidden" name="id_cabjari" id="id_cabjari" value="<?php echo $model['id_cabjari'];?>" />
	<input type="hidden" name="no_spdp" id="no_spdp" value="<?php echo $model['no_spdp'];?>" />
	<input type="hidden" name="tgl_spdp" id="tgl_spdp" value="<?php echo $model['tgl_spdp'];?>" />
	<input type="hidden" name="no_p16" id="no_p16" value="<?php echo $model['no_p16'];?>" />
    <button class="btn btn-warning btn-sm jarak-kanan" type="button" name="simpanUpload" id="simpanUpload" value="simpan">Upload</button>
	<a data-dismiss="modal" class="btn btn-danger btn-sm"><i class="fa fa-reply jarak-kanan"></i>Batal</a>
</div>
</form>
<div class="modal-loading-new"></div>
</div>
<style>
	#wrapper-modal-tsk.loading {overflow: hidden;}
	#wrapper-modal-tsk.loading .modal-loading-new {display: block;}
</style>

<script type="text/javascript">
$(document).ready(function(){
	$(".form-inputfile").each(function(){
		var $input = $(this), 
			$label = $input.next("label"), 
			labelVal = $label.html();
		$input.on('change', function(e){
			var fileName = e.target.value.split( '\\' ).pop();
			if(fileName) $label.find("input").val(fileName);
		});
	});	
});
</script>

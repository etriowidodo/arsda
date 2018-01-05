
<?php

	use yii\helpers\Html;
	use app\modules\datun\models\searchs\Menu as MenuSearch;
	use yii\widgets\ActiveForm;

	
 	if($model->isNewRecord){
		$this->title = 'MASTER';
		$this->subtitle = 'UBAH JENIS INSTANSI';
		$this->params['breadcrumbs'][] = $this->title;
	} else{
		$this->title = 'MASTER';
		$this->subtitle = 'JENIS INSTANSI';
		$this->params['breadcrumbs'][] = $this->title;
	} 	
	
	
/* 	 $this->subtitle = 'TAMBAH JENIS INSTANSI';
	 $this->title = 'MASTER';  */
	 
?>

<form id="role-form" name="role-form" style=" padding: 1px;" class="form-validasi form-horizontal" method="post" action="/datun/instansi/simpanjenis">
<input type="hidden" name="_csrf" value="<?=Yii::$app->request->getCsrfToken()?>" />
<div style="border-color: #f39c12; padding: 15px; overflow: hidden;"  class="box box-primary col-md-5">
    <div class="row">
        <div class="col-md-8 " >
            <div class="form-group"  style="margin: 0px">
                <label class="control-label col-md-4">Kode</label>
                <div class="col-md-4">
				<input type="text" name="kode_jenis_instansi" id="kode_jenis_instansi" maxlength="2"  class="form-control" value="<?php echo $kode1; ?>" required data-error="Kode Jenis Instansi belum diisi" />                
				<div class="help-block with-errors"></div>
				</div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-8" style="margin: 0px" >
            <div class="form-group" style="margin: 0px">
                <label class="control-label col-md-4">Description</label>
                <div class="col-md-8">
                	<input type="text" name="deskripsi_jnsinstansi" id="deskripsi_jnsinstansi" value="<?php echo $desc; ?>" class="form-control" required data-error="Description belum diisi" />
                	<div class="help-block with-errors"></div>
					<input type="hidden" name="status" id="status"/>
				</div>
            </div>
        </div>
    </div>
</div>
<div id="preview-menu"></div>

<hr style="border-color: #c7c7c7;margin: 10px 0;">

<div class="box-footer text-center"> 
    <button class="btn btn-warning" type="submit" id="simpan" style="display: inline-block;"><i class="fa fa-floppy-o" aria-hidden="true"></i> <?php echo ($model->isNewRecord)?'Simpan':'Simpan';?></button>
	<a href="/datun/instansi/index"  class="btn btn-danger" data-dismiss="modal" ><i class="fa fa-ban" aria-hidden="true"></i> Batal</a>
	<!--<button type="button" data-dismiss="modal" class="btn btn-danger" style="display: inline-block;">Batal</button> -->
</div>
</form>
<div class="modal-loading-new"></div>

<script type="text/javascript">

$(document).ready(function(){
$('#role-form').validator('update')
var ckode = document.getElementById('deskripsi_jnsinstansi').value;
		if(ckode==''){
			$("#status").attr("value",'0');								
					document.getElementById('kode_jenis_instansi').readOnly  = false;	
					
		}else{
			$("#status").attr("value",'1');
			document.getElementById('kode_jenis_instansi').readOnly =true;
		
			
		}
});


</script>





<?php
	use yii\helpers\Html;
	use app\modules\datun\models\searchs\Menu as MenuSearch;
	use yii\widgets\ActiveForm;
	
	
 	if($model->isNewRecord){
		$this->title = 'MASTER';
		$this->subtitle = 'UBAH INSTANSI/BUMN/BUMD';
		$this->params['breadcrumbs'][] = $this->title;
	} else{
		$this->title = 'MASTER';
		$this->subtitle = ' INSTANSI/BUMN/BUMD';
		$this->params['breadcrumbs'][] = $this->title;
	} 	
	
	
/* 	 $this->subtitle = 'TAMBAH JENIS INSTANSI';
	 $this->title = 'MASTER';  */
	
?>
<form id="instansi-create" name="instansi-create" style=" padding: 1px;" class="form-validasi form-horizontal" method="post" action="/datun/instansi/simpaninstansi">
<input type="hidden" name="_csrf" value="<?=Yii::$app->request->getCsrfToken()?>" />
<div style="border-color: #f39c12; padding: 15px; overflow: hidden;"  class="box box-primary col-md-5">
    <div class="row">
        <div class="col-md-12 " >
            <div class="form-group" style="margin: 0px ; margin-bottom:10px"  >
                <label class="control-label col-md-4">Jenis Instansi</label>
                <div class="col-md-8"  >
					<div class="col-md-1" style="margin-left:-14px ; margin-right:25px" >
					<input style="width:60px" type="text" name="kode_jenis_instansi" id="kode_jenis_instansi" maxlength="2" value="<?php echo $kode1; ?>" class="form-control" /></input>
					</div>
					<div class="col-md-10"  style="margin-left: 0px"  >
					<p class="control-label " id="nama_jenis_instansi"  style="font-size:16px; color:#0066CC" align="left" ></p>	
					</div>
					
				
					<div class="help-block with-errors"></div>
				</div>
            </div>
        </div>
    </div>
	
    <div class="row">
        <div class="col-md-12 " >
            <div class="form-group"  style="margin: 0px">
                <label class="control-label col-md-4">Kode</label>
                <div class="col-md-8">
               	<input type="text" style="width:60px" name="kode_instansi" id="kode_instansi" maxlength="3" value="<?php echo $kode2; ?>"
				 class="form-control" required data-error="Kode Instansi belum diisi" />

					<div class="help-block with-errors"></div>
				</div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12" style="margin: 0px" >
            <div class="form-group" style="margin: 0px">
                <label class="control-label col-md-4">Description</label>
                <div class="col-md-8">
                	<input type="text" name="deskripsi_instansi" id="deskripsi_instansi" value="<?php echo $desc; ?>" class="form-control" required data-error="Description belum diisi" />
                	<div class="help-block with-errors"></div>
					<input type="hidden" name="status_instansi" id="status_instansi"/>
				
				</div>
            </div>
        </div>
    </div>
</div>
<div id="preview-menu"></div>

<hr style="border-color: #c7c7c7;margin: 10px 0;">

<div class="box-footer text-center"> 
    <button class="btn btn-warning" type="submit" style="display: inline-block;"><i class="fa fa-floppy-o" aria-hidden="true"></i> <?php echo ($model->isNewRecord)?'Simpan':'Simpan';?></button>
	<a href="<?php echo Yii::$app->request->baseUrl.'/datun/instansi/pilih_jenis?id='.$kode1;?>" class="btn btn-danger" type="button" data-dismiss="modal"><i class="fa fa-ban" aria-hidden="true"></i> Batal</a>

</div>
</form>
<div class="modal-loading-new"></div>


<script type="text/javascript">

$(document).ready(function(){
	
	$('#instansi-create').validator('update')
	    document.getElementById("nama_jenis_instansi").innerHTML="<?php echo $nmjns; ?>";

var ckode = document.getElementById('deskripsi_instansi').value;

	document.getElementById('kode_jenis_instansi').readOnly  = true;
		if(ckode==''){
			$("#status_instansi").attr("value",'0');
			document.getElementById('kode_instansi').readOnly  = false;
		}else{
			$("#status_instansi").attr("value",'1');
			document.getElementById('kode_instansi').readOnly =true;
			
		}
});

$(".select2").select2({		
		allowClear: true
	});
	
</script>



<?php
	use yii\helpers\Html;
//	use mdm\admin\models\searchs\Menu as MenuSearch;
	use yii\widgets\ActiveForm;
	use yii\bootstrap\Modal;
	use app\components\GlobalConstMenuComponent;
?>

<script type="text/javascript"> 
$(document).ready(function(){
	document.getElementById('st1').checked=true;
	document.getElementById('st2').checked=false;
	document.getElementById('st3').checked=false;
	document.getElementById('st4').checked=false;
	
		var kdx = document.getElementById('nip_jbt').value;

			if(kdx==''){
				$("#ttd").attr("value",'1');
				document.getElementById('nip_jbt').readOnly  = false;
				document.getElementById('nama_jbt').readOnly  = false;

			}else{
				$("#ttd").attr("value",'2');
				document.getElementById('nip_jbt').readOnly  = true;
				document.getElementById('nama_jbt').readOnly  = true;

			}
	
	});
		
function check()
	{
	
		var st1  = document.getElementById('st1').checked;
	    var st2  = document.getElementById('st2').checked;
		var st3  = document.getElementById('st3').checked;
		var st4  = document.getElementById('st4').checked;
		var st4  = document.getElementById('st4').checked;
		
		var nip   = document.getElementById('nip_jbt').value;
		var kode  = document.getElementById('kode1').value;
		
		var sts_ttd  = document.getElementById('ttd').value;
		
		if(st1==true && st2==false && st3==false && st4==false){
			stat='1';
		} else if(st1==false && st2==true && st3==false && st4==false){
			stat='2';
		} else if(st1==false && st2==false && st3==true && st4==false){
			stat='3';
		} else if(st1==false && st2==false && st3==false && st4==true){
			stat='4';
		}
		
		//alert(stat+'-'+nip+'-'+kode+'-'+sts_ttd);
		//exit();
		
		if(nip==''){
			$.notify('Maaf... NIP Belum Diisi', {type: 'danger', icon: 'fa fa-info', allow_dismiss: true, showProgressbar: false});
			document.getElementById('nip_jbt').focus;
			exit();
		}
		
		//alert(stat+'-'+nip+'-'+kode);
		//exit();
		
		$(function(){      
         $.ajax({
            type	: 'POST',
            data	: ({stptd:stat,nip_jbt:nip,kode1:kode,ttd:sts_ttd}),
            dataType:"json",
            url		: '<?php echo Yii::$app->request->baseUrl.'/datun/penandatanganjabatan/simpan'; ?>',         
         });
        });
		
	}

</script>

<form id="role-form" name="role-form" class="form-validasi form-horizontal" method="post" action="/datun/penandatanganjabatan/simpan">
<input type="hidden" name="_csrf" value="<?=Yii::$app->request->getCsrfToken()?>" />
<div style="border-color: #f39c12;padding: 15px;overflow: hidden;" class="box box-primary">
    
	<div class="row" type="hidden">
        <div class="col-md-8">
            <div class="form-group">
                <div class="col-md-2">
                	<input type="hidden" id="kode1" name="kode1" class="form-control " value="<?php echo $kode; ?>" readonly="readonly"/>			
				</div>
            </div>
        </div>
    </div>
	
	
    <div class="row">
        <div class="col-md-8">
            <div class="form-group">
                <label class="control-label col-md-4">NIP</label>
                <div class="col-md-8">
                	<input type="text" name="nip_jbt" id="nip_jbt" class="form-control" value="<?php echo $nip; ?>" required data-error="NIP belum diisi" />
                	<div class="help-block with-errors"></div>
					<input type="hidden" name="ttd" id="ttd"/>
				</div>
            </div>
        </div>
    </div>
	<div class="row">
        <div class="col-md-8">
            <div class="form-group">
                <label class="control-label col-md-4">Nama</label>
                <div class="col-md-8">
                	<input type="text" name="nama_jbt" id="nama_jbt" value="<?php echo $nmtd; ?>" class="form-control" required data-error="Nama belum diisi" />
                	<div class="help-block with-errors"></div>
				</div>
            </div>
        </div>
    </div>
	<div class="row">
        <div class="col-md-8">
            <div class="form-group">
                <label class="control-label col-md-4">Pangkat</label>
                <div class="col-md-8">
                	<input type="text" name="pkt_jbt" id="pkt_jbt" value="<?php echo $pktd; ?>" class="form-control" required data-error="Pangkat belum diisi" />
                	<div class="help-block with-errors"></div>
				</div>
            </div>
        </div>
    </div>
	<div class="row">
        <div class="col-md-8">
            <div class="form-group">
                <label class="control-label col-md-4">Jabatan</label>
                <div class="col-md-8">
                	<input type="text" name="jabatan_jbt" id="jabatan_jbt" value="<?php echo $jbtd; ?>" class="form-control" required data-error="Jabatan belum diisi" />
                	<div class="help-block with-errors"></div>
				</div>
            </div>
        </div>
    </div>
	<div class="row">
        <div class="col-md-8">
            <div class="form-group">
                <label class="control-label col-md-3">Status</label>
                <div class="col-md-8">
						<div class="col-md-12" style="padding-left:38px;">
							<label class="radio-inline">
							  <input type="radio" name="stptd" id="st1" value="1" >Asli &nbsp;&nbsp;&nbsp;
							  <input type="radio" name="stptd" id="st2" value="2" >Plt &nbsp;&nbsp;&nbsp;
							  <input type="radio" name="stptd" id="st3" value="3" >Plh &nbsp;&nbsp;&nbsp;
							  <input type="radio" name="stptd" id="st4" value="4" >A.n
							</label>
						</div>
				</div>
            </div>
        </div>
    </div>
</div>
<div id="preview-menu"></div>

<hr style="border-color: #c7c7c7;margin: 10px 0;">

<div class="box-footer text-center"> 
    <button class="btn btn-warning" type="submit" id="simpan" style="display: inline-block;" onclick="javascript:check();"><?php echo ($model->isNewRecord)?'Simpan':'Simpan';?></button>
    <a href="<?php echo Yii::$app->request->baseUrl.'/datun/penandatanganjabatan/index?id='.$kode;?>" class="btn btn-danger">Batal</a>
</div>
</form>
<div class="modal-loading-new"></div>

<?php
Modal::begin([
    'id' => '_m_jpu2',
    'header' => 'Data Penyidik',
    'options' => [
        'data-url' => '',
    ],
]);
?> 

<?=
$this->render('_m_jpu2', [
    'model' => $model,
    'searchJPU' => $searchJPU,
    'dataJPU' => $dataJPU,
])
?>

<?php
Modal::end();
?>  


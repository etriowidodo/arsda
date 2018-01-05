<?php
use app\components\GlobalConstMenuComponent;
use app\modules\pdsold\models\VwPenandatangan;
use yii\bootstrap\Modal;
?>

<div class="panel box box-warning">
        <div class="box-body">
            <div class="col-md-7 pull-right">

                <label class="control-label col-md-2" style="padding-right:0;margin-left:7%">Penanda Tangan</label>
                <div class="col-md-9 pull-right">
                    <?php
					//CMS_PIDUM04_P16_02 #dropdown penandatangan yang di tampilkan jabatannya #06062016
                    echo Yii::$app->globalfunc->returnDropDownList($form,$model, VwPenandatangan::find()->all(),'peg_nip_baru','jabatan','id_penandatangan')  ?> 
					<input type="hidden" name="hdn_nama_penandatangan" id="hdn_nama_penandatangan" />
					<input type="hidden" name="hdn_pangkat_penandatangan" id="hdn_pangkat_penandatangan" />
					<input type="hidden" name="hdn_jabatan_penandatangan" id="hdn_jabatan_penandatangan" />
					<div></div><span class="input-group-addon icon-arrow"><i class="fa fa-fw fa-ellipsis-h"></i></span>                   
                </div>
            </div>
        </div>
        <div class="box-body">   
        
            <div class="col-md-8 pull-left">   
                <?= Yii::$app->globalfunc->getTembusan($form,$GlobalConst,$this,$id_table, '') ?>

            </div>
        </div>
    
</div>
<?php $arrow =  'http://'.$_SERVER['HTTP_HOST'].'/image/elips.png';?>
   <?php

$this->registerJs(\yii\web\View::POS_BEGIN);
$js1 = <<< JS

$('#m_tanda_tangan').insertAfter($('form'));
id_select = $('select[peg_nip_baru=jabatan]').attr('id');
     $('#'+id_select).css('cursor','pointer');
     $('#'+id_select).css('pointer-events','pointer');
     $('#'+id_select).css('-webkit-appearance','none');
     $('#'+id_select).css('-moz-appearance','none');
     $('#'+id_select).css('text-indent','1px');
     $('#'+id_select).css('text-overflow','');
     $('#'+id_select).parent().addClass('input-group');
     $('.icon-arrow').css('cursor','pointer');
     $('.icon-arrow').insertAfter($('#'+id_select));

$('select[peg_nip_baru=jabatan],.icon-arrow').on('click',function(){
    id = $('select[peg_nip_baru=jabatan]').attr('id');
    $('#'+id+' option').hide();
    $('#m_tanda_tangan').html('');
    $('#m_tanda_tangan').load('/pdsold/default/popup-penanda-tangan');
    $('#m_tanda_tangan').modal('show');
	$('#m_tanda_tangan').appendTo("body").modal('show');
});

   
JS;
$this->registerJs($js1);

?>
<?php
//ActiveForm::end(); 
Modal::begin([
    'id' => 'm_tanda_tangan',
    'header' => '<h7>Data Tersangka</h7>',
	'clientOptions' => ['backdrop' => 'static', 'keyboard' => false] 
]);
Modal::end();
?>


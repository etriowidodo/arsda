<?php
use app\components\GlobalConstMenuComponent;
use app\modules\pidum\models\VwPenandatangan;
use yii\bootstrap\Modal;
?>

<div class="panel box box-warning">
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
    $('#m_tanda_tangan').load('/pidum/default/popup-penanda-tangan');
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


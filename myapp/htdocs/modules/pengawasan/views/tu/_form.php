<?php

use yii\helpers\Html;
use kartik\datecontrol\DateControl;
use kartik\widgets\ActiveForm;
use kartik\widgets\DatePicker;
use kartik\grid\GridView;
use kartik\grid\DataColumn;
use yii\helpers\ArrayHelper;
use yii\bootstrap\Modal;
use kartik\widgets\FileInput;
use yii\helpers\Url;
use yii\web\View;
/* @var $this yii\web\View */
/* @var $model app\models\Was1 */
/* @var $form yii\widgets\ActiveForm */
?>

 <?php //$form = ActiveForm::begin(); ?>

 <!--<?//= $form->field($model, 'was1_perihal')->textarea(['rows' => 3])?>-->


            <!--  -->

        </div>
        <hr style="border-color: #c7c7c7;margin: 10px 0;"> 
        <div class="box-footer" style="margin:0px;padding:0px;background:none;">
            <!--<?= Html::submitButton($model->isNewRecord ? 'Simpan' : 'Simpan', ['class' => $model->isNewRecord ? 'btn btn-primary' : 'btn btn-primary']) ?>-->
            <input action="action" type="button" value="Kembali" class="btn btn-primary" onclick="history.go(-1);" />
            <?php //if (!$model->isNewRecord) { ?> 
          
            <?= Html::Button('Hapus', ['class' => 'hapuswasform btn btn-primary','url'=>Url::to('pengawasan/was1/delete', true),'namaform'=>'was1-form']) ?>
            <?= Html::Button('Cetak', ['class' => 'cetakwas btn btn-primary']) ?>
              <?php //echo $form->field($model, 'id_was_1')->hiddenInput(['name'=>'id']) ?>
            <?php //} ?>
        </div>
        <?php //ActiveForm::end(); ?>

<script type="text/javascript">
    $('#btn0').click(function(){
         $.ajax({
            type:'POST',
            url:'/pengawasan/was1/pemeriksa',
            // data:'id='+id,
            // success:function(data){
            // // $('#KejagungToBidang').html(data);
            
            // alert(data);
            // }
            });
    });
</script>
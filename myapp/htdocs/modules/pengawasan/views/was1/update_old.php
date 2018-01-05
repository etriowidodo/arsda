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

$this->title = 'WAS1';
$this->subtitle = 'TELAAHAN';
$this->params['ringkasan_perkara'] = $model->no_register;
$this->params['breadcrumbs'][] = ['label' => 'Was1s', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id_was1, 'url' => ['view', 'id' => $model->id_was1]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="was1-update">
<div class="box box-primary" style="overflow:hidden;padding:10px 0px 15px 0px;">
            <?php
            $form = ActiveForm::begin([
                        'id' => 'was1-form',
                        'type' => ActiveForm::TYPE_HORIZONTAL,
                        'enableAjaxValidation' => false,
                        'fieldConfig' => [
                            'autoPlaceholder' => false
                        ],
                        'formConfig' => [
                            'deviceSize' => ActiveForm::SIZE_SMALL,
                            'showLabels' => false
                        ],
                        'options' => [
                            'enctype' => 'multipart/form-data',
                        ]
            ]);
            ?>
            <?php if (!$model->isNewRecord) { ?>
                <?php echo $form->field($model, 'id_was_1')->hiddenInput(); ?>
            <?php } ?>


            <div class="col-md-12">
                 <!-- <div class="col-md-10"> -->
                    <div class="form-group">
                        <!-- <label class="control-label col-md-2"></label> -->
                    <div class="col-md-12">
                         <fieldset class="group-border">
                            <legend class="group-border">Dari Siapa Ke siapa</legend>
                        <?php
                        $list = [0 => 'PEMERIKSA -> IRMUD', 1 => 'IRMUD -> INSPEKTUR',
                         2 => 'INSPEKTUR -> JAMWAS'];
                         echo $form->field($model, 'id_saran')->radioList($list,[
                                'item' => function($index, $label, $name, $checked, $value) {

                                    $return = '<label class="modal-radio">';
                                    $return .= '<input type="radio" name="' . $name . '" value="' . $value . '" tabindex="3" id="btn'.$value.'">';
                                    $return .= '<i></i>';
                                    $return .= '<span> ' . ucwords($label) . ' </span>';
                                    $return .= '</label>';

                                    return $return;
                                }
                            ]); 

                         
                         ?>

                         </fieldset>
                    </div>
                    </div>
                <!-- </div> -->

            </div>
   

    <?= $this->render('_form_pemeriksa', [
        'model' => $model,
        'modelLapdu' => $modelLapdu,
        'modelTerlapor' => $modelTerlapor,
    ]) ?>

</div>
<style type="text/css">
fieldset.group-border {
    border: 1px groove #ddd !important;
    padding: 0 1.4em 1.4em 1.4em !important;
    margin: 0 0 1.5em 0 !important;
    -webkit-box-shadow:  0px 0px 0px 0px #000;
            box-shadow:  0px 0px 0px 0px #000;
}
legend.group-border {
    width:inherit; /* Or auto */
    padding:0 10px; /* To give a bit of padding on the left and right */
    border-bottom:none;
    font-size: 14px;
}
</style>

            <!--  -->

        </div>
        <hr style="border-color: #c7c7c7;margin: 10px 0;"> 
        <div class="box-footer" style="margin:0px;padding:0px;background:none;">
            <?= Html::submitButton($model->isNewRecord ? 'Simpan' : 'Simpan', ['class' => $model->isNewRecord ? 'btn btn-primary' : 'btn btn-primary']) ?>
            <?= Html::Button('Kembali', ['class' => 'tombolbatal btn btn-primary','value'=>$was_register]) ?>
            <?php if (!$model->isNewRecord) { ?> 
          
            <?= Html::Button('Hapus', ['class' => 'hapuswasform btn btn-primary','url'=>Url::to('pengawasan/was1/delete', true),'namaform'=>'was1-form']) ?>
            <?= Html::Button('Cetak', ['class' => 'cetakwas btn btn-primary']) ?>
              <?php echo $form->field($model, 'id_was_1')->hiddenInput(['name'=>'id']) ?>
            <?php } ?>
        </div>
        <?php ActiveForm::end(); ?>
       

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

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
use kartik\widgets\Select2;
use yii\db\Query;
use yii\db\Command;
/* @var $this yii\web\View */
/* @var $model app\modules\pengawasan\models\InspekturModel */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="wilayah-inspektur-master-form">

    <?php 
      //  $form = ActiveForm::begin(); 

      $form = ActiveForm::begin([
               // 'id' => 'was1-form',
                // 'action' => '/pengawasan/was1/create',
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


    <div class="content-wrapper-1">
    <div class="box box-primary" style="padding: 15px;overflow: hidden;">
         <div class="col-md-8">
            <div class="form-group">
                <label class="col-md-2">Wilayah <?php // print_r($model->id_wilayah); ?></label>
                <div class="col-md-6">
															
                    <select id="wil" name="id_wilayah" class="form-control" style="margin-bottom:15px" <?php echo (!$model->isNewRecord)?'readonly':'' ;?>  >
                        <option >-- Pilih --</option>
                        <?php
                        $connection = \Yii::$app->db;   
                        $wil = "select * from was.wilayah where id_wilayah in('0','1') order by id_wilayah";
                        $wilayah = $connection->createCommand($wil)->queryAll();
                        
                        foreach ($wilayah as $key) {
                          echo "<option value='".$key['id_wilayah']."' ".($model->id_wilayah == $key['id_wilayah'] ? 'selected':'' )." readonly>".$key['nama_wilayah']."</option>";
                        }
                        ?>
                    </select>
                  
                </div>
            </div>
        </div>

        <div class="col-md-8">
            <div class="form-group">
                <label class="col-md-2">Kejati</label>
                <div class="col-md-6">
                     <select id="kejati" name="id_kejati" class="form-control" style="margin-bottom:15px" <?php echo (!$model->isNewRecord)?'readonly':'' ;?>  >
                        <option  >-- Pilih --</option>
                        <option  selected="selected"> <?= $model->nama_kejati ?></option>

                    </select>

                    <?//= $form->field($model, 'id_kejati')->textInput(['maxlength' => true])->label(false); ?>
                </div>
            </div>
        </div>

         <div class="col-md-8">
            <div class="form-group">
                <label class="col-md-2">Inspektur</label>
                <div class="col-md-6">
                     <select class="form-control" name="id_inspektur" id="id_ins" style="margin-bottom:15px">
                        <option  selected>-- Pilih --</option>
                        <?php
                        $connection = \Yii::$app->db;   
                        
                        $wil = "select * from was.inspektur order by id_inspektur";
                        $wilayah = $connection->createCommand($wil)->queryAll();
                        
                        foreach ($wilayah as $key) {
                          echo "<option value='".$key['id_inspektur']."' ".($model->id_inspektur == $key['id_inspektur'] ? 'selected':'' ).">".$key['nama_inspektur']."</option>";
                        }
                        ?>
                    </select>
                    <?//= $form->field($model, 'id_inspektur')->textInput(['maxlength' => true])->label(false); ?>
                </div>
            </div>
        </div>
         <?= $form->field($model, 'id_inspektur')->hiddenInput(); ?>
		        
    
</div>
    <div class="form-group" style="text-align: center;">
        <?= Html::submitButton($model->isNewRecord ? 'Simpan' : 'Ubah', ['class' => $model->isNewRecord ? 'btn btn-primary' : 'btn btn-primary']) ?>
        <input action="action" type="button" value="Kembali" class="btn btn-primary" onclick="history.go(-1);" />
    </div>



</div>
    <?php ActiveForm::end(); ?>
</div>
<script type="text/javascript">
$(document).ready(function(){
    $("#wil").change(function(){
    var wilayah = $("#wil").val();

    // alert(wilayah);
    $.ajax({
            type:'POST',
            url:'/pengawasan/wilayah-inspektur/kejagung',
            data:'id='+wilayah,
            success:function(data){
            $('#kejati').html(data);
            // alert(data);
            }
            });
     
    });    

    $("#id_ins").change(function(){
        var inspektur = $(this).val();
        $("#wilayahinspektur-id_inspektur").val(inspektur);
    });    
});
</script>
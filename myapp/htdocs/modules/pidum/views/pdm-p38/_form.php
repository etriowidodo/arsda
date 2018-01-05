<?php

use app\modules\pidum\models\PdmMsStatusData;
use app\modules\pidum\models\PdmP37;
use app\modules\pidum\models\PdmP38;
use app\modules\pidum\models\VwPenandatangan;
use app\modules\pidum\models\VwTerdakwaT2;
use kartik\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;

/* @varkartik $this yii\web\View */
/* @var $model app\modules\pidum\models\PdmP38 */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="pdm-p38-form">

    <?php
    $form = ActiveForm::begin(
        [
            'id' => 'p38-form',
            'type' => ActiveForm::TYPE_HORIZONTAL,
            'enableAjaxValidation' => false,
            'fieldConfig' => [
                'autoPlaceholder' => false
            ],
            'formConfig' => [
                'deviceSize' => ActiveForm::SIZE_SMALL,
                'labelSpan' => 2,
                'showLabels' => false

            ]
        ]);
    ?>
    
    <div class="col-sm-12">
        <?= $this->render('//default/_formHeaderV', ['form' => $form, 'model' => $model, 'kode'=>'_p38']) ?>
    </div>
    
    <div class="col-sm-12">
        <div class="box box-warning">
            <div class="box-header">
                <h3 class="box-title">
                    
                </h3>
            </div>
            <div class="box-body">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="control-label col-sm-2">Panggilan</label>
                                <div class="col-sm-2">
                                    <?php 
                                        $items = ArrayHelper::map(PdmMsStatusData::findAll(['is_group' => 'P-37', 'flag'=>1]), 'id', 'nama');
                                        echo $form->field($model, 'id_msstatusdata')->radioList($items, ['inline'=>false, 'class' => 'panggilan']); 
                                    ?>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="control-label col-sm-2">Keperluan</label>
                                <div class="col-sm-5" >
                                    <?php 
                                        $items1 = ArrayHelper::map(PdmMsStatusData::findAll(['is_group' => 'P-38', 'flag'=>1]), 'id', 'nama');
                                        echo $form->field($model, 'id_ms_sts_data')->radioList($items1, ['inline'=>false]); 
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <br/>
                <div class="row" hidden id="tb_terdakwa">
                    <div class="col-sm-12">
                        <div class="col-sm-6">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>Nama Terdakwa</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php 
                                        foreach ($vw_terdakwa as $value){
                                                echo "<tr><td>".$value['nama']."</td></tr>";
                                        }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <br/>
                <div class="row" hidden id="tb_saksi">
                    <div class="col-sm-12">
                        <div class="col-sm-6">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>Nama Saksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php 
                                        foreach ($vw_saksi as $value){
                                                echo "<tr><td>".$value['nama']."</td></tr>";
                                        }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <br/>
                <div class="row" hidden id="tb_ahli">
                    <div class="col-sm-12">
                        <div class="col-sm-6">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>Nama Ahli</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php 
                                        foreach ($vw_ahli as $value){
                                                echo "<tr><td>".$value['nama']."</td></tr>";
                                        }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <br/>
                <div class="row">
                    <div class="col-sm-12">
                        <div class="col-sm-6">
                            
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="control-label col-md-4">Penanda Tangan</label>
                                <div class="col-md-8">
                                    <?php
                                    echo Yii::$app->globalfunc->returnDropDownList($form,$model, VwPenandatangan::find()->all(),'peg_nip_baru','nama','id_penandatangan')  
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
            </div>
        </div>
    </div>
    <div class="col-sm-12">
        <div class="box box-warning">
            <div class="box-header">
                <h3 class="box-title"> 
                </h3>
            </div>
            <div class="box-body">
            	<div class="form-group" style="text-align: center;">
                    <?= Html::submitButton($model->isNewRecord ? 'Simpan' : 'Ubah', ['class' => $model->isNewRecord ? 'btn btn-warning' : 'btn btn-warning']) ?>
                        <?php if(!$model->isNewRecord): ?>
                    <a class="btn btn-warning" href="<?= \yii\helpers\Url::to(['pdm-p38/cetak?id='.rawurlencode($model->no_surat_p38)])?>">Cetak</a>
                        <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
    <div class="form-group" style="text-align: center;">
       
    </div>

    <?php ActiveForm::end(); ?>

</div>


<?php
$script = <<< JS
        
        $('#pdmp38-id_msstatusdata :radio').change(function(){
            var valor = $(this).val();
            if (valor == 1){
                $("#tb_saksi").show("slow");
                $("#tb_ahli").hide("slow");
                $("#tb_terdakwa").hide("slow"); 
            } else if (valor == 2){
                $("#tb_saksi").hide("slow");
                $("#tb_ahli").show("slow");
                $("#tb_terdakwa").hide("slow"); 
            } else if (valor == 3){
                $("#tb_terdakwa").show("slow");
                $("#tb_saksi").hide("slow");
                $("#tb_ahli").hide("slow");
            }
        });

        var valor = $("#pdmp38-id_msstatusdata input[type='radio']:checked").val();
            if (valor == 1){
                $("#tb_saksi").show("slow");
                $("#tb_ahli").hide("slow");
                $("#tb_terdakwa").hide("slow"); 
            } else if (valor == 2){
                $("#tb_saksi").hide("slow");
                $("#tb_ahli").show("slow");
                $("#tb_terdakwa").hide("slow"); 
            } else if (valor == 3){
                $("#tb_terdakwa").show("slow");
                $("#tb_saksi").hide("slow");
                $("#tb_ahli").hide("slow");
            } 
        
                
JS;
$this->registerJs($script);
?>

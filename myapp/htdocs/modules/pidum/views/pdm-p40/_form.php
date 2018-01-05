<?php

use kartik\datecontrol\DateControl;
use yii\helpers\Html;
use kartik\widgets\ActiveForm;
use yii\bootstrap\Modal;
use yii\helpers\ArrayHelper;
use kartik\builder\Form;
use app\modules\pidum\models\PdmMsStatusData;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model app\modules\pidum\models\PdmBa16 */
/* @var $form yii\widgets\ActiveForm */
?>


<section class="content" style="padding: 0px;">
    <div class="content-wrapper-1">

        <?php
        $form = ActiveForm::begin(
                        [
                            'id' => 'p44-form',
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

        <div class="box-header with-border" style="border-bottom:none;">
            <fieldset>
                <div class="kv-nested-attribute-block form-sub-attributes form-group">
                    <div class="col-sm-12">
                        <?= $this->render('//default/_formHeaderV', ['form' => $form, 'model' => $model, 'kode'=>'_p40']) ?>
                    </div>
                </div>
            </fieldset>
        </div>

        <div class="col-sm-12">
            <div class="box box-warning">
                <div class="box-header">
                    <h3 class="box-title">

                    </h3>
                </div>
                <div class="box-body">
                    <div class="form-group">
                        <label class="control-label col-sm-2">Jaksa Penuntut Umum</label>
                        <div class="col-sm-4">
                                <div class="form-group field-pdmjaksasaksi-nama required">
                                    <div class="col-sm-12">
                                        <?=
                                            $form->field($model, 'nama', [
                                                                      'addon' => [
                                                                         'append' => [
                                                                            'content' => Html::a('Pilih', '', ['class' => 'btn btn-warning', 'data-toggle' => 'modal', 'data-target' => '#m_jpu']),
                                                                              'asButton' => true
                                                                         ]
                                                                     ]
                                                                 ]);
                                                               ?>
                                    </div>
                                    <div class="col-sm-12"></div>
                                    <div class="col-sm-12">
                                        <div class="help-block"></div>
                                    </div>
                                </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-2">Membaca</label>

                        <div class="col-md-3">

<?php echo Yii::$app->globalfunc->returnRadioList($form, $model, array(0 => array("id" => "1", "nama" => "Penetapan"), "1" => array("id" => "2", "nama" => "Keputusan")), 'id', 'nama', 'id_msstatusdata') ?>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-2">
                            Diktum
                        </div>
                        <div class="col-sm-6">
<?php echo $form->field($model, 'diktum')->textarea(); ?>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-2">
                            Alasan
                        </div>
                        <div class="col-sm-6">
<?php echo $form->field($model, 'alasan')->textarea(); ?>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-2">
                            Pengadilan
                        </div>
                        <div class="col-sm-6">
<?php echo $form->field($model, 'ptinggi')->textarea(['value'=> ($model->isNewRecord)? Yii::$app->globalfunc->GetConfSatker()->p_negeri : $model->ptinggi]); ?>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-2">
                            Lokasi
                        </div>
                        <div class="col-sm-6">
<?php echo $form->field($model, 'alamat')->textarea(['value' => ($model->isNewRecord)? Yii::$app->globalfunc->GetConfSatker()->alamat_p_negeri : $model->alamat]) ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>





        <hr style="border-color: #c7c7c7;margin: 10px 0;">
        <div class="box-footer" style="text-align: center;">
<?= Html::submitButton($model->isNewRecord ? 'Simpan' : 'Ubah', ['class' => $model->isNewRecord ? 'btn btn-warning' : 'btn btn-warning']) ?>
<?php if (!$model->isNewRecord): ?>  
                <a class="btn btn-warning" href="<?= Url::to(['pdm-p40/cetak?id=' . $model->no_surat_p40]) ?>">Cetak</a>
<?php endif ?>  
        </div>

            <?php
            
            ?>
        <div class="box-body">   
        
            <div class="col-md-8 pull-left">   
                <?= Yii::$app->globalfunc->getTembusan($form,'P-40',$this,$model->no_surat_p40, '') ?>

            </div>
        </div>

    <?= $form->field($model, 'nip')->hiddenInput() ?>
    <?= $form->field($model, 'jabatan')->hiddenInput() ?>
    <?= $form->field($model, 'pangkat')->hiddenInput() ?>

        <?php ActiveForm::end(); ?>

    </div>
</section>





<?php
Modal::begin([
    'id' => 'm_jpu',
    'header' => 'Data Jaksa Pelaksana',
    'options' => [
        'data-url' => '',
    ],
]);
?>

<?=
$this->render('//pdm-p40/_m_jpu', [
    'model' => $model,
    'searchJPU' => $searchJPU,
    'dataJPU' => $dataJPU,
])
?>

<?php
Modal::end();
?>
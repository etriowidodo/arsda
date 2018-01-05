<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use kartik\datecontrol\DateControl;
use kartik\widgets\ActiveForm;
use dosamigos\ckeditor\CKEditor;
use yii\helpers\Url;
use app\components\GlobalConstMenuComponent;
use app\modules\pdsold\models\PdmPenandatangan;

use kartik\grid\GridView;
/* @var $this yii\web\View */
/* @var $model app\modules\pidum\models\PdmP20 */
/* @var $form yii\widgets\ActiveForm */
?>

		<h2>BERKAS TURUNAN P19</h2>
		
			<section class="content" style="padding: 0px;">
    <div class="content-wrapper-1">
    <?php
    $form = ActiveForm::begin([
                'id' => 'p19-form',
                'type' => ActiveForm::TYPE_HORIZONTAL,
                'enableAjaxValidation' => false,
                'fieldConfig' => [
                    'autoPlaceholder' => false
                ],
				
                'formConfig' => [
                    'deviceSize' => ActiveForm::SIZE_SMALL,
                    'labelSpan' => 1,
                    'showLabels' => false
                ]
    ]);
    ?>

  <?= $this->render('//default/_formHeader2', ['form' => $form, 'model' => $model]) ?>
        <div class="panel box box-warning">
        <div class="box-header with-border">
                <h3 class="box-title">Berkas Perkara a.n tersangka: <?= $modelTersangka ?></h3>
            </div><br>
            <div class="form-group">
                <label for="nomor" class="control-label col-md-2">Nomor Berkas</label>

                <div class="col-md-4">
                    <?= $form->field($modelBerkas, 'no_pengiriman')->textinput(['readonly' => true]) ?>
                </div>
               
                <label class="control-label col-md-2">Tanggal Berkas</label>
                <div class="col-md-2"><input type="text" class="form-control" value="<?= date('d-m-Y', strtotime($modelBerkas->tgl_pengiriman)) ?>" readonly="true"></div>
            </div>

            <div class="form-group">
               <label class="control-label col-md-2">Tanggal Terima</label>
               <div class="col-md-2">
                   <?= $form->field($model, 'tgl_terima')->widget(DateControl::className(), [
                            'type' => DateControl::FORMAT_DATE,
                            'ajaxConversion' => false,
                            'options' => [
                                'options' => [
                                    'placeholder' => 'Tanggal Terima',
                                ],
                                'pluginOptions' => [
                                    'autoclose' => true
                                ]
                            ]
                        ]);
                    ?>
                </div>
            </div>
        
        
        <div class="form-group">
                <label for="pasal" class="control-label col-md-2">Melanggar Pasal</label>

               <div class="col-md-8">
                        <?= $form->field($modelSpdp, 'undang_pasal')->textarea(['rows' => 3, 'readonly' => true, 'value' => $modelPasalBerkas]) ?>
                    </div>
            </div>
            <div class="panel box box-warning">
                <div class="box-header with-border ">
                    <h3 class="box-title">Petunjuk Kelengkapan</h3>
                </div>
                <br>
                <div class="form-group">
                    <div class="col-md-8"><?= $form->field($model, 'uraian')->textarea(['rows' => 3]) ?></div>
                </div>
            </div>
    </div>
        <?= $this->render('_formFooter', ['form' => $form, 'model' => $model, 'GlobalConst' => GlobalConstMenuComponent::P19, 'id_table' => $model->id_p19]) ?>

    <div class="box-footer" style="text-align: center;">
        <?= $this->render('_formFooterButton', ['model' => $model]) ?>
        <?php if(!$model->isNewRecord): ?>
            <?= Html::a('Cetak', ['cetak', 'id' => $model->id_p19, 'id_berkas' => $_GET['id_berkas']], ['class' => 'btn btn-warning']) ?>
        <?php endif ?>
    </div>

</section>
<br>

<?php
$script = <<< JS
            $('.tambah-tembusan').click(function(){
                $('.tembusan').append(
               '<input type="text" class="form-control" style="margin-left:180px"name="mytext[]"><br />'
                )
            });
JS;
$this->registerJs($script);
?>
<br>

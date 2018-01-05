<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use kartik\widgets\ActiveForm;
use kartik\datecontrol\DateControl;
use app\components\GlobalConstMenuComponent;
use yii\bootstrap\Modal;
use app\modules\pengawasan\models\Wilayah;
use app\modules\pengawasan\models\Pegawai;
// use yii\widgets\ActiveField;

/* @var $this yii\web\View */
/* @var $model app\modules\pengawasan\models\InspekturModel */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="penandatangan-master-form">
	<?php
    $form = ActiveForm::begin([
                'id' => 'penandatangan-master-form',
                'type' => ActiveForm::TYPE_HORIZONTAL,
                'enableAjaxValidation' => false,
                'fieldConfig' => [
                    'autoPlaceholder' => false
                ],
                'formConfig' => [
                    'deviceSize' => ActiveForm::SIZE_SMALL,
                    'showLabels' => false
                ]
    ]);
    ?>	
    <div class="content-wrapper-1">
    <div class="box box-primary" style="padding: 15px;overflow: hidden;">
        <!-- <div>
        <?php
        if(!$model->isNewRecord){
            echo $form->field($model, 'nip')->hiddenInput();
        }
        ?>
        </div>
 -->
        <div class="col-md-12">
            <div class="form-group">
                <label class="col-md-2">Wilayah</label>
                <div class="col-md-4">
                    <?=
                        $form->field($model, 'id_tingkat_wilayah')->dropDownList(
                                ArrayHelper::map(Wilayah::find()->orderBy('id_wilayah')->all(), 'id_wilayah', 'nama_wilayah'), ['prompt' => '-- Pilih --'],['width'=>'40%']
                        )
                        ?>
                </div>
                <label class="col-md-2">NIP</label>
                <div class="col-md-4">
                    <?php
                            echo $form->field($model, 'nip', [
                                'addon' => [
                                    'append' => [
                                        'content' => Html::a('Pilih', '', ['class' => 'btn btn-primary', 'data-toggle' => 'modal', 'data-target' => '#_mjpu4']),
                                        'asButton' => true
                                    ],
                                    
                                ],

                            ]);
                            ?> 

                </div>
                
            </div>
        </div>

        <div class="col-md-12">
            <div class="form-group">
                <label class="col-md-2">Nama Penandatangan</label>
                    <div class="col-md-10">
                    <?= $form->field($model, 'nama_penandatangan')->textInput(['readonly'=>'readonly',  'maxlength' => true]) ?>
                    </div>             
            </div>
        </div>

        <div class="col-md-12">
            <div class="form-group">
                <label class="col-md-2">Pangkat</label>
                <div class="col-md-10">
                    <?= $form->field($model, 'pangkat_penandatangan')->textInput(['readonly'=>'readonly', 'maxlength' => true]) ?>
                </div>
            </div>
        </div>

        <div class="col-md-12">
            <div class="form-group">
                <label class="col-md-2">Golongan</label>
                <div class="col-md-10">
                    <?= $form->field($model, 'golongan_penandatangan')->textInput(['readonly'=>'readonly', 'maxlength' => true]) ?>
                </div>
            </div>
        </div>

        <div class="col-md-12">
            <div class="form-group">
                <label class="col-md-2">Jabatan Penandatangan</label>
                <div class="col-md-10">
                    <?= $form->field($model, 'jabatan_penandatangan')->textInput(['readonly'=>'readonly', 'maxlength' => true]) ?>
                </div>
            </div>
        </div>

        <div class="col-md-12 ">
            <div class="form-group">
                <label class="col-md-2"></label>
                <div class="col-md-10">
                    <?= $form->field($model, 'kode_level')->hiddenInput(['readonly'=>'readonly', 'maxlength' => true]) ?>
                </div>
            </div>
        </div>

        <div class="col-md-12 ">
            <div class="form-group">
                <label class="col-md-2"></label>
                <div class="col-md-10">
                    <?= $form->field($model, 'unitkerja_kd')->hiddenInput(['readonly'=>'readonly', 'maxlength' => true]) ?>
                </div>
            </div>
        </div>
    
</div>
    <div class="form-group" style="text-align: center;">
        <?= Html::submitButton($model->isNewRecord ? 'Tambah' : 'Ubah', ['class' => $model->isNewRecord ? 'btn btn-primary' : 'btn btn-primary']) ?>
        <input action="action" type="button" value="Kembali" class="btn btn-primary" onclick="history.go(-1);" />
    </div>
</div>
    <?php ActiveForm::end(); ?>

</div>
<script type="text/javascript">
$(document).ready(function(){
    $(".control-label").hide();
$('#penandatangan-nip').attr('readonly', true);    
    
$('body').on('click','.pilih-ttd',function(){
    
    var data = JSON.parse($(this).attr('json'));
    // alert(data.peg_nip_baru);
    $('#penandatangan-nip').val(data.peg_nip_baru);
    $('#penandatangan-nama_penandatangan').val(data.nama);
    $('#penandatangan-pangkat_penandatangan').val(data.gol_pangkat2);
    $('#penandatangan-golongan_penandatangan').val(data.gol_kd);
    $('#penandatangan-jabatan_penandatangan').val(data.jabatan);
    $('#penandatangan-kode_level').val(data.ref_jabatan_kd);
    $('#penandatangan-unitkerja_kd').val(data.unitkerja_kd);

    $('#_mjpu4').modal('hide');
});
});
</script>
<?php
Modal::begin([
    'id' => '_mjpu4',
    'header' => 'Pilih Penandatangan',
    'options' => [
        'data-url' => '',
        'style' =>'width:100%',
    ],
]);
?> 

<?=
$this->render('_mjpu4', [
    'model' => $model,
    // 'modelPelapor' => $modelPelapor,
    //'warganegara'       => $warganegara,
    //'pelapor' => $pelapor,
])
?>

<?php
Modal::end();
?>


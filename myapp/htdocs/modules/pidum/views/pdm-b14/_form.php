<?php

use app\components\GlobalConstMenuComponent;
use app\modules\pidum\models\PdmB14;
use app\modules\pidum\models\PdmPenandatangan;
use app\modules\pidum\models\PdmMsBendaSitaan;
use kartik\datecontrol\DateControl;
use kartik\widgets\ActiveForm;
use yii\bootstrap\Modal;
use yii\db\Query;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\View;
use yii\widgets\ActiveForm as ActiveForm2;

/* @var $this yii\web\View */
/* @var $model app\modules\pidum\models\PdmB14 */
/* @var $form yii\widgets\ActiveForm */
?>

<section class="content" style="padding: 0px;">
    <div class="content-wrapper-1">

        <?php
        $form = ActiveForm::begin(
                        [
                            'id' => 'b14-form',
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
            <div class="box box-warning">
                <div class="box-header">
                    <h3 class="box-title">

                    </h3>
                </div>
                <div class="form-group">
                    <label class="control-label col-sm-3">Wilayah Kerja</label>
                    <div class="col-sm-3">
                        <input class="form-control" value="<?php echo Yii::$app->globalfunc->getSatker()->inst_nama ?>">
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-sm-3">Nomor</label>
                    <div class="col-sm-3">
                        <?php echo $form->field($model, 'no_sprint'); ?>
                    </div>
                </div>
            </div>
        </div>


        <div class="col-sm-12">
            <div class="box box-warning">
                <div class="box-header">
                    <h3 class="box-title">
                        ACUAN DASAR 
                    </h3>
                </div>
                <div class="box-body">
                    <div class="form-group">
                        <label class="control-label col-sm-2">BA Pemeriksaan Barang Sitaan / Bukti Dari :</label>
                        <div class="col-sm-8">
                            <?php //echo $form->field($model, 'barbuk');  ?>


                        </div>
                    </div>

                </div>
            </div>
        </div>

        <div class="col-sm-12">
            <div class="box box-warning">
                <div class="box-header">
                    <h3 class="box-title">
                        MEMERINTAHKAN 
                    </h3>
                </div>
                <div class="box-body">
                    <div class="form-group">
                        <div class="box-header with-border" style="border-color: #c7c7c7;">
                            <h3 class="box-title">
                                <a class="btn btn-primary addJPU2" id="popUpJpu">Jaksa Peneliti</a>
                            </h3>
                        </div>
                    </div>
                    <div class="form-group">

                        <table id="table_jpu" class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>No Urut</th>
                                    <th>NIP</th>
                                    <th>NAMA</th>
                                    <th>JABATAN</th>
                                    <th>PANGKAT</th>
                                    <th><a class='btn btn-danger delete'></a></th>
                                </tr>
                            </thead>
                            <tbody id="tbody_jpu">
                                <?php if (!$model->isNewRecord): ?>
                                    <?php foreach ($modelJpu as $key => $value): ?>
                                        <tr data-id="<?= $value['id_jpp'] ?>">
                                            <td><input type="text" name="no_urut[]" class="form-control" value="<?= ($value['no_urut'] == null) ? $key + 1 : $value['no_urut'] ?>" style="width: 50px;"></td>
                                            <td><input type="text" name="nip_baru[]" class="form-control" readonly="true" value="<?= $value['peg_nip_baru'] ?>"><input type="hidden" name="nip_jpu[]" class="form-control" readonly="true" value="<?= $value['nip'] ?>"></td>
                                            <td><input type="text" name="nama_jpu[]" class="form-control" readonly="true" value="<?= $value->nama ?>"></td>
                                            <td><input type="text" name="jabatan_jpu[]" class="form-control" readonly="true" value="<?= $value->jabatan ?>"></td>
                                            <td><input type="text" name="gol_jpu[]" class="form-control" readonly="true" value="<?= $value->pangkat ?>"></td>
                                            <td><input type='checkbox' name='jaksa[]' class='checkHapus' id='hapusJaksa' value="<?= $value['id_jpp'] ?>"> </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </tbody>
                        </table>

                    </div>
                </div>
            </div>

            <div class="col-sm-12">
                <div class="box box-warning">
                    <div class="box-header">
                        <h3 class="box-title">
                            DETAIL BARANG 
                        </h3>
                    </div>
                    <div class="box-body">
                        <div class="form-group">
                            <label class="control-label col-sm-2">Memiliki Keadaan :</label>
                            <div class="col-sm-8">
                                <div class="form-group field-pdmbarangsitaanb14-id_msbendasitaan required">

                                    <div class="col-sm-12">
                                        <div id="nama">
                                            <?php foreach ($model2 as $data_barbuk): ?>
                                                <div class="checkbox"><label><input type="checkbox" value="<?= $data_barbuk['id'] ?>" <?= $data_barbuk['is_checked'] ?> name="id_msbendasitaan[]"> <?= $data_barbuk['nama'] ?></label></div>
                                            <?php endforeach; ?>
                                        </div>
                                    </div>

                                    <div class="col-sm-12"></div>
                                    <div class="col-sm-12"><div class="help-block"></div></div>
                                </div>


                            </div>
                        </div>

                    </div>
                </div>
            </div>

            <?= $this->render('//default/_formFooter', ['form' => $form, 'model' => $model, 'GlobalConst' => GlobalConstMenuComponent::B14, 'id_table' => $model->id_b14]) ?>

            <hr style="border-color: #c7c7c7;margin: 10px 0;">
            <div class="box-footer" style="text-align: center;">
                <?= Html::submitButton($model->isNewRecord ? 'Simpan' : 'Ubah', ['class' => $model->isNewRecord ? 'btn btn-warning' : 'btn btn-warning']) ?>
                <?php if (!$model->isNewRecord): ?>  
                    <a class="btn btn-warning" href="<?= Url::to(['pdm-b14/cetak?id=' . $model->id_b14]) ?>">Cetak</a>
                <?php endif ?>  
            </div>



            <?php ActiveForm::end(); ?>

        </div>
</section>

<?php
$script1 = <<< JS
	$('#popUpJpu').click(function(){
		$('#m_jpu').html('');
        $('#m_jpu').load('/pidum/p16/jpu');
        $('#m_jpu').modal('show');
	});

/*
      $( document ).on('click', '.hapusJaksa', function(e) {
        var input = $( this );
            $(".hapus").click(function(event){
                event.preventDefault();
                if(input.prop( "checked" ) == true){
                    bootbox.dialog({
                        message: "Apakah anda ingin menghapus data ini?",
                        buttons:{
                            ya : {
                                label: "Ya",
                                className: "btn-warning",
                                callback: function(){
                                    $("#trjpu"+e.target.value).remove();
                                }
                            },
                            tidak : {
                                label: "Tidak",
                                className: "btn-warning",
                                callback: function(result){
                                    console.log(result);
                                }
                            },
                        },
                    });

                }else if(input.prop( "checked" ) == false){
                    $(".hapus").off("click");
                }
            });


    });*/

JS;
$this->registerJs($script1);
Modal::begin([
    'id' => 'm_jpu',
    'header' => '<h7>Tambah JPU</h7>'
]);
Modal::end();
?>
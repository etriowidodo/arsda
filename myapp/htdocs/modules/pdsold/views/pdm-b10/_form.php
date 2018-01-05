<?php

use kartik\datecontrol\DateControl;
use yii\bootstrap\Modal;
use yii\helpers\Html;
use kartik\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\pidum\models\PdmB10 */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="pdm-b10-form">

    <?php $form = ActiveForm::begin(
        [
            'id' => 'b10-form',
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
    ]); ?>

    <div class="col-sm-12">
        <div class="box box-warning">
            <div class="box-body">
                <div class="row" style="height: 45px">
                    <div class="col-md-12">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label col-md-4">Wilayah Kerja</label>
                                <div class="col-md-8">
                                    <input class="form-control" readonly='true' value="<?php echo Yii::$app->globalfunc->getSatker()->inst_nama ?>">
                                    <?= $form->field($model, 'wilayah_kerja')->hiddenInput(['value' => \Yii::$app->globalfunc->getSatker()->inst_satkerkd])->label(false) ?>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <div class="col-md-4">
                                    <?=
                                        $form->field($model, 'tgl_b10')->widget(DateControl::className(), [
                                            'type' => DateControl::FORMAT_DATE,
                                            'ajaxConversion' => false,
                                            'options' => [
                                                'options' => [
                                                    'placeholder' => 'Tanggal Dibuat',
                                                ],
                                                'pluginOptions' => [
                                                    'autoclose' => true
                                                ]
                                            ]
                                        ]);
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row" style="height: 45px">
                    <div class="col-md-12">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label col-md-4">Nama Terdakwa</label>
                                <div class="col-md-8">
                                    <input type="text" name="terdakwa" class="form-control" value="<?= $listTersangka ?>" readonly="readonly">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row" style="height: 45px">
                    <div class="col-md-12">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label col-md-4">No. Register Perkara</label>
                                <div class="col-md-8">
                                    <input type="text" name="terdakwa" class="form-control" value="<?= $no_register_perkara ?>" readonly="readonly">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row" style="height: 45px">
                    <div class="col-md-12">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label col-md-4">No. Register Barang Sitaan / Bukti</label>
                                <div class="col-md-8">
                                    <input type="text" name="terdakwa" class="form-control" value="<?= $ba5->no_reg_bukti ?>" readonly="readonly">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row" style="height: 45px">
                    <div class="col-md-12">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="control-label col-md-2">Barang Bukti</label>
                                <div class="col-md-8">
                                    <table id="table_barbuk" class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th width="4%" style="text-align: center;vertical-align: middle;">No</th>
                                                <th width="35%" style="text-align: center;vertical-align: middle;">Nama Barang Bukti</th>
                                                <th width="4%" style="text-align: center;vertical-align: middle;"></th>
                                            </tr>
                                        </thead>
                                        <tbody id="tbody_barbuk">
                                            <?php


                                                if (!$model->isNewRecord) {
                                                    $arr = json_decode($model->barbuk);
                                                    //echo '<pre>';print_r($arr);exit;
                                                    //$arr = $dec->undang;
                                                    $jum_undang= count($arr);
                                                }

                                                $ix = 0;
                                                foreach ($modelBarbuk as $listbarbuk):

                                                    $check='';
                                                if (!$model->isNewRecord) {
                                                    for ($i=0; $i < $jum_undang; $i++) { 
                                                        if($listbarbuk['no_urut_bb'] == $arr[$i]){
                                                            $check=' checked "true" '.$listbarbuk['no_urut_bb'];
                                                        }
                                                    }
                                                }
                                                $nama = Yii::$app->globalfunc->GetDetBarbuk(Yii::$app->session->get('no_register_perkara'),$listbarbuk['no_urut_bb']);
                                                //echo '<pre>';print_r($nama);exit;




                                                echo '<tr id="row-'.$listbarbuk['no_urut_bb'].'">';
                                                    echo '<td style="text-align: center">'.$listbarbuk['no_urut_bb'].'</td>';
                                                    echo '<td style="text-align: left">'.$nama.'</td>';
                                                    echo '<td style="text-align: left; "><input type="checkbox" name="barbuk[]" "'.$check.'" value="'.$listbarbuk['no_urut_bb'].'" style="width:100%"></td>';
                                                echo '</tr>';
                                                    $ix++;
                                                endforeach;//exit;
                                            ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-sm-12 hide">
        <div class="box box-warning">
            <div class="box-header">
                <h3 class="box-title">
                    <B>DAFTAR BARANG BUKTI</B>
                </h3>
            </div>
            <div class="box-body">
                <table class="table table-bordered">
                    <tr>
                        <th>No</th>
                        <th>Nama</th>
                    </tr>
                    <?php 
                    foreach($listBarbuk as $key => $value):  ?>
                    <tr>
                        <td><?= $key+1; ?></td>
                        <td><?= $value['nama']; ?></td>
                    </tr>
                    <?php endforeach; ?>
                </table>
            </div>
        </div>
    </div>

    <div class="form-group" style="text-align: center;">
        <?= Html::submitButton($model->isNewRecord ? 'Simpan' : 'Ubah', ['class' => 'btn btn-warning']) ?>
        <?php if(!$model->isNewRecord): ?>  
            <a class="btn btn-warning" href="<?= \yii\helpers\Url::to(['pdm-b10/cetak?id='.$model->tgl_b10])?>">Cetak</a>
        <?php endif ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

<?php
Modal::begin([
    'id' => 'm_detil',
    'header' => '<h7><b>DAFTAR BARANG BUKTI</b></h7>'
]);

Modal::end();
?>

<?php
    $js = <<< JS

        $('.ubah-detil').click(function(){
            var href = $(this).attr('href');
            if(href != null){
                var id = href.substring(1, href.length);
            }

            $('#m_detil').html('');
            $('#m_detil').load('/pdsold/default/detil-b10?id='+id);
            $('#m_detil').modal('show');
        });
JS;
$this->registerJs($js);
?>
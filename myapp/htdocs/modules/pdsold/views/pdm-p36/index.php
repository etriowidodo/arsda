<?php

use yii\helpers\Html;
use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\pidum\models\PdmP36Search */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = $sysMenu->kd_berkas;
$this->subtitle = $sysMenu->keterangan;
?>
<div class="pdm-p36-index">
    <div id="divTambah" class="col-md-11">
        <?= Html::a('Tambah', ['create'], ['class' => 'btn btn-warning']) ?>
    </div>

    <?php
    $form = \kartik\widgets\ActiveForm::begin([
                'id' => 'hapus-index',
                'action' => '/pdsold/pdm-p36/delete'
    ]);
    ?>
    <div id="divHapus" class="col-md-1">
        <button class='btn btn-warning btnHapusCheckboxIndex'>Hapus</button>
    </div>
    <?php \kartik\widgets\ActiveForm::end() ?>

    <div class="clearfix"><br><br></div>

    <div class="row">
        <div class="col-md-12">
            <?=
            GridView::widget([
                'id' => 'spdp',
                'rowOptions' => function ($model, $key, $index, $grid) {
                    return ['data-id' => $model->no_surat_p36];
                },
                'dataProvider' => $dataProvider,
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],
                    [
                      'attribute' => 'no_surat_p36',
                      'label' => 'Nomor & Tanggal Surat',
                      'format' => 'raw',
                      'value' => function ($model, $key, $index, $widget) {
                            return $model->no_surat_p36 . '<br>' . Yii::$app->globalfunc->ViewIndonesianFormat($model->tgl_dikeluarkan);
                        },
                    ],
                    [
                      'attribute' => 'pengadilan',
                      'label' => 'Tempat, Tanggal & Waktu Pengadilan',
                      'format' => 'raw',
                      'value' => function ($model, $key, $index, $widget) {
                            return "PN " . $model->pengadilan . '<br>' . Yii::$app->globalfunc->ViewIndonesianFormat($model->tgl_sidang) . " Jam " . date("H:i", strtotime($model->jam));
                        },
                    ],
                    [
                      'attribute' => 'perihal',
                      'label' => 'Perihal',
                      'value' => function ($model, $key, $index, $widget) {
                            return "Permintaan bantuan pengawalan tahanan / pengamanan persidangan";
                        },
                    ],
                    [
                        'class' => 'kartik\grid\CheckboxColumn',
                        'headerOptions' => ['class' => 'kartik-sheet-style'],
                        'checkboxOptions' => function ($model, $key, $index, $column) {
                                return ['value' => $model->no_surat_p36, 'class' => 'checkHapusIndex'];
                            }
                    ],
                ],
                        'export' => false,
                        'pjax' => true,
                        'responsive' => true,
                        'hover' => true,
                    ]);
                    ?>

        </div>
    </div>
</div>
<?php
$js = <<< JS
    $('td').dblclick(function (e) {
    var no_surat_p36 = $(this).closest('tr').data('id');
    var url = window.location.protocol + "//" + window.location.host + "/pdsold/pdm-p36/update?no_surat_p36="+no_surat_p36;
    $(location).attr('href',url);
});


JS;

$this->registerJs($js);
?>
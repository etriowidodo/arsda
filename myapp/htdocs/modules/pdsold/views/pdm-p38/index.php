<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use app\models\MsSifatSurat;
use app\modules\pdsold\models\PdmMsStatusData;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\pidum\models\PdmP38Search */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = $sysMenu->kd_berkas;
$this->subtitle = $sysMenu->keterangan;
?>
<div class="pdm-p38-index">
    <div id="divTambah" class="col-md-11">
        <?= Html::a('Tambah', ['create'], ['class' => 'btn btn-warning']) ?>
    </div>
    <?php
    $form = \kartik\widgets\ActiveForm::begin([
        'id' => 'hapus-index',
        'action' => '/pdsold/pdm-p38/delete'
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
                    return ['data-id' => $model->no_surat_p38];
                },
                'dataProvider' => $dataProvider,
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],
                    [
                      'attribute' => 'no_surat_p38',
                      'label' => 'Nomor & Tanggal Surat',
                      'format' => 'raw',
                      'value' => function ($model, $key, $index, $widget) {
                            return $model->no_surat_p38 . '<br>' . Yii::$app->globalfunc->ViewIndonesianFormat($model->tgl_dikeluarkan);
                        },
                    ],
                    [
                      'attribute' => 'sifat',
                      'label' => 'Sifat',
                      'format' => 'raw',
                      'value' => function ($model, $key, $index, $widget) {
                            $sifat  = MsSifatSurat::findOne(['id'=>$model->sifat]);
                            return $sifat->nama;
                        },
                    ],
                    [
                      'attribute' => 'lampiran',
                      'label' => 'Lampiran',
                      'format' => 'raw',
                      'value' => function ($model, $key, $index, $widget) {
                            return $model->lampiran;
                        },
                    ],
                    [
                      'attribute' => 'id_msstatusdata',
                      'label' => 'Berita Panggilan',
                      'format' => 'raw',
                      'value' => function ($model, $key, $index, $widget) {
                            $sifat  = PdmMsStatusData::findOne(['is_group' => 'P-37','id'=>$model->id_msstatusdata]);
                            return $sifat->nama;
                        },
                    ],
                    [
                        'class' => 'kartik\grid\CheckboxColumn',
                        'headerOptions' => ['class' => 'kartik-sheet-style'],
                        'checkboxOptions' => function ($model, $key, $index, $column) {
                            return ['value' => $model->no_surat_p38, 'class' => 'checkHapusIndex'];
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
    var no_surat_p38 = $(this).closest('tr').data('id');
    var url = window.location.protocol + "//" + window.location.host + "/pdsold/pdm-p38/update?no_surat_p38="+no_surat_p38;
    $(location).attr('href',url);
});


JS;

$this->registerJs($js);
?>


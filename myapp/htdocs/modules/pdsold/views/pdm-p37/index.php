<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use app\modules\pdsold\models\PdmMsStatusData;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\pidum\models\PdmP37Search */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = $sysMenu->kd_berkas;
$this->subtitle = $sysMenu->keterangan;
?>
<br/>
<div class="pdm-p37-index">
    <div id="divTambah" class="col-md-11">
        <?= Html::a('Tambah', ['create'], ['class' => 'btn btn-warning']) ?>
    </div>
    <?php
    $form = \kartik\widgets\ActiveForm::begin([
        'id' => 'hapus-index',
        'action' => '/pdsold/pdm-p37/delete'
    ]);
    ?>
    <div id="divHapus" class="col-md-1">
        <button class='btn btn-warning btnHapusCheckboxIndex'>Hapus</button>
    </div>

<!--     <div id="btnHapus"></div><div id="btnUpdate"></div>
 -->    <?php \kartik\widgets\ActiveForm::end() ?>
    <br/>
    <div class="row">
        <div class="col-md-12">
            <?=
            GridView::widget([
                'id' => 'spdp',
                'rowOptions' => function ($model, $key, $index, $grid) {
                    return ['data-id' => $model['id_p37']];
                },
                'dataProvider' => $dataProvider,
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],

                    [
                      'attribute' => 'no_surat',
                      'label' => 'Nomor & Tanggal Surat',
                      'format' => 'raw',
                      'value' => function ($model, $key, $index, $widget) {
                            return $model->no_surat_p37 . '<br>' . Yii::$app->globalfunc->ViewIndonesianFormat($model->tgl_dikeluarkan);
                        },
                    ],

                    [
                      'attribute' => 'Nama',
                      'value' => 'nama'
                    ],
                	[
                	  'attribute' => 'Status',
                	  'value' => function ($model, $key, $index, $widget) {
                            return PdmMsStatusData::findOne(['id'=>$model->id_msstatusdata, 'is_group'=>'P-37'])->nama;
                        },
                	],
                    'keperluan',
                    [
                        'class' => 'kartik\grid\CheckboxColumn',
                        'headerOptions' => ['class' => 'kartik-sheet-style'],
                        'checkboxOptions' => function ($model, $key, $index, $column) {
                                return ['value' => $model->id_p37, 'class' => 'checkHapusIndex'];
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
    var id = $(this).closest('tr').data('id');
    var url = window.location.protocol + "//" + window.location.host + "/pdsold/pdm-p37/update?id="+id;
    $(location).attr('href',url);
});


JS;

$this->registerJs($js);
?>
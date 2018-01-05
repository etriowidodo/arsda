<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use app\models\MsSifatSurat;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\pidum\models\PdmP45Search */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = $sysMenu->kd_berkas;
$this->subtitle = $sysMenu->keterangan;
?>
<div class="pdm-p45-index">

    <div id="divTambah" class="col-md-11">
        <?= Html::a('Tambah', ['create'], ['class' => 'btn btn-warning']) ?>
    </div>

    <?php
    $form = \kartik\widgets\ActiveForm::begin([
                'id' => 'hapus-index',
                'action' => '/pidum/pdm-p45-upayahukum/delete'
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
                    return ['data-id' => $model->no_surat_p45];
                },
                'dataProvider' => $dataProvider,
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],
                    [
                        'attribute'=>'no_surat_p45',
                        'label' => 'No. Surat P-45',
                        'format' => 'raw',
                        'value'=>function ($model, $key, $index, $widget) {
                            return $model->no_surat_p45;
                        },
                    ],
                    [
                        'attribute'=>'sifat',
                        'label' => 'Sifat',
                        'format' => 'raw',
                        'value'=>function ($model, $key, $index, $widget) {
                            $sifat  = MsSifatSurat::findOne(['id'=>$model['sifat']]);
                            return $sifat->nama;
                        },
                    ],
                    [
                        'attribute'=>'lampiran',
                        'label' => 'Lampiran',
                        'format' => 'raw',
                        'value'=>function ($model, $key, $index, $widget) {
                            return $model->lampiran;
                        },
                    ],
                    [
                        'class' => 'kartik\grid\CheckboxColumn',
                        'headerOptions' => ['class' => 'kartik-sheet-style'],
                        'checkboxOptions' => function ($model, $key, $index, $column) {
                                return ['value' => $model->no_surat_p45, 'class' => 'checkHapusIndex'];
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
    var url = window.location.protocol + "//" + window.location.host + "/pidum/pdm-p45-upayahukum/update?id="+id;
    $(location).attr('href',url);
});


JS;

$this->registerJs($js);
?>



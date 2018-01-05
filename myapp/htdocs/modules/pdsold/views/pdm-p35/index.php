<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use app\models\MsSifatSurat;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\pidum\models\PdmP35Search */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = $sysMenu->kd_berkas;
$this->subtitle = $sysMenu->keterangan;
?>
<div class="pdm-p35-index">
    <div id="divTambah" class="col-md-11">
        <?= Html::a('Tambah', ['create'], ['class' => 'btn btn-warning']) ?>
    </div>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?php
    $form = \kartik\widgets\ActiveForm::begin([
                'id' => 'hapus-index',
                'action' => '/pdsold/pdm-p35/delete'
    ]);

    ?>
    <div id="divHapus">
        <button class='btn btn-warning btnHapusCheckboxIndex'>Hapus</button>
    </div>
    <div id="btnHapus"></div><div id="btnUpdate"></div>
    <?php \kartik\widgets\ActiveForm::end() ?>
    <div class="row">
        <div class="col-md-12">
            <?=
            GridView::widget([
                'id' => 'spdp',
                'rowOptions' => function ($model, $key, $index, $grid) {
                    return ['data-id' => $model['no_surat_p35']];
                },
                'dataProvider' => $dataProvider,
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],
                    'no_surat_p35',
                    [
                      'attribute' => 'sifat',
                      'format' => 'raw',
                      'value'=>function ($model, $key, $index, $widget) {
                      $sifat = MsSifatSurat::findOne(['id'=>$model->sifat]);
                                          return ucwords($sifat->nama);
                      },
                    ],
                    'lampiran',
                    [
                        'class' => 'kartik\grid\CheckboxColumn',
                        'headerOptions' => ['class' => 'kartik-sheet-style'],
                        'checkboxOptions' => function ($model, $key, $index, $column) {
                                return ['value' => $model->no_surat_p35, 'class' => 'checkHapusIndex'];
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
    var url = window.location.protocol + "//" + window.location.host + "/pdsold/pdm-p35/update?id="+id;
    $(location).attr('href',url);
});


JS;

$this->registerJs($js);
?>

</div>

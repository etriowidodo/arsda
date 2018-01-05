<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use app\models\MsSifatSurat;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\pidum\models\PdmP38Search */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = "Penetapan Hakim";
//$this->subtitle = $sysMenu->keterangan;
?>
<div class="pdm-p38-index">
    <div id="divTambah" class="col-md-11">
        <?= Html::a('Tambah', ['create'], ['class' => 'btn btn-warning']) ?>
    </div>
    <?php
    $form = \kartik\widgets\ActiveForm::begin([
        'id' => 'hapus-index',
        'action' => '/pdsold/pdm-penetapan-hakim/delete'
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
                    return ['data-id' => $model->no_penetapan_hakim];
                },
                'dataProvider' => $dataProvider,
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],
                    [
                      'attribute' => 'no_penetapan_hakim',
                      'label' => 'Nomor & Tanggal Surat',
                      'format' => 'raw',
                      'value' => function ($model, $key, $index, $widget) {
                            return $model->no_penetapan_hakim . '<br>' . Yii::$app->globalfunc->ViewIndonesianFormat($model->tgl_penetapan_hakim);
                        },
                    ],
                    [
                      'attribute' => 'dengan_cara',
                      'label' => 'Dengan Cara',
                      'format' => 'raw',
                      'value' => function ($model, $key, $index, $widget) {
                            return $model->dengan_cara;
                        },
                    ],
                    [
                        'class' => 'kartik\grid\CheckboxColumn',
                        'headerOptions' => ['class' => 'kartik-sheet-style'],
                        'checkboxOptions' => function ($model, $key, $index, $column) {
                            return ['value' => $model->no_penetapan_hakim, 'class' => 'checkHapusIndex'];
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
    var no_penetapan_hakim = $(this).closest('tr').data('id');
    var url = window.location.protocol + "//" + window.location.host + "/pdsold/pdm-penetapan-hakim/update?no_penetapan_hakim="+no_penetapan_hakim;
    $(location).attr('href',url);
});


JS;

$this->registerJs($js);
?>

</div>

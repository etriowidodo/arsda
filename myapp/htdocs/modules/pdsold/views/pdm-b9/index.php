<?php

use yii\helpers\Html;
use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\pidum\models\PdmB9Search */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = $sysMenu->kd_berkas;
$this->subtitle = $sysMenu->keterangan;
?>
<div class="pdm-b9-index">

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?php
    $form = \kartik\widgets\ActiveForm::begin([
                'id' => 'hapus-index',
                'action' => '/pdsold/pdm-b9/delete'
    ]);
    ?>
    <div id="divHapus">
        <?= Html::a('Tambah', ['create'], ['class' => 'btn btn-warning']) ?>
        <div class="pull-right"><a class='btn btn-danger hapusTembusan btnHapusCheckboxIndex'>Hapus</a><br></div>
    </div>
    <div id="btnHapus"></div><div id="btnUpdate"></div>
    
    <?php \kartik\widgets\ActiveForm::end() ?>
    <br/>
    <div class="row">
        <div class="col-md-12">
            <?=
            GridView::widget([
                'id' => 'spdp',
                'rowOptions' => function ($model, $key, $index, $grid) {
                    return ['data-id' => $model['tgl_b9']];
                },
                'dataProvider' => $dataProvider,
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],
                    'no_register_perkara',
                    [
                        'attribute'=>'tgl_b9',
                        'label' => 'Tanggal B-9',
                        'format' => 'raw',
                        'value'=>function ($model, $key, $index, $widget) {
                            return Yii::$app->globalfunc->ViewIndonesianFormat($model->tgl_b9);
                        },
                    ],
                    [
                        'class' => 'kartik\grid\CheckboxColumn',
                        'headerOptions' => ['class' => 'kartik-sheet-style'],
                        'checkboxOptions' => function ($model, $key, $index, $column) {
                                return ['value' => $model->tgl_b9, 'class' => 'checkHapusIndex'];
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
    var url = window.location.protocol + "//" + window.location.host + "/pdsold/pdm-b9/update?id="+id;
    $(location).attr('href',url);
});


JS;

$this->registerJs($js);
?>

</div>

<?php

use yii\helpers\Html;
use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\pidum\models\PdmP47Search */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = $sysMenu->kd_berkas;
$this->subtitle = $sysMenu->keterangan;
?>
<div class="pdm-p47-index">

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?php
	    $form = \kartik\widgets\ActiveForm::begin([
	                'id' => 'hapus-index',
	                'action' => '/pidum/pdm-p47/delete'
	    ]);
	?>
    <div id="divHapus">
    <?php  if($dataProvider->getTotalCount()==0){ ?><!-- CUMA BOLEH INPUT SEKALI -->
        <?= Html::a('Tambah', ['create'], ['class' => 'btn btn-warning']) ?>
    <?php } ?>
        <div class="pull-right"><a class='btn btn-danger delete hapusTembusan btnHapusCheckboxIndex'></a><br></div>
    </div>
    <div id="btnHapus"></div><div id="btnUpdate"></div>
    <?php \kartik\widgets\ActiveForm::end() ?>
    
    <div class="row">
        <div class="col-md-12">
            <?=
            GridView::widget([
                'id' => 'spdp',
                'rowOptions' => function ($model, $key, $index, $grid) {
                    return ['data-id' => $model['no_akta']];
                },
                'dataProvider' => $dataProvider,
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],
                    'kepada',
                    'dikeluarkan',
                    [
                        'attribute' => 'tgl_dikeluarkan',
                        'label' => 'Tanggal',
                        'value' => function ($model, $key, $index, $widget) {
                                    return Yii::$app->globalfunc->IndonesianFormat($model->tgl_dikeluarkan);
                                }
                    ],
                    [
                        'class' => 'kartik\grid\CheckboxColumn',
                        'headerOptions' => ['class' => 'kartik-sheet-style'],
                        'checkboxOptions' => function ($model, $key, $index, $column) {
                                return ['value' => $model->no_akta, 'class' => 'checkHapusIndex'];
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
    var url = window.location.protocol + "//" + window.location.host + "/pidum/pdm-p47/update?id="+id;
    $(location).attr('href',url);
});


JS;

$this->registerJs($js);
?>

</div>

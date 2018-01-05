<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use kartik\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\pidum\models\PdmB10Search */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = $sysMenu->kd_berkas;
$this->subtitle = $sysMenu->keterangan;
//$this->params['breadcrumbs'][] = $this->title;
?>
<div class="pdm-ba17-index">

<?php
    $form = ActiveForm::begin([
        'id' => 'hapus-index',
        'action' => '/pidum/pdm-b10/delete'
    ]);
    ?>
    <div id="divHapus">
        <div class="pull-left"><?= Html::a('Tambah', ['create'], ['class' => 'btn btn-warning']) ?></div>
    </div>
    
    <div id="divHapus">
        <div class="pull-right"><a class='btn btn-danger hapusTembusan btnHapusCheckboxIndex'>Hapus</a><br></div>
    </div>
    <?php ActiveForm::end() ?>

    <br/>
    <div class="row">
        <br/>
        <div class="col-md-12">

       <?=
    GridView::widget([
        'id' => 'pdm-b16',
        'rowOptions' => function ($model, $key, $index, $grid) {
                return ['data-id' => $model['tgl_b10']];
            },
        'dataProvider' => $dataProvider,
        //'showOnEmpty' => false,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            [
                'attribute' => 'no_register_perkara',
                'label' => 'no_register_perkara',
                //'format' => ['date', 'php:d-m-Y'],
            ],
            [
                'attribute'=>'tgl_b10',
                'label' => 'Tanggal B-10',
                'format' => 'raw',
                'value'=>function ($model, $key, $index, $widget) {
                    return Yii::$app->globalfunc->ViewIndonesianFormat($model->tgl_b10);
                },
            ],
            [
                'class' => '\kartik\grid\CheckboxColumn',
                //'header' => '',
                'multiple' => true,
                'checkboxOptions' => function ($model, $key, $index, $column) {
                        return ['value' => $model['tgl_b10'], 'class' => 'checkHapusIndex'];
                    }
            ],
        ],
        'export' => false,
        'pjax' => true,
        'responsive' => true,
        'hover' => true,
    ]); ?>
    </div>
    </div>

</div>

<?php
$js = <<< JS
        $('td').dblclick(function (e) {
        var id = $(this).closest('tr').data('id');
        var url = window.location.protocol + "//" + window.location.host + "/pidum/pdm-b10/update?id="+id;
        $(location).attr('href',url);
    });
JS;
$this->registerJs($js);
?>


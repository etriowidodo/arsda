<?php

use yii\helpers\Html;

use kartik\grid\GridView;
use kartik\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\pidum\models\PdmP40Search */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = $sysMenu->kd_berkas;
$this->subtitle = $sysMenu->keterangan;
?>
<div class="pdm-p40-index">


 
	

<?php
    $form = ActiveForm::begin([
        'id' => 'hapus-index',
        'action' => '/pdsold/pdm-p40/delete'
    ]);
    ?>
	<div id="divHapus">
                <div class="pull-left"><?= Html::a('Tambah', ['create'], ['class' => 'btn btn-success']) ?></div>
            </div>
	
	<div id="divHapus">
                <div class="pull-right"><a class='btn btn-danger delete hapusTembusan btnHapusCheckboxIndex'></a><br></div>
            </div>
			<?php ActiveForm::end() ?>
            


   	<div class="row">
                <div class="col-md-12">
    <?=
    GridView::widget([
        'id' => 'pdm-b16',
        'rowOptions' => function ($model, $key, $index, $grid) {
                return ['data-id' => $model['no_surat_p40']];
            },
        'dataProvider' => $dataProvider,
        //'showOnEmpty' => false,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            [
                'attribute' => 'no_surat_p40',
                'label' => 'Nomor Surat',
                //'format' => ['date', 'php:d-m-Y'],
            ],
            [
                'attribute' => 'kepada',
                'label' => 'Kepada',
            ],
			 [
                'attribute' => 'tgl_dikeluarkan',
                'label' => 'Tanggal',
                'value' => function ($model, $key, $index, $widget) {
                            return Yii::$app->globalfunc->ViewIndonesianFormat($model->tgl_dikeluarkan);
                        }
            ],
            [
                'class' => '\kartik\grid\CheckboxColumn',
                //'header' => '',
                'multiple' => true,
                'checkboxOptions' => function ($model, $key, $index, $column) {
                        return ['value' => $model['no_surat_p40'], 'class' => 'checkHapusIndex'];
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
        var url = window.location.protocol + "//" + window.location.host + "/pdsold/pdm-p40/update?id="+id;
        $(location).attr('href',url);
    });
JS;
$this->registerJs($js);
?>

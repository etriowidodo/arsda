<?php

use yii\helpers\Html;
use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\pidum\models\PdmBA3Search */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = $sysMenu->kd_berkas;
$this->subtitle = $sysMenu->keterangan
?>
<div class="pdm-ba3-index">
	
	<div id="divTambah" class="col-md-11">
        <?= Html::a('Tambah', ['create'], ['class' => 'btn btn-warning']) ?>
    </div>
	<?php
       $form = \kartik\widgets\ActiveForm::begin([
            'id' => 'hapus-index',
            'action' => '/pidum/pdm-ba3/delete/'
        ]);  
    ?>
	<div id="divHapus" class="col-md-1">
        <button class='btn btn-warning btnHapusCheckboxIndex'>Hapus</button>
    </div>
	<?php \kartik\widgets\ActiveForm::end() ?>
    <div class="clearfix"><br><br></div>
	
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
       // 'filterModel' => $searchModel,
		'rowOptions'   => function ($model, $key, $index, $grid) {
            return ['data-id' => $model['id_ba3']];
		},
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
			
			'jam',
			[
                'attribute'=>'tgl_pembuatan',
                'label' => 'Tanggal Pembuatan',
                'format' => 'raw',
                'value'=>function ($model, $key, $index, $widget) {
                    return $model['tgl_pembuatan'];
                },
			],
				
				[
                'class'=>'kartik\grid\CheckboxColumn',
                    'headerOptions'=>['class'=>'kartik-sheet-style'],
                    'checkboxOptions' => function ($model, $key, $index, $column) {
                        return ['value' => $model['id_ba3'], 'class' => 'checkHapusIndex'];
                    }
            ],
        ],
		'export' => false,
        'pjax' => true,
        'responsive'=>true,
        'hover'=>true,
    ]); ?>

</div>

<?php
 
    $js = <<< JS
        $('td').dblclick(function (e) {
        var idba3 = $(this).closest('tr').data('id');
        var url = window.location.protocol + "//" + window.location.host + "/pidum/pdm-ba3/update?id_ba3=" + idba3;
        $(location).attr('href',url);
    });

JS;

    $this->registerJs($js);
?>

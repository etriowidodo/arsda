<?php

use yii\helpers\Html;
use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\pidum\models\PdmP10Search */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = $sysMenu->kd_berkas;
$this->subtitle = $sysMenu->keterangan;
?>
<div class="pdm-p10-index">
<div id="divTambah" class="col-md-11">
    <?= Html::a('Tambah', ['create'], ['class' => 'btn btn-warning']) ?>
</div>

    <?php
    $form = \kartik\widgets\ActiveForm::begin([
                'id' => 'hapus-index',
                'action' => '/pidum/pdm-p10/delete'
    ]);
    ?>
	
	<div id="divHapus" class="col-md-1">
        <button class='btn btn-warning btnHapusCheckboxIndex'>Hapus</button>
    </div>
	<?php \kartik\widgets\ActiveForm::end() ?>
    <div class="clearfix"><br><br></div>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        //'filterModel' => $searchModel,
		'rowOptions' => function ($model, $key, $index, $grid) {
         return ['data-id' => $model['id_p10']];
		 },
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            [
                'attribute'=>'no_surat',
                'label' => 'No Surat',
                'format' => 'raw',
                'value'=>function ($model, $key, $index, $widget) {
                    return $model['no_surat'];
                },


            ],
			
			[
                'attribute'=>'tgl_dikeluarkan',
                'label' => 'Tanggal Surat',
                'format' => 'raw',
                'value'=>function ($model, $key, $index, $widget) {
                    return $model['tgl_dikeluarkan'];
                },
            ],
			
			[
                'attribute'=>'ket_ahli',
                'label' => 'Keterangan Ahli',
                'format' => 'raw',
                'value'=>function ($model, $key, $index, $widget) {
                    return $model['ket_ahli'];
                },
			],
			
			[
			'class' => 'kartik\grid\CheckboxColumn',
			'headerOptions' => ['class' => 'kartik-sheet-style'],
            'checkboxOptions' => function ($model, $key, $index, $column) {
            return ['value' => $model['id_p10'], 'class' => 'checkHapusIndex'];
            }
				],
            ],
			'export' => false,
            'pjax' => true,
            'responsive' => true,
            'hover' => true,
			   ]); ?>

</div>

<?php

 
    $js = <<< JS
        $('td').dblclick(function (e) {
        var idp10 = $(this).closest('tr').data('id');
        var url = window.location.protocol + "//" + window.location.host + "/pidum/pdm-p10/update?id=" + idp10;
        $(location).attr('href',url);
    });

JS;

    $this->registerJs($js);
?>

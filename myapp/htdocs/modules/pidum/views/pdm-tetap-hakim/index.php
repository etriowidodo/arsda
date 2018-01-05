<?php

use yii\helpers\Html;
use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\pidum\models\PdmTetapHakimSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Tetap Penetapan Hakim';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="pdm-tetap-hakim-index">
<div id="divTambah" class="col-md-11">
        <?= Html::a('Tambah', ['create'], ['class' => 'btn btn-warning']) ?>
    </div>
    <?php
       $form = \kartik\widgets\ActiveForm::begin([
            'id' => 'hapus-index',
            'action' => '/pidum/pdm-tetap-hakim/delete/'
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
		'rowOptions'   => function ($model, $key, $index, $grid) {
            return ['data-id' => $model['id_thakim']];
		},
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
					
			[
                'attribute'=>'no_surat',
                'label' => 'Nomor Surat',
                'format' => 'raw',
                'value'=>function ($model, $key, $index, $widget) {
                    return $model['no_surat'];
                },
            ],
			
						
			[
                'attribute'=>'tgl_surat',
                'label' => 'Tanggal Surat',
                'format' => 'raw',
                'value'=>function ($model, $key, $index, $widget) {
                    return $model['tgl_surat'];
                },
            ],
			
			[
                'attribute'=>'tgl_terima',
                'label' => 'Tanggal Terima',
                'format' => 'raw',
                'value'=>function ($model, $key, $index, $widget) {
                    return $model['tgl_terima'];
                },
            ],
			

            [
                'class'=>'kartik\grid\CheckboxColumn',
                    'headerOptions'=>['class'=>'kartik-sheet-style'],
                    'checkboxOptions' => function ($model, $key, $index, $column) {
                        return ['value' => $model['id_thakim'], 'class' => 'checkHapusIndex'];
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
        var idthakim = $(this).closest('tr').data('id');
        var url = window.location.protocol + "//" + window.location.host + "/pidum/pdm-tetap-hakim/update?id_thakim=" + idthakim;
        $(location).attr('href',url);
    });

JS;

    $this->registerJs($js);
?>

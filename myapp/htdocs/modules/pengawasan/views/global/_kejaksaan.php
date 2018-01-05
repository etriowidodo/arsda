<?php
use yii\helpers\Html;
use kartik\grid\GridView;
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
?>
<script>
	function pilihKejaksaan(id, param){
		var value = $("#pilihKejaksaan"+id).val();
		$("#"+param+"-inst_satkerkd").val(id);
		$("#inst_nama").val(value);
		$('#kejaksaan').modal('hide');
	}
</script>
<?php 
                        
	$searchModel = new \app\modules\pengawasan\models\Was16aSearch();
	$dataProvider = $searchModel->searchKejaksaan($model->id_register);
    $gridColumn =  [
		[
        'class' => '\kartik\grid\DataColumn',
        'attribute'=>'inst_satkerkd',
        'label' => 'Kode Kejaksaan',
		],
        [
        'class' => '\kartik\grid\DataColumn',
        'attribute' => 'inst_nama',
        'label' => 'Nama Kejaksaan',
        ],
        [
        'class' => '\kartik\grid\ActionColumn',
         'template' => '{pilih}',
                'buttons' => [
                    'pilih' => function ($url, $model,$key) use($param) {
                        return Html::button('Pilih', ['onClick'=>'pilihKejaksaan("'.$model['inst_satkerkd'].'","'.$param.'")', 
																				'id'=>'pilihKejaksaan'.$model['inst_satkerkd'], 
																				'value'=>$model['inst_nama']]);
                    }
				],
        ]
	];
	echo GridView::widget([
		'dataProvider'=> $dataProvider,
		// 'filterModel' => $searchModel,
		'id' => 'gridKejaksaan',
		'layout'=>"{items}",
		'columns' => $gridColumn,
		'responsive'=>true,
		'hover'=>true,
		'export'=>false,
		'pjax' => true,
		'panel' => [
			'type' => GridView::TYPE_PRIMARY,
			'heading' => '<i class="glyphicon glyphicon-book"></i>',
		],
	]);
?>

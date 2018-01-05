
    
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
	function pilihTembusan(id, param){		
		var value = $("#pilihTembusan"+id).val();
		var data = value.split('#');
		var count = 1;
		$('#tbody_tembusan-'+param).append(
			'<tr id="tembusan'+data[0]+'">' +
				'<td><input type="text" class="form-control" name="jabatan[]" readonly="true" value="'+data[0]+'">'+
				'<input type="hidden" class="form-control" name="id_jabatan[]" value="'+id+'">'+
				'</td>' +
				'<td><?= Html::Button('<i class="fa fa-times"></i> Hapus', ['class' => 'btn btn-primary', 'id'=>'hapusTembusan']) ?></td>' +
			'</tr>'
		);
		$('#m_tembusan').modal('hide');
	}
</script>
<?php 
    $searchModel = new \app\modules\pengawasan\models\VPejabatTembusan();
	$dataProvider = $searchModel->searchTembusanWas(Yii::$app->request->queryParams);
    $gridColumn = [
		[
		'class' => '\kartik\grid\DataColumn',
		'attribute'=>'wilayah',
		'label' => 'Wilayah',
		],
		[
		'class' => '\kartik\grid\DataColumn',
		'attribute'=>'bidang',
		'label' => 'Bidang',
		],
		[
		'class' => '\kartik\grid\DataColumn',
		'attribute'=>'jabatan',
		'label' => 'Jabatan',
		],
        [
        'class' => '\kartik\grid\ActionColumn',
         'template' => '{pilih}',
                'buttons' => [
                    'pilih' => function ($url, $model,$key) use($param) {
                        return Html::button('<i class="fa fa-check"></i> Pilih', ['class' => 'btn btn-primary','onClick'=>'pilihTembusan('.$model['id_pejabat_tembusan'].',"'.$param.'")', 'id'=>'pilihTembusan'.$model['id_pejabat_tembusan'], 'value'=>$model['jabatan']]);
                    }
				],
        ],
	];
	echo GridView::widget([
		'dataProvider'=> $dataProvider,
		'filterModel' => $searchModel,
		'id' => 'gridPegawaiTT',
		'layout'=>"{items}",
		'columns' => $gridColumn,
		'responsive'=>true,
		'hover'=>true,
		'export'=>false,
		'pjax' => true,
		'panel' => [
			'type' => GridView::TYPE_PRIMARY,
			'heading' => '<i class="glyphicon glyphicon-th-list"></i>',
		],
	]); 
?>

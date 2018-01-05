
    
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
	/* function pilihTembusan(id, param){
		var value = $("#pilihTembusan"+id).val();
		var data = value.split('#');
		var count = 1;
                
		$('#tbody_tembusan-'+param).append(
			'<tr id="tembusan-'+id+'">' +
				'<td><input type="text" class="form-control" name="jabatan[]" readonly="true" value="'+data[0]+'"> </td><input type="hidden" class="form-control" name="id_jabatan[]"  value="'+id+'"> ' +
				'<td><button onclick="removeRow(\'tembusan-'+id+'\')" class="btn btn-primary" type="button"> <i class="fa fa-times"></i> Hapus</button></td>' +
			'</tr>'
		);
		$('#tembusan').modal('hide');
               $('#p_tembusaneks').modal('hide');
		//alert("aaa");
	} */
</script>
<?php
$this->registerJs( " 
    $(document).ready(function(){
      $('.pilihTembusan').click(function(){
       
        $('input[type=checkbox]:checked').each(function () {
          var dataTembusan = $(this).val().split('#');
          $('#tbody_tembusan-'+dataTembusan[2]).append(
          '<tr id=\"tembusan-'+dataTembusan[0]+'\"><td><input type=\"text\" class=\"form-control\" name=\"jabatan[]\" readonly=\"true\" value=\"'+dataTembusan[1]+'\"> </td><input type=\"hidden\" class=\"form-control\" name=\"id_jabatan[]\"  value=\"'+dataTembusan[0]+'\"> <td><button type=\"button\"  class=\"removebutton btn btn-primary\"><i class=\"fa fa-times\"></i> Hapus</button></tr>');
         
});
 $('#tembusan').modal('hide');
     
           $('#p_tembusaneks').modal('hide');
});


 
}); ", \yii\web\View::POS_END);

?>  
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
                        return Html::checkbox('<i class="fa fa-check"></i> Pilih',false ,['class' => 'btn btn-primary', 'value'=>$model['id_pejabat_tembusan'].'#'.$model['jabatan'].'#'.$param, 'id'=>'pilihTembusan'.$model['id_pejabat_tembusan']]);
                    }
				],
        ],
	];
	echo GridView::widget([
		 'id'=>'tembusan-grid',
            'dataProvider'=> $dataProvider,
            'filterModel' => $searchModel,
            'layout' => "{items}\n{pager}",
		'columns' => $gridColumn,
            'export' => false,
            'pjax' => true,
            'responsive'=>true,
            'hover'=>true,
            'panel' => [
                'type' => GridView::TYPE_PRIMARY,
                'heading' => '<i class="glyphicon glyphicon-th-list"></i>',
            ],

            'pjaxSettings'=>[
                'options'=>[
                    'enablePushState'=>false,
                ],
                'neverTimeout'=>true,
              //  'beforeGrid'=>['columns'=>'peg_nip'],
            ]

        ]);
?>
 <?= Html::Button('Pilih', ['class' => 'pilihTembusan btn btn-primary','id'=>"PilihTembusan"]) ?>

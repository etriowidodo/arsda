<?php

use yii\helpers\Html;
use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\pidum\models\PdmPratutPutusanSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Penyelesaian Pra Penuntutan';
// $this->params['breadcrumbs'][] = $this->title;
?>
<div class="pdm-pratut-putusan-index">
  <!------
<div id="divTambah" class="col-md-11">
        <?= Html::a('Tambah', ['create'], ['class' => 'btn btn-warning']) ?>
    </div>
    <?php
       $form = \kartik\widgets\ActiveForm::begin([
            'id' => 'hapus-index',
            'action' => '/pdsold/pdm-pratut-putusan/delete/'
        ]);  
    ?>  
   
    <?php \kartik\widgets\ActiveForm::end() ?>---->
    <div class="clearfix"><br><br></div>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
     //   'filterModel' => $searchModel,
        'rowOptions'   => function ($model, $key, $index, $grid) {
			//print_r($model);exit;
            return ['data-id' => $model['pratut'],'data-idberkas' => $model['berkas']];
			
		},
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            
     		[
                'attribute'=>'no_berkas',
                'label' => 'Nomor dan tanggal berkas',
                'format' => 'raw',
                'value'=>function ($model, $key, $index, $widget) {
                    return $model['no'].'<br>'.$model['tgl'];
					
                },


            ],
             
        [
                'attribute'=>'nama',
                'label' => 'Nama Tersangka',
                'format' => 'raw',
                'value'=>function ($model, $key, $index, $widget) {
                    return $model['nama'];
                },


            ], 
                        
        [
                'attribute'=>'proses',
                'label' => 'Proses Penyelesaian',
                'format' => 'raw',
                'value'=>function ($model, $key, $index, $widget) {
					if($model['proses']==1){
                    return 'Di Limpahkan';}
					if($model['proses']==2){
                    return 'Penyidikan Optimal';}
					if($model['proses']==3){
                    return 'SP3';}
                },


            ],        
       
            
             /*  [
                'class'=>'kartik\grid\CheckboxColumn',
                    'headerOptions'=>['class'=>'kartik-sheet-style'],
                    'checkboxOptions' => function ($model, $key, $index, $column) {
                        return ['value' => $model['id_pratut'], 'class' => 'checkHapusIndex'];
                    }
            ], */
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
        var idpratut = $(this).closest('tr').data('id');
	
	 var idberkas = $(this).closest('tr').data('idberkas');
		
			  var url = window.location.protocol + "//" + window.location.host + "/pdsold/pdm-pratut-putusan/update?id_pratut=" + idpratut+"&id_berkas=" +idberkas;
        $(location).attr('href',url);
	
      
    });

JS;

    $this->registerJs($js);
?>


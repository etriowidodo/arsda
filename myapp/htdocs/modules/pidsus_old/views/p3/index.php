<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use kartik\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $searchModel app\models\PdsLidRenlidSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'P3 - Rencana Penyelidikan';
//$this->params['breadcrumbs'][] = ['label' => 'Pidsus', 'url' => ['../pidsus/default/index']];
//$this->params['breadcrumbs'][] = $this->title;

require('..\modules\pidsus\controllers\viewFormFunction.php');
$viewFormFunction=new viewFormFunction();
$this->params['idtitle']=$_SESSION['noLapLid'];
?>
<div class="pds-lid-renlid-index">

    <?php
        $form = \kartik\widgets\ActiveForm::begin([
            'id' => 'hapus-spdp',
            'action' => '/pidsus/p3/deletebatchsurat'
        ]);
    ?>
    <div id="divHapus" class="form-group">
	<input type="hidden" name="typeSurat" value="lid">
	<input type="hidden" name="jenisSurat" value="<?=$idJenisSurat ?>">
    </div>
    
    <div class="form-group"><div class="col-md-11"></div></div>
    <div id="btnUpdate"></div>
    <?php \kartik\widgets\ActiveForm::end() ?>
	
	<p>
	<span class="pull-right"><?= Html::a('<i class="fa fa-plus"> </i> Tambah ', ['create'], ['class' => 'btn btn-success']) ?>
    
    <button id="btnHapusBatch" class="btn btn-danger" type="button"><i class="fa fa-times"></i> Hapus</button>
    </span>
  </br>
  </br>
  </p>
  
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
    	'rowOptions'   => function ($model, $key, $index, $grid) {
    		return ['data-id' => $model['id_pds_lid_renlid']];
    		},
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'laporan',
            'kasus_posisi',
             //'dugaan_pasal',
             //'alat_bukti',
             //'sumber',
             //'pelaksana',
             //'tindakan_hukum',
             //'waktu',
        	  //'tempat',
        	  'waktu_tempat',	
             //'koor_dan_dal',
             'keterangan',
            // 'create_by',
            // 'create_date',
            // 'update_by',
            // 'update_date',
        	[
        		'class'=>'kartik\grid\CheckboxColumn',
        		'headerOptions'=>['class'=>'kartik-sheet-style'],
        		'checkboxOptions' => function ($model, $key, $index, $column) {
        			return ['value' => $model['id_pds_lid_renlid']];
        		}
        		],

           
        ],
    		'export' => false,
    		'hover'=>true,
    		'toolbar'=>false,
    		'panel' => [
    				'type' => GridView::TYPE_DANGER,
    				
    		],
    		
    		
    ]); ?>

</div>
    <?php $form = ActiveForm::begin(
	 [
                'id' => 'p2-form',
                'type' => ActiveForm::TYPE_HORIZONTAL,
                'enableAjaxValidation' => false,
                'fieldConfig' => [
                    'autoPlaceholder'=>false
                ],
                'formConfig' => [
                    'deviceSize' => ActiveForm::SIZE_SMALL,
                    'labelSpan' => 1,
                    'showLabels'=>false

                ]
            ]); ?>
					<div>
						        		
							        	<div class="col-md-10">
								        	</div>
								         
							        	<div class="col-md-2">	        		
								          	<?=Html::a('Kembali', ['../pidsus/default/viewlaporan?id='.$_SESSION['idPdsLid']], ['data-pjax'=>0, 'class' => 'btn btn-primary', 'title'=>'cancel','id' => 'btnCancel']) ?>
						    			 
								      			<?=Html::a('Cetak', ['../pidsus/default/viewreportlid','id'=>$modelSurat->id_pds_lid_surat,'jenisSurat'=>'p3'], ['data-pjax'=>0, 'class' => 'btn btn-success', 'title'=>'View Report']) ?>
								      	</div>	
							        </div>
   
    <?php ActiveForm::end(); 
     $js = <<< JS
        $('td').dblclick(function (e) {
        var id = $(this).closest('tr').data('id');
        var url = window.location.protocol + "//" + window.location.host + "/pidsus/p3/update?id="+id;
        $(location).attr('href',url);
    }); 
    
JS;
    $this->registerJs($js);
    ?>
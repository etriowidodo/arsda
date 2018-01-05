<?php

use yii\helpers\Html;
use kartik\widgets\ActiveForm;
use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\PdsLidSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Pidsus 5';
//$this->params['breadcrumbs'][] = ['label' => 'Pidsus', 'url' => ['../pidsus/default/index']];
//$this->params['breadcrumbs'][] = $this->title;
require('..\modules\pidsus\controllers\viewFormFunction.php');
$viewFormFunction=new viewFormFunction();
$this->params['idtitle']=$_SESSION['noLapLid'];
?>
<div class="pds-lid-index">
	
    <h1><?= Html::encode('Pidsus 5A - Permintaan Keterangan') ?></h1>
    <?php
        $form = \kartik\widgets\ActiveForm::begin([
            'id' => 'hapus-spdp',
            'action' => '/pidsus/default/deletebatchsurat'
        ]);
    ?>
    <div id="divHapus" class="form-group">
	<input type="hidden" name="typeSurat" value="lid">
	<input type="hidden" name="jenisSurat" value="pidsus5">
    </div>
    
    
    <div id="btnUpdate"></div>
    <?php \kartik\widgets\ActiveForm::end() ?>
    <p>
	<span class="pull-right"><?= Html::a('<i class="fa fa-plus"> </i> Tambah ', ['create?idJenisSurat=pidsus5a&id='.$id], ['class' => 'btn btn-success']) ?>
    
    <button id="btnHapusBatch" class="btn btn-danger" type="button"><i class="fa fa-times"></i> Hapus</button>
    </span>
  </br>
  </br>
  </p>	
    <?= GridView::widget([
        'dataProvider' => $dataProvider5a,
        
    	'rowOptions'   => function ($model, $key, $index, $grid) {
		        	return ['data-id' => $model['id_pds_lid_surat'],'data-jenisSurat'=>'pidsus5a'];
		       },
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'no_surat',
            ['attribute'=>'tgl_surat','header'=>'Tanggal Surat','format'=>['date','dd-MM-yyyy']],
            ['attribute'=>'kepada','header'=>'Penerima Surat'],
			
             [
        		'class'=>'kartik\grid\CheckboxColumn',
        		'headerOptions'=>['class'=>'kartik-sheet-style'],
        		'checkboxOptions' => function ($model, $key, $index, $column) {
        			return ['value' => $model['id_pds_lid_surat']];
        		}
        		],
        ],
    		'export' => false,
    		'pjax' => true,
    		'responsive'=>true,
    		'toolbar'=>false,
    		'hover'=>true,
    		'panel' => [
    				'type' => GridView::TYPE_DANGER,
    				
    		],
    		
    		
    		
    ]); ?>
	<h1><?= Html::encode('Pidsus 5B - Bantuan Pemanggilan') ?></h1>
	<?php
        $form = \kartik\widgets\ActiveForm::begin([
            'id' => 'hapus-spdpb',
            'action' => '/pidsus/default/deletebatchsurat'
        ]);
    ?>
    <div id="divHapusb" class="form-group">
	<input type="hidden" name="typeSurat" value="lid">
	<input type="hidden" name="jenisSurat" value="pidsus5">
    </div>
    
    
    <div id="btnUpdate"></div>
    <?php \kartik\widgets\ActiveForm::end() ?>
    <p>
	<span class="pull-right"><?= Html::a('<i class="fa fa-plus"> </i> Tambah ', ['create?idJenisSurat=pidsus5b&id='.$id], ['class' => 'btn btn-success']) ?>
    
    <button id="btnHapusBatchb" class="btn btn-danger" type="button"><i class="fa fa-times"></i> Hapus</button>
    </span>
  </br>
  </br>
  </p>	
    <?= GridView::widget([
        'dataProvider' => $dataProvider5b,
        
    	'rowOptions'   => function ($model, $key, $index, $grid) {
		        	return ['data-id' => $model['id_pds_lid_surat'],'data-jenisSurat'=>'pidsus5b'];
		       },
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

           
            'no_surat',
            ['attribute'=>'tgl_surat','header'=>'Tanggal Surat','format'=>['date','dd-MM-yyyy']],
            ['attribute'=>'kepada','header'=>'Penerima Surat'],

             [
        		'class'=>'kartik\grid\CheckboxColumn',
        		'headerOptions'=>['class'=>'kartik-sheet-style'],
        		'checkboxOptions' => function ($model, $key, $index, $column) {
        			return ['value' => $model['id_pds_lid_surat']];
        		}
        		],
        ],
    		'export' => false,
    		'pjax' => true,
    		'responsive'=>true,
    		'toolbar'=>false,
    		'hover'=>true,
    		'panel' => [
    				'type' => GridView::TYPE_DANGER,
    				
    		],
    		
    ]); ?>
    <h1><?= Html::encode('Pidsus 5C - Bantuan Permintaan Data\Tindakan Lain') ?></h1>
    <?php
        $form = \kartik\widgets\ActiveForm::begin([
            'id' => 'hapus-spdpc',
            'action' => '/pidsus/default/deletebatchsurat'
        ]);
    ?>
    <div id="divHapusc" class="form-group">
	<input type="hidden" name="typeSurat" value="lid">
	<input type="hidden" name="jenisSurat" value="pidsus5">
    </div>
    
    <div class="form-group"><div class="col-md-11"></div></div>
    <div id="btnUpdate"></div>
    <?php \kartik\widgets\ActiveForm::end() ?>
    <p>
	<span class="pull-right"><?= Html::a('<i class="fa fa-plus"> </i> Tambah ', ['create?idJenisSurat=pidsus5c&id='.$id], ['class' => 'btn btn-success']) ?>
    
    <button id="btnHapusBatchc" class="btn btn-danger" type="button"><i class="fa fa-times"></i> Hapus</button>
    </span>
  </br>
  </br>
  </p>	
    <?= GridView::widget([
        'dataProvider' => $dataProvider5c,
        
    	'rowOptions'   => function ($model, $key, $index, $grid) {
		        	return ['data-id' => $model['id_pds_lid_surat'],'data-jenisSurat'=>'pidsus5c'];
		       },
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'no_surat',
            ['attribute'=>'tgl_surat','header'=>'Tanggal Surat','format'=>['date','dd-MM-yyyy']],
            ['attribute'=>'kepada','header'=>'Penerima Surat'],

             [
        		'class'=>'kartik\grid\CheckboxColumn',
        		'headerOptions'=>['class'=>'kartik-sheet-style'],
        		'checkboxOptions' => function ($model, $key, $index, $column) {
        			return ['value' => $model['id_pds_lid_surat']];
        		}
        		],
        ],
    		'export' => false,
    		'pjax' => true,
    		'responsive'=>true,
    		'toolbar'=>false,
    		'hover'=>true,
    		'panel' => [
    				'type' => GridView::TYPE_DANGER,
    				
    		],
    		
    	
    ]); ?>
    <div>
						        		
							        	<div class="col-md-11">
								        	</div>
								         
							        	<div class="col-md-1">	        		
								          	<?=Html::a('Kembali', ['../pidsus/default/viewlaporan?id='.$_SESSION['idPdsLid']], ['data-pjax'=>0, 'class' => 'btn btn-primary', 'title'=>'cancel','id' => 'btnCancel']) ?>
						    			 </div>		      		     	
							        	
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
    
							        
    <?php ActiveForm::end(); 
    $js = <<< JS
        $('td').dblclick(function (e) {
        var id = $(this).closest('tr').data('id');
        var url = window.location.protocol + "//" + window.location.host + "/pidsus/pidsus5/update?id="+id;
        $(location).attr('href',url);
    });
    
    
    $( "input" ).change(function(e) {
        var input = $( this );
        if(input.prop( "checked" ) == true){
            console.log(e.target.value);
			var data = (e.target.value).split('#');
            $('.hapus').show();
            $('#btnHapus'+data[1]).html(
                ""
            );
			$('#divHapus'+data[1]).append(
                ""
            );
    
    
        }
    
    
    
    });
		$(document).on("pjax:beforeSend", function (e, xhr, settings) {
        var uri = URI(settings.url);
        uri.removeSearch("_pjax");
        location.href = uri.toString();
        return false;
    
});
JS;
    
    
		$this->registerJs($js);
    		?>
</div>
<script>
$('#btnHapusBatchb').click(function () {
	
	bootbox.dialog({
            message: "Apakah anda ingin menghapus data ini?",
            buttons:{
                ya : {
                    label: "Ya",
                    className: "btn-warning",
                    callback: function(){
                    	var checkboxes = document.getElementsByName('selection[]');
                    	for (var i=0, n=checkboxes.length;i<n;i++) {
							  if (checkboxes[i].checked) 
							  {
								  $('#divHapusb').append(
							                "<input type='hidden' id='hapus' name='hapusPds[]' value='"+checkboxes[i].value+"'>"
							            );  
							  }
                    	}
                        $('#hapus-spdpb').submit();
                    }
                },
                tidak : {
                    label: "Tidak",
                    className: "btn-warning",
                    callback: function(result){
                    }
                },
            },
        });
});

$('#btnHapusBatchc').click(function () {
	
	bootbox.dialog({
            message: "Apakah anda ingin menghapus data ini?",
            buttons:{
                ya : {
                    label: "Ya",
                    className: "btn-warning",
                    callback: function(){
                    	var checkboxes = document.getElementsByName('selection[]');
                    	for (var i=0, n=checkboxes.length;i<n;i++) {
							  if (checkboxes[i].checked) 
							  {
								  $('#divHapusc').append(
							                "<input type='hidden' id='hapus' name='hapusPds[]' value='"+checkboxes[i].value+"'>"
							            );  
							  }
                    	}
                        $('#hapus-spdpc').submit();
                    }
                },
                tidak : {
                    label: "Tidak",
                    className: "btn-warning",
                    callback: function(result){
                    }
                },
            },
        });
});
    		</script>

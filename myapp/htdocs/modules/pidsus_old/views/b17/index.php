<?php

use yii\helpers\Html;
use kartik\widgets\ActiveForm;
use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\PdsLidSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = $titleMain;
//$this->params['breadcrumbs'][] = ['label' => 'Penyidikan', 'url' => ['../pidsus/default/viewlaporandik','id'=>$id]];
//$this->params['breadcrumbs'][] = $this->title;
require('..\modules\pidsus\controllers\viewFormFunction.php');
$viewFormFunction=new viewFormFunction();
$this->params['idtitle']=$_SESSION['noSpdpDik'];
$sqlB4='select ddl_value, ddl_text from pidsus.get_list_b4_ddl(\''.$_SESSION['idPdsDik'].'\')';
?>
<div class="pds-lid-index">
	<?php
        $form = \kartik\widgets\ActiveForm::begin([
            'id' => 'hapus-spdp',
            'action' => '/pidsus/default/deletebatchsurat'
        ]);
    ?>
    <div id="divHapus" class="form-group">
	<input type="hidden" name="typeSurat" value="dik">
	<input type="hidden" name="jenisSurat" value="<?=$idJenisSurat ?>">
    </div>
    
    <div id="btnUpdate"></div>
    <?php \kartik\widgets\ActiveForm::end() ?>
   <p> <?php
        $form2 = \kartik\widgets\ActiveForm::begin([
            'id' => 'create_form',
            'action' => '/pidsus/b17/create'
        ]);
        
       ?>
    <div class="col-md-2"></div>   
    <div class="col-md-7">
    <?php  echo $viewFormFunction->returnSelect2withoutmodel($sqlB4, $form2, 'ddl_value', 'ddl_text', '', 'select_b4');
    ?>
    </div>
    <?php \kartik\widgets\ActiveForm::end() ?>
	<button id="btnAddSelectB4" class="btn btn-success" type="button" onclick="$('#create_form').submit()"><i class="fa plus"></i> Tambah</button>
    
    <button id="btnHapusBatch" class="btn btn-danger" type="button"><i class="fa fa-times"></i> Hapus</button>
    </span>
  </br>
  </br>
  </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
    	'rowOptions'   => function ($model, $key, $index, $grid) {
		        	return ['data-id' => $model['id_pds_dik_surat']];
		       },
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

           
            'no_surat',
            ['attribute'=>'tgl_surat','header'=>'Tanggal Surat','format'=>['date','dd-MM-yyyy']],

             [
        		'class'=>'kartik\grid\CheckboxColumn',
        		'headerOptions'=>['class'=>'kartik-sheet-style'],
        		'checkboxOptions' => function ($model, $key, $index, $column) {
        			return ['value' => $model['id_pds_dik_surat']];
        		}
        		],
        ],
    		'export' => false,
    		'pjax' => false,
    		'responsive'=>true,
    		'hover'=>true,
    		'panel' => [
    				'type' => GridView::TYPE_DANGER,
    				
    		],
    		
    		'toolbar' =>  false,
    ]); ?>
    <?php
    	$delButton=Html::submitButton( 'Simpan', ['class' => 'btn btn-primary', 'name'=>'btnSubmit', 'value'=>'simpan','data' => ['confirm' => 'Apakah anda yakin ingin menghapus?']]) ;
		$js = <<< JS
        $('td').dblclick(function (e) {
        var id = $(this).closest('tr').data('id');
        var url = window.location.protocol + "//" + window.location.host + "/pidsus/$idJenisSurat/update?id="+id;
        $(location).attr('href',url);
    });



JS;


		$this->registerJs($js);		
?>
    <?php $form = ActiveForm::begin(
	 [
                'id' => 'b4-form',
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
						        		
							        	<div class="col-md-8">
								        	<?php //$viewFormFunction->returnDropDownListStatus($form,$modelLid,$modelLid->id_status)?>
								          </div>
								         
							        	<div class="col-md-4">
							        		
								          	<?php //Html::submitButton('Submit', ['class' => 'btn btn-primary']) ?>
								        </div>
							        </div>
							        
    <?php ActiveForm::end(); ?>
</div>

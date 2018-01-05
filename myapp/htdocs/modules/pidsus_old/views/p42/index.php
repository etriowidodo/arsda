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
?>
<div class="pds-lid-index">
	<?php
        $form = \kartik\widgets\ActiveForm::begin([
            'id' => 'hapus-spdp',
            'action' => '/pidsus/default/deletebatchsurat'
        ]);
    ?>
    <div id="divHapus" class="form-group">
	<input type="hidden" name="typeSurat" value="tut">
	<input type="hidden" name="jenisSurat" value="<?=$idJenisSurat ?>">
    </div>
    
    <div class="form-group"><div class="col-md-11"></div><div class="col-md-1" id="btnHapus"><div id='btnHapusBatch' class='btn btn-danger hapus' >Hapus</div></div></div>
    <div id="btnUpdate"></div>
    <?php \kartik\widgets\ActiveForm::end() ?>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
    	'rowOptions'   => function ($model, $key, $index, $grid) {
		        	return ['data-id' => $model['id_pds_tut_surat']];
		       },
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

           
            'no_surat',
            ['attribute'=>'tgl_surat','header'=>'Tanggal Surat','format'=>['date','dd-MM-yyyy']],

             [
        		'class'=>'kartik\grid\CheckboxColumn',
        		'headerOptions'=>['class'=>'kartik-sheet-style'],
        		'checkboxOptions' => function ($model, $key, $index, $column) {
        			return ['value' => $model['id_pds_tut_surat']];
        		}
        		],
        ],
    		'export' => false,
    		'pjax' => true,
    		'responsive'=>true,
    		'hover'=>true,
    		'panel' => [
    				'type' => GridView::TYPE_DANGER,
    				
    		],
    		
    		'toolbar' =>  [
    				'{toggleData}',['content'=>
    						Html::a('Tambah', ['create'], ['data-pjax'=>0, 'class' => 'btn btn-success', 'title'=>'create pidsus'])
    				],
    				
    		],
    ]); ?>
    <?php
    	$delButton=Html::submitButton( 'Simpan', ['class' => 'btn btn-primary', 'name'=>'btnSubmit', 'value'=>'simpan','data' => ['confirm' => 'Apakah anda yakin ingin menghapus?']]) ;
		$js = <<< JS
        $('td').dblclick(function (e) {
        var id = $(this).closest('tr').data('id');
        var url = window.location.protocol + "//" + window.location.host + "/pidsus/$idJenisSurat/update?id="+id;
        $(location).attr('href',url);
    });


    $( "input" ).change(function(e) {
        $('.hapus').hide();
        var input = $( this );
        if(input.prop( "checked" ) == true){
            console.log(e.target.value);
            $('.hapus').show();
            $('#btnHapus').append(
                ""
            );
			$('#divHapus').append(
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
    <?php $form = ActiveForm::begin(
	 [
                'id' => 'p42-form',
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

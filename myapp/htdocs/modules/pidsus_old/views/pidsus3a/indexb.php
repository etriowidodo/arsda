<?php

use yii\helpers\Html;
use kartik\widgets\ActiveForm;
use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\PdsLidSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
$type=$idJenisSurat2=='pidsus3blit'?'Penelitian':'Penyelidikan';
$this->title = 'Pidsus 3B-Laporan Pengaduan Setelah Dilakukan '.$type ;
//$this->params['breadcrumbs'][] = ['label' => 'List Surat', 'url' => ['../pidsus/default/viewlaporan','id'=>$id]];
//$this->params['breadcrumbs'][] = $this->title;
require('..\modules\pidsus\controllers\viewFormFunction.php');
$viewFormFunction=new viewFormFunction();
$this->params['idtitle']=$_SESSION['noLapLid'];
?>
<div class="pds-lid-index">
	
    
	<h1><?= Html::encode('Pidsus 3B') ?></h1>
    <?= GridView::widget([
        'dataProvider' => $dataProvider3b,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

           
            'no_surat',
            ['attribute'=>'tgl_surat','header'=>'Tanggal Surat','format'=>['date','dd MMMM Y']],

             [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{update}{delete}',
             	//'buttons' => [
             		//		'update' => function ($url,$model) {
             			//		return Html::a(
             				//			'<span class="glyphicon glyphicon-pencil"></span>',
             					//		$url.'&type=p1');
             				//},
             				//],

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
    				['content'=>
    						Html::a('Tambah', ['create?idJenisSurat='.$idJenisSurat2], ['data-pjax'=>0, 'class' => 'btn btn-success', 'title'=>'create pidsus'])
    				],
    				'{toggleData}',
    		],
    ]); ?>
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
						        		
							        	<div class="col-md-8">
								        	<?php //$viewFormFunction->returnDropDownListStatus($form,$modelLid,$modelLid->id_status)?>
								          </div>
								         
							        	<div class="col-md-4">
							        		
								          	<?php //Html::submitButton('Submit', ['class' => 'btn btn-primary']) ?>
								        </div>
							        </div>
							        
    <?php ActiveForm::end(); ?>
</div>

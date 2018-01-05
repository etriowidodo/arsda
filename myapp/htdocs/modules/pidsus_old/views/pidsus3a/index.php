<?php

use yii\helpers\Html;
use kartik\widgets\ActiveForm;
use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\PdsLidSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = "";
//$this->params['breadcrumbs'][] = ['label' => 'Pidsus', 'url' => ['../pidsus/default/index']];
//$this->params['breadcrumbs'][] = $this->title;
require('..\modules\pidsus\controllers\viewFormFunction.php');
$viewFormFunction=new viewFormFunction();
$this->params['idtitle']=$_SESSION['noLapLid'];
?>
<div class="pds-lid-index">
	
    <h1><?= Html::encode('Pidsus3A') ?></h1>
    <?= GridView::widget([
        'dataProvider' => $dataProvider3a,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'no_surat',
            ['attribute'=>'tgl_surat','header'=>'Tanggal Surat','format'=>['date','dd-MM-yyyy']],

             [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{update}',
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
    					
    				
    		],
    ]); ?>
	<h1><?= Html::encode('Pidsus3B') ?></h1>
    <?= GridView::widget([
        'dataProvider' => $dataProvider3b,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

           
            'no_surat',
            ['attribute'=>'tgl_surat','header'=>'Tanggal Surat','format'=>['date','dd-MM-yyyy']],

             [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{update}',
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
    				'{toggleData}',['content'=>
    						Html::a('Tambah', ['create?id='.$id], ['data-pjax'=>0, 'class' => 'btn btn-success', 'title'=>'create pidsus'])
    				],
    				
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
								        	<?= $viewFormFunction->returnDropDownListStatus($form,$modelLid,$modelLid->id_status)?>
								          </div>
								         
							        	<div class="col-md-4">
							        		
								          	<?= Html::submitButton('Submit', ['class' => 'btn btn-primary']) ?>
								        </div>
							        </div>
							        
    <?php ActiveForm::end(); ?>
</div>

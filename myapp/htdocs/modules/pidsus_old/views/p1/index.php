<?php

use yii\helpers\Html;
use kartik\widgets\ActiveForm;
use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\PdsLidSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Pidsus';
$this->params['idtitle']=$_SESSION['noLapLid'];//$this->params['breadcrumbs'][] = $this->title;
?>
<div class="pds-lid-index">
	
    <h1><?= Html::encode($this->title) ?></h1>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'no_lap',
            'tgl_lap',
            'id_status',
            'no_surat_lap',     
            'update_by',

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
    				'{toggleData}',['content'=>
    						//Html::button('<i class="glyphicon glyphicon-plus"></i>', ['type'=>'button', 'title'=>'create p16', 'class'=>'btn btn-success']),
    						Html::a('Tambah', ['create'], ['data-pjax'=>0, 'class' => 'btn btn-success', 'title'=>'create p16'])
    				],
    				
    		],
    ]); ?>

</div>

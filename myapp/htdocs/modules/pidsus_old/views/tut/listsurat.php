<?php

use yii\helpers\Html;
use kartik\widgets\ActiveForm;
use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\PdsLidSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'View Report Lid';
//$this->params['breadcrumbs'][] = $this->title;
?>
<div class="pds-lid-index">
	
    <h1><?= Html::encode($this->title) ?></h1>
    <?=Html::a('View Report P1', ['viewreportlid?id='.$idPdsLid.'&jenisSurat=p1'], ['data-pjax'=>0, 'class' => 'btn btn-primary', 'title'=>'create pidsus']) ?>
    </br></br><?=Html::a('View Report Pidsus 1', ['viewreportlid?id='.$idPdsLid.'&jenisSurat=pidsus1'], ['data-pjax'=>0, 'class' => 'btn btn-primary', 'title'=>'create pidsus']) ?>
    </br>
    <h1><?= Html::encode($this->title.' Surat') ?></h1>
    
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'no_surat',
            'id_jenis_surat',	
            'tgl_surat',     
            'perihal_lap',

             [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{viewreport}',
             	'buttons' => [
             				'viewreport' => function ($url,$model) {
             					return Html::a(
             							'<span class="glyphicon glyphicon-eye-open"></span>',
             							$url);
             				},
             				],

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
    						//Html::button('<i class="glyphicon glyphicon-plus"></i>', ['type'=>'button', 'title'=>'create p16', 'class'=>'btn btn-success']),
    						Html::a('Tambah', ['create'], ['data-pjax'=>0, 'class' => 'btn btn-success', 'title'=>'create p16'])
    				],
    				'{toggleData}',
    		],
    ]); ?>

</div>

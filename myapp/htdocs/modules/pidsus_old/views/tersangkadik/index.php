<?php

use yii\helpers\Html;
use kartik\widgets\ActiveForm;
use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\pidsus\models\PdsDikTersangkaSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Daftar Tersangka';
$this->params['idtitle']=$_SESSION['noSpdpDik'];
?>
<div class="pds-dik-tersangka-index">

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Pds Dik Tersangka', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            //'id_pds_dik_tersangka',
            'id_pds_dik',
            'nama_tersangka',
            'tempat_lahir',
            'tgl_lahir',
        	'nomor_id',	
            // 'jenis_kelamin',
            // 'kewarganegaraan',
            // 'alamat',
            // 'agama',
            // 'pekerjaan',
            // 'pendidikan',
            // 'create_by',
            // 'create_date',
            // 'update_by',
            // 'update_date',
            // 'jenis_id',
            // 'nomor_id',
            // 'suku',
            // 'flag',

            ['class' => 'yii\grid\ActionColumn'],
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

</div>

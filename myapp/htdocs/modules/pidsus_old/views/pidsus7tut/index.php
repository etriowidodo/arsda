<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\Pidsus9Search */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Pidsus7-Nota Dinas';
//$this->params['breadcrumbs'][] = $this->title;
$this->params['idtitle']=$_SESSION['noLapLid'];
?>
<div class="pds-lid-surat-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Pds Lid Surat', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id_pds_lid_surat',
            'id_pds_lid',
            'id_jenis_surat',
            'no_surat',
            ['attribute'=>'tgl_surat','header'=>'Tanggal Surat','format'=>['date','dd-MM-yyyy']],
            // 'lokasi_surat',
            // 'sifat_surat',
            // 'lampiran_surat',
            // 'perihal_lap',
            // 'kepada',
            // 'kepada_lokasi',
            // 'id_ttd',
            // 'create_by',
            // 'create_date',
            // 'update_by',
            // 'update_date',
            // 'id_pds_lid_surat_parent',
            // 'id_status',
            // 'jam_surat',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>

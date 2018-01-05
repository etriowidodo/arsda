<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\Was3Search */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Was3s';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="was3-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Was3', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id_was_3',
            'no_was_3',
            'inst_satkerkd',
            'id_register',
            'tgl_was_3',
            // 'kpd_was_3',
            // 'ttd_was_3',
            // 'id_terlapor',
            // 'ttd_peg_nik',
            // 'ttd_peg_nip',
            // 'ttd_peg_nrp',
            // 'ttd_peg_gol',
            // 'ttd_peg_jabatan',
            // 'ttd_peg_inst_satker',
            // 'ttd_peg_unitkerja',
            // 'upload_file',
            // 'flag',
            // 'created_by',
            // 'created_ip',
            // 'created_time',
            // 'updated_ip',
            // 'updated_by',
            // 'updated_time',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>

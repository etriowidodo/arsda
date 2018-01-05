<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\pengawasan\models\Was15Search */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Was15s';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="was15-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Was15', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id_was_15',
            'no_was_15',
            'id_register',
            'inst_satkerkd',
            'tgl_was_15',
            // 'sifat_surat',
            // 'jml_lampiran',
            // 'satuan_lampiran',
            // 'rncn_jatuh_hukdis_1_was_15',
            // 'rncn_jatuh_hukdis_2_was_15',
            // 'rncn_jatuh_hukdis_3_was_15',
            // 'pendapat',
            // 'persetujuan',
            // 'ttd_was_15',
            // 'ttd_peg_nik',
            // 'ttd_id_jabatan',
            // 'upload_file',
            // 'is_deleted',
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

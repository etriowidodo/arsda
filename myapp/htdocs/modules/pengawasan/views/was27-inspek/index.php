<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\pengawasan\models\Was27InspekSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Was27 Inspeks';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="was27-inspek-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Was27 Inspek', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id_was_27_inspek',
            'id_register',
            'inst_satkerkd',
            'no_was_27_inspek',
            'tgl',
            // 'sifat_surat',
            // 'jml_lampiran',
            // 'satuan_lampiran',
            // 'data_data',
            // 'upload_file_data',
            // 'analisa',
            // 'kesimpulan',
            // 'rncn_henti_riksa_1_was_27_ins',
            // 'rncn_henti_riksa_2_was_27_ins',
            // 'pendapat_1_was_27_ins',
            // 'pendapat',
            // 'persetujuan',
            // 'ttd_was_27_inspek',
            // 'ttd_peg_nik',
            // 'ttd_id_jabatan',
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

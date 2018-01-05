<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\pengawasan\models\Was16aSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Was16as';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="was16a-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Was16a', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id_was_16a',
            'no_was_16a',
            'id_register',
            'inst_satkerkd',
            'kpd_was_16a',
            // 'id_terlapor',
            // 'tgl_was_16a',
            // 'sifat_surat',
            // 'jml_lampiran',
            // 'satuan_lampiran',
            // 'perihal',
            // 'ttd_was_16a',
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

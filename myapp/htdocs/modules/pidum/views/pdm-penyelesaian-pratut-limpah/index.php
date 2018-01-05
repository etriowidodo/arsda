<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\pidum\models\PdmPenyelesaianPratutLimpahSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Pdm Penyelesaian Pratut Limpahs';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="pdm-penyelesaian-pratut-limpah-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Pdm Penyelesaian Pratut Limpah', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id_pratut_limpah',
            'id_pratut',
            'no_surat',
            'sifat',
            'lampiran',
            // 'tgl_dikeluarkan',
            // 'dikeluarkan',
            // 'kepada',
            // 'di_kepada',
            // 'perihal',
            // 'id_penandatangan',
            // 'nama',
            // 'pangkat',
            // 'jabatan',
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

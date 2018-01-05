<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\pidum\models\PdmP34Search */
/* @var $dataProvider yii\data\ActiveDataProvider */


$this->title = 'P34';
$this->subtitle = 'Tanda Terima Barang Bukti';
?>
<div class="pdm-p34-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Pdm P34', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id_p34',
            'id_perkara',
            'tgl_surat',
            'jam',
            'id_tersangka',
            // 'dikeluarkan',
            // 'tgl_dikeluarkan',
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

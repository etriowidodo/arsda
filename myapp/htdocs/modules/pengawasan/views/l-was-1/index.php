<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\pengawasan\models\LWas1Search */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Lwas1s';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="lwas1-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Lwas1', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id_l_was_1',
            'no_register',
            'inst_satkerkd',
            // 'tgl',
            // 'data_data',
            // 'upload_file_data',
            // 'analisa',
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

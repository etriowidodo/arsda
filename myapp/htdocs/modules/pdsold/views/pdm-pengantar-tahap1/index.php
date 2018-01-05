<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\pidum\models\PdmPengantarTahap1Search */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Pdm Pengantar Tahap1s';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="pdm-pengantar-tahap1-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Pdm Pengantar Tahap1', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id_pengantar',
            'id_berkas',
            'no_pengantar',
            'tgl_pengantar',
            'tgl_terima',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>

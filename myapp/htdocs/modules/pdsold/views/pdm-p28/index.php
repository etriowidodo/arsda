<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\pidum\models\PdmP28Search */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'P28';
$this->subtitle = $this->title;
?>
<div class="pdm-p28-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Pdm P28', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id_p28',
            'id_perkara',
            'no_surat',
            // 'id_jaksa1',
            // 'id_jaksa2',
            // 'id_jaksa3',
            // 'hakim1',
            // 'hakim2',
            // 'hakim3',
            // 'panitera',
            // 'penasehat',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>

<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\pidum\models\PdmPenyelesaianPratutLimpahJaksaSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Pdm Penyelesaian Pratut Limpah Jaksas';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="pdm-penyelesaian-pratut-limpah-jaksa-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Pdm Penyelesaian Pratut Limpah Jaksa', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id_pratut_limpah_jaksa',
            'peg_nip',
            'nama',
            'pangkat',
            'jabatan',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>

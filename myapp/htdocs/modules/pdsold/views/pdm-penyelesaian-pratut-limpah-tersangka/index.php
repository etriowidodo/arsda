<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\pidum\models\PdmPenyelesaianPratutLimpahTersangkaSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Pdm Penyelesaian Pratut Limpah Tersangkas';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="pdm-penyelesaian-pratut-limpah-tersangka-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Pdm Penyelesaian Pratut Limpah Tersangka', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id_pratut_limpah_tersangka',
            'id_ms_tersangka_berkas',
            'status_penahanan',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>

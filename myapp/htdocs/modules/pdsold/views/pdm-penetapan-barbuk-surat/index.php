<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\pidum\models\PdmPenetapanBarbukSuratSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Pdm Penetapan Barbuk Surats';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="pdm-penetapan-barbuk-surat-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Pdm Penetapan Barbuk Surat', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id_penetapan_barbuk_surat',
            'id_penetapan_barbuk',
            'nama_surat',
            'no_surat',
            'tgl_surat',
            // 'tgl_diterima',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>

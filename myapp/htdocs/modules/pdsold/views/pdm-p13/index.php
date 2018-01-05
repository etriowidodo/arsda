<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\pidum\models\PdmP13Search */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Pdm P13s';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="pdm-p13-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Pdm P13', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

//            'id_p13',
            'id_ba5',
            'no_surat_p13',
            'sifat',
            'lampiran',
            // 'dikeluarkan',
            // 'tgl_surat',
            // 'kepada',
            // 'ket_saksi:ntext',
            // 'ket_ahli:ntext',
            // 'ket_surat:ntext',
            // 'petunjuk:ntext',
            // 'ket_tersangka:ntext',
            // 'hukum:ntext',
            // 'yuridis:ntext',
            // 'kesimpulan:ntext',
            // 'saran:ntext',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>

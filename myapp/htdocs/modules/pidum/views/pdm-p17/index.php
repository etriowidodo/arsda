<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\pidum\models\PdmP17Search */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Pdm P17s';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="pdm-p17-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Pdm P17', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id_p16',
            'id_p17',
            'no_surat',
            'sifat',
            'lampiran',
            // 'perihal',
            // 'tgl_surat',
            // 'dikeluarkan',
            // 'kepada',
            // 'di',
            // 'id_penandatangan',

            ['class' => 'yii\grid\ActionColumn',
              'buttons' => [
                    'update' => function ($url, $model) {
                        return Html::a('<span class="glyphicon glyphicon-pencil"></span>', 'update?id='.$model->id_perkara,
                            [ 'style' => 'color:#736cc4;','title' => Yii::t('app', 'New Action1'),]);
                    },
                ],  
            ],
        ],
    ]); ?>

</div>

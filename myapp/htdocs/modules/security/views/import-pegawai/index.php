<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Backup Configs';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="backup-config-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Backup', ['backup'], ['class' => 'btn btn-danger']) ?>
        <?= Html::a('Restore', ['restore'], ['class' => 'btn btn-danger']) ?>
    </p>
    <p>
        <div class="hasil"></div>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'host',
            'db',
            'port',
            [
                'attribute' => 'schema',
                'label' => 'Jenis',
                'format' => 'raw',
                'value' => function ($model, $key, $index, $widget) {
                    return ($key == 3) ? 'Backup':'Restore';
                },
            ],
            // 'username',
            // 'password',
            // 'target_file',
            // 'command_path',
            // 'command_args',
            // 'createdby',
            // 'createdtime',
            // 'updatedby',
            // 'updatedtime',

            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{update}',

            ],
        ],
    ]); ?>

</div>

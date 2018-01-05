<?php

use yii\helpers\Html;
use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $model app\models\DugaanPelanggaran */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="modalContent">

    <?php
    echo GridView::widget([
        'id' => 'gridKejaksaan',
        'dataProvider' => $dataJPU,
        'filterModel' => $searchJPU,
        'layout' => "{items}\n{pager}",
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            ['label' => 'NIP',
                'attribute' => 'peg_nik',
            ],
            ['label' => 'Nama',
                'attribute' => 'peg_nama',
            ],
            ['label' => 'Pangkat',
                'attribute' => 'pangkat',
            ],
            ['label' => 'Jabatan',
                'attribute' => 'jabatan',
            ],
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{select}',
                'buttons' => [
                    'select' => function ($url, $model) {
                        return Html::checkbox('pilih', false, ['value' => $model['peg_nip'] . '#' . $model['peg_nama'] . '#' . $model['pangkat'] . '#' . $model['jabatan']]);
                    },
                        ]
                    ],
                ],
                'export' => false,
                'pjax' => true,
                'responsive' => true,
                'hover' => true,
                'panel' => [
                    'type' => GridView::TYPE_PRIMARY,
                    'heading' => '<i class="glyphicon glyphicon-book"></i>',
                ],
                'pjaxSettings' => [
                    'options' => [
                        'enablePushState' => false,
                    ],
                    'neverTimeout' => true,
                //'afterGrid' => '<a id="pilih-jpu" class="btn btn-success">Pilih</a>',
                ],
            ]);
            echo '<a id="pilih-jpu" class="btn btn-success">Pilih</a>'
            ?>

</div>	


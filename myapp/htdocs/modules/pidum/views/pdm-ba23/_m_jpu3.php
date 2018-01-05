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
        'id' => 'gridKejaksaan3',
        'dataProvider' => $dataJPU,
        'filterModel' => $searchJPU,
        'layout' => "{items}\n{pager}",
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            ['label' => 'NIP',
                'attribute' => 'peg_nip_baru',
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
                        return Html::checkbox('pilih', false, ['value' => $model['peg_nip'] . '#' . $model['peg_nama'] . '#' . $model['pangkat'] . '#' . $model['jabatan'] . '#' . $model['peg_nip_baru']]);
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
            ?>
    <hr style="border-color: #c7c7c7;margin: 10px 0;">
    <div class="modal-footer">
        <a id="pilih-jpu" class="btn btn-warning">Pilih</a>
    </div>
</div>	

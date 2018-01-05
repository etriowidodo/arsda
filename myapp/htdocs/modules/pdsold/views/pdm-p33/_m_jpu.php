<script>
//    window.onload = function () {
//
//       
//
//    };


    function pilihJPU(nip, nama, pangkat) {

        $("#pdmjaksasaksi-nip").val(nip);
        $("#pdmjaksasaksi-nama").val(nama);
//        $("#pdmjaksasaksi-jabatan").val(jabatan);
        $("#pdmjaksasaksi-pangkat").val(pangkat);
        $('#m_jpu').modal('hide');
    }






</script>


<?php

use yii\helpers\Html;
use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $model app\models\DugaanPelanggaran */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="modalContent">

    <?=
    GridView::widget([
        'id' => 'gridKejaksaan',
        'dataProvider' => $dataJPU,
        'filterModel' => $searchJPU,
        'layout' => "{items}\n{pager}",
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            ['label' => 'NIP',
                'attribute' => 'peg_nip_baru',
            ],
            ['label' => 'Nama',
                'attribute' => 'nama',
            ],
            ['label' => 'Pangkat',
                'attribute' => 'gol_pangkat2',
            ],
            [
                'class' => '\kartik\grid\ActionColumn',
                'template' => '{pilih}',
                'buttons' => [
                    'pilih' => function ($url, $model, $key) {
                        return Html::button("Pilih", ["id" => "buttonPilihJPU", "class" => "btn btn-warning",
                                    "nip" => $model['peg_nip_baru'],
                                    "nama" => $model['nama'],
                                    "pangkat" => $model['gol_pangkat2'],
                                    "onClick" => "pilihJPU($(this).attr('nip'),$(this).attr('nama'),$(this).attr('pangkat'))"]);
                    }
                        ],
                    ]
                ],
                'export' => false,
                'pjax' => true,
                'responsive' => true,
                'hover' => true,
                'panel' => [
                    'type' => GridView::TYPE_PRIMARY,
                    'heading' => '<i class="glyphicon glyphicon-th-list"></i>',
                ],
                'pjaxSettings' => [
                    'options' => [
                        'enablePushState' => false,
                    ]
                ]
            ]);
            ?>

</div>	


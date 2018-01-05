<script>
//    window.onload = function () {
//
//       
//
//    };


    function pilihJPU(nip, nama, jabatan, pangkat) {
        $("#pdmba18-id_penandatangan").val(nip);
        $("#pdmba18-nama_ttd").val(nama);
        $("#pdmba18-jabatan_ttd").val(jabatan);
        $("#pdmba18-pangkat_ttd").val(pangkat);
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
                'attribute' => 'peg_nip',
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
                'class' => '\kartik\grid\ActionColumn',
                'template' => '{pilih}',
                'buttons' => [
                    'pilih' => function ($url, $model, $key) {
                        return Html::button("Pilih", ["id" => "buttonPilihJPU", "class" => "btn btn-warning",
                                    "nip" => $model['peg_nip'],
                                    "nama" => $model['peg_nama'],
                                    "jabatan" => $model['jabatan'],
                                    "pangkat" => $model['pangkat'],
                                    "onClick" => "pilihJPU($(this).attr('nip'),$(this).attr('nama'),$(this).attr('jabatan'),$(this).attr('pangkat'))"]);
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


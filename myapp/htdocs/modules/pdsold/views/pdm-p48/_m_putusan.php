<script>
//    window.onload = function () {
//
//       
//
//    };


    function pilihJPUsaksi(nip, nama, jabatan, pangkat) {
		
        $("#pdmba15-nip_jaksa").val(nip);
        $("#pdmba15-nama_jaksa").val(nama);
        $("#pdmba15-jabatan_jaksa").val(jabatan);
        $("#pdmba15-pangkat_jaksa").val(pangkat);
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
        'id' => 'm_putusan',
        'dataProvider' => $dataPutusan,
        'filterModel' => $searchPutusan,
        'layout' => "{items}\n{pager}",
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            ['label' => 'No Putusan',
                'attribute' => 'no_putusan',
            ],
            ['label' => 'Tgl Putusan',
                'attribute' => 'tgl_dikeluarkan',
            ],
            [
                'class' => '\kartik\grid\ActionColumn',
                'template' => '{pilih}',
                'buttons' => [
                    'pilih' => function ($url, $model, $key) {
                        return Html::button("Pilih", ["id" => "buttonPilihPutusan", "class" => "btn btn-warning",
                                    "nip" => $model['peg_nip'],
                                    "nama" => $model['peg_nama'],
                                    "jabatan" => $model['jabatan'],
                                    "pangkat" => $model['pangkat'],
                                    "onClick" => "pilihJPUsaksi($(this).attr('nip'),$(this).attr('nama'),$(this).attr('jabatan'),$(this).attr('pangkat'))"]);
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


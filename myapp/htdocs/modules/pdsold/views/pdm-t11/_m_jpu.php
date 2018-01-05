<script>
//    window.onload = function () {
//
//       
//
//    };


    function pilihJPU(no_register_perkara, no_surat_t11, peg_nip_baru, nama, gol_pangkat2) {
//        alert(val(no_register_perkara));
        $("#pdmjaksasaksi-no_register_perkara").val(no_register_perkara);
        $("#pdmjaksasaksi-no_surat_t11").val(no_surat_t11);
        $("#pdmjaksasaksi-peg_nip_baru").val(peg_nip_baru);
        $("#pdmjaksasaksi-nama").val(nama);
        $("#pdmjaksasaksi-gol_pangkat2").val(gol_pangkat2);
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
        'dataProvider'  => $dataJPU,
        'filterModel'   => $searchJPU,
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
                                    "no_register_perkara" => $model['no_register_perkara'],
                                    "no_surat_t11" => $model['no_surat_t11'],
                                    "peg_nip_baru" => $model['peg_nip_baru'],
                                    "nama" => $model['nama'],
                                    "gol_pangkat2" => $model['gol_pangkat2'],
                                    "onClick" => "pilihJPU($(this).attr('no_register_perkara'),$(this).attr('no_surat_t11'),$(this).attr('peg_nip_baru'),$(this).attr('nama'),$(this).attr('gol_pangkat2'))"]);
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


<script>
//    window.onload = function () {
//
//       
//
//    };


    function pilihJPU(no_register_perkara, no_surat_p16a, no_urut,nip, nama, jabatan, pangkat) {
//        alert(val(no_register_perkara));
        $("#pdmjaksasaksi-no_register_perkara").val(no_register_perkara);
        $("#pdmjaksasaksi-no_surat_p16a").val(no_surat_p16a);
        $("#pdmjaksasaksi-no_urut").val(no_urut);
        $("#pdmjaksasaksi-nip").val(nip);
        $("#pdmjaksasaksi-nama").val(nama);
        $("#pdmjaksasaksi-jabatan").val(jabatan);
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
                'attribute' => 'nip',
            ],
            ['label' => 'Nama',
                'attribute' => 'nama',
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
                                    "no_register_perkara" => $model['no_register_perkara'],
                                    "no_surat_p16a" => $model['no_surat_p16a'],
                                    "no_urut" => $model['no_urut'],
                                    "nip" => $model['nip'],
                                    "nama" => $model['nama'],
                                    "jabatan" => $model['jabatan'],
                                    "pangkat" => $model['pangkat'],
                                    "onClick" => "pilihJPU($(this).attr('no_register_perkara'),$(this).attr('no_surat_p16a'),$(this).attr('no_urut'),$(this).attr('nip'),$(this).attr('nama'),$(this).attr('jabatan'),$(this).attr('pangkat'))"]);
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


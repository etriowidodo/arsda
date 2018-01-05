<script>
//    window.onload = function () {
//
//       
//
//    };


    function pilihJPU(no_surat_p16a,nama,no_urut) {
        $("#pdmt7-no_surat_p16a").val(no_surat_p16a);
        $("#pdmt7-nama_jaksa").val(nama);
        $("#pdmt7-no_jaksa_p16a").val(no_urut);
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
        'dataProvider' => $dataProviderJPU,
        //'filterModel' => $searchJPU,
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
                                    "no_surat_p16a" => $model['no_surat_p16a'],
                                    "nama"          => $model['nama'],
                                    "no_urut"       => $model['no_urut'],
                                    "onClick" => "pilihJPU($(this).attr('no_surat_p16a'),$(this).attr('nama'),$(this).attr('no_urut'))"]);
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


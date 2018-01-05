<script>
//    window.onload = function () {
//
//       
//
//    };

//    function pilihJPU(nip, nama, jabatan, pangkat) {
//
//        var i = $('table#gridJPU tr:last').index() + 1;
//
//        $('#gridJPU').append(
//                "<tr id='trJPU" + i + "'>" +
//                "<td id='tdJPU" + i + "'><a class='btn btn-danger' id='btn_hapus'>(-)</a></td>" +
//                "<td id='tdJPU" + i + "'><input type='text' name='txtnip[]' id='txtnip' value='" + nip + "' style='width:100px;' readonly='true' class='form-control' readonly='true'></td>" +
//                "<td id='tdJPU" + i + "'><input type='text' name='txtnama[]' id='txtnama' value='" + nama + "' style='width:250px;' readonly='true' class='form-control' readonly='true'></td>" +
//                "<td id='tdJPU" + i + "'><input type='text' name='txtpangkat[]' id='txtpangkat' value='" + pangkat + "' style='width:50px;' readonly='true' class='form-control' readonly='true'></td>" +
//                "<td id='tdJPU" + i + "'><input type='text' name='txtjabatan[]' id='txtjabatan' value='" + jabatan + "' style='width:510px;' readonly='true' class='form-control' readonly='true'></td>" +
//                "</tr>"
//                );
//        i++;
//
//        $('#m_jpu').modal('hide');
//
//    }



</script>


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


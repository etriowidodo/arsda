<script>
    window.onload = function () {
        
    };
//    pilihTerdakwa($(this).attr('id'),$(this).attr('nama'),$(this).attr('alamat'),$(this).attr('agama'),$(this).attr('pendidikan'))

//    function pilihTerdakwa(id, nama, alamat, agama, pendidikan) {
//
//        var i = $('table#gridTerdakwa tr:last').index() + 1;
//        $('#gridTerdakwa').append(
//                "<tr id='trTerdakwa" + i + "'>" +
//                "<td id='tdTerdakwa" + i + "' style='display:none;'><input type='text' name='txtid[]' id='txtid" + i + "' value='" + id + "' style='width:100px;' readonly='true' class='form-control' readonly='true'></td>" +
//                "<td id='tdTerdakwa" + i + "'><input type='text' name='txtnama[]' id='txtnama" + i + "' value='" + nama + "' style='width:260px;' readonly='true' class='form-control' readonly='true'></td>" +
//                "<td id='tdTerdakwa" + i + "'><input type='text' name='txtalamat[]' id='txtalamat" + i + "' value='" + alamat + "' style='width:410px;' readonly='true' class='form-control' readonly='true'></td>" +
//                "<td id='tdTerdakwa" + i + "'><input type='text' name='txtagama[]' id='txtagama" + i + "' value='" + agama + "' style='width:150px;' readonly='true' class='form-control' readonly='true'></td>" +
//                "<td id='tdTerdakwa" + i + "'><input type='text' name='txtpendidikan[]' id='txtpendidikan" + i + "' value='" + pendidikan + "' style='width:100px;' readonly='true' class='form-control' readonly='true'></td>" +
//                "<td id='tdTerdakwa" + i + "'><a class='btn btn-danger' id='btn_hapus'>Hapus</a></td>" +
//                "</tr>"
//                );
//        i++;
//        $('#m_terdakwa').modal('hide');
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
        'id' => 'gridTerdakwa',
        'dataProvider' => $dataTerdakwa,
        'filterModel' => $searchTerdakwa,
        'layout' => "{items}\n{pager}",
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            ['label' => 'Nama',
                'attribute' => 'nama',
            ],
            ['label' => 'Alamat',
                'attribute' => 'alamat',
            ],
            ['label' => 'Agama',
                'attribute' => 'agama',
            ],
            ['label' => 'Pendidikan',
                'attribute' => 'pendidikan',
            ],
            [
                'class' => '\kartik\grid\ActionColumn',
                'template' => '{pilih}',
                'buttons' => [
                    'pilih' => function ($url, $model) {
                        return Html::checkbox('pilih', false, ['value' => $model['id'] . '#' . $model['nama'] . '#' . $model['alamat'] . '#' . $model['agama'] . '#' . $model['pendidikan'], 'class' => 'check_terdakwa']);
                    },
                        ]
                    ]
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
                //'afterGrid'=>'<a id="pilih-terlapor" class="btn btn-success">Pilih</a>',
                ]
            ]);
            echo '<a id="pilih_terdakwa" class="btn btn-success">Pilih</a>'
            ?>

</div>	


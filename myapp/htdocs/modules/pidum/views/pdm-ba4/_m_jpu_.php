<script>



    function pilihJPU(nip, nama, jabatan, pangkat) {

        $("#pdmjaksapenerima-nip").val(nip);
        $("#pdmjaksapenerima-nama").val(nama);
        $("#pdmjaksapenerima-jabatan").val(jabatan);
        $("#pdmjaksapenerima-pangkat").val(pangkat);
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
            ['label' => 'Jabatan',
                'attribute' => 'jabatan',
            ],
            /*
              [
              'class' => 'yii\grid\ActionColumn',
              'template' => '{select}',
              'buttons' => [
              'select' => function ($url, $model) {
              return Html::checkbox('pilih', false, ['value' => $model['peg_nip'].'#'.$model['peg_nama'].'#'.$model['peg_tmplahirkab'].'#'.$model['peg_tgllahir']]);
              },
              ]
              ],
             */
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
                    'heading' => '<i class="glyphicon glyphicon-book"></i>',
                ],
                    /*
                      'pjaxSettings'=>[
                      'options'=>[
                      'enablePushState'=>false,
                      ],
                      'neverTimeout'=>true,
                      'afterGrid'=>'<a id="pilih-terlapor" class="btn btn-success">Pilih</a>',
                      ]
                     */
            ]);
            ?>

</div>	
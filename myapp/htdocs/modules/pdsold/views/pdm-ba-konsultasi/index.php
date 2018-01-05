<?php

use yii\helpers\Html;
use kartik\grid\GridView;
/* @var $this yii\web\View */
/* @var $searchModel app\modules\pidum\models\PdmBaKonsultasiSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Berita Acara Konsultasi';
//$this->params['breadcrumbs'][] = $this->title;
?>
<div class="pdm-ba-konsultasi-index">
 <div id="divTambah" class="col-md-10">
        <?= Html::a('Tambah', ['create'], ['class' => 'btn btn-success']) ?>
 </div>
  <div  class="col-md-1" style="width:6%;">
        <button id="idUbah" class='btn btn-success btnUbahCheckboxIndex posisiedit'>Ubah</button>
    </div>
<?php
       $form = \kartik\widgets\ActiveForm::begin([
            'id' => 'hapus-index',
            'action' => '/pdsold/pdm-ba-konsultasi/delete/'
        ]);
    ?>
    <div id="divHapus" class="col-md-1">
        <button type="button" id="apus" class='btn btn-warning btnHapusCheckboxIndexi'>Hapus</button>
    </div>
    <?php \kartik\widgets\ActiveForm::end() ?>
    <div class="clearfix"><br><br></div>

    <?= GridView::widget([
       'dataProvider' => $dataProvider,
       'rowOptions'   => function ($model, $key, $index, $grid) {

            return ['data-id' => $model['id_ba_konsultasi'], 'data-perkara'=>$model['id_perkara'] ];
        },
        'columns' => [
           [
                'attribute'=>'tgl_pelaksanaan',
                'label' => 'Tanggal Pelaksanaan',
                'format' => 'raw',
                'value'=>function ($model, $key, $index, $widget) {

                return (date('d-m-Y',strtotime($model[tgl_pelaksanaan])));


                },

            ],
            [
                'attribute'=>'nama_jaksa',
                'label' => 'Jaksa Penuntut Umum',
                'format' => 'raw',
                'value'=>function ($model, $key, $index, $widget) {

                return ($model[nama_jaksa]);

                },

            ],
            [
                'attribute'=>'nama_penyidik',
                'label' => 'Penyidik',
                'format' => 'raw',
                'value'=>function ($model, $key, $index, $widget) {

                return ($model[nama_penyidik]);

                },

            ],
            [
                'class'=>'kartik\grid\CheckboxColumn',
                    'headerOptions'=>['class'=>'kartik-sheet-style'],
                    'checkboxOptions' => function ($model, $key, $index, $column) {
                        // var_dump($model);exit;
                        return ['value' => $model[id_ba_konsultasi], 'class' => 'checkHapusIndex'];
                    }
            ],
        ],
             'export' => false,
        'pjax' => true,
        'responsive'=>true,
        'hover'=>true,

    ]); ?>
</div>
<?php
        $js = <<< JS

        $('td').dblclick(function (e) {
        var id_perkara = $(this).closest('tr').attr('data-perkara');
        var id_ba_konsultasi = $(this).closest('tr').data('id');
        if (id_perkara ==undefined)
        {
        bootbox.dialog({
                message: "Maaf tidak terdapat data untuk diubah",
                buttons:{
                    ya : {
                        label: "OK",
                        className: "btn-warning",

                    }
                }
            });
        }
        else
        {
        var url = window.location.protocol + "//" + window.location.host + "/pdsold/pdm-ba-konsultasi/update?id_ba_konsultasi="+id_ba_konsultasi+"&id_perkara="+id_perkara;
        $(location).attr('href',url);
        }
        });

        $("#apus").on("click",function(){
        $('form').submit();
           });


JS;

        $this->registerJs($js);
        ?>
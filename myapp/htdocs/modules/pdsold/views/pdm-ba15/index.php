<?php

use kartik\grid\GridView;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\pidum\models\PdmBa6Search */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = $sysMenu->kd_berkas;
$this->subtitle = $sysMenu->keterangan;
?>
<div class="pdm-ba6-index">
    <?php
    $form = \kartik\widgets\ActiveForm::begin([
        'id' => 'hapus-index',
        'action' => '/pdsold/pdm-ba15/delete'
    ]);
    ?>
    <div id="divHapus">
        <?= Html::a('Tambah', ['create'], ['class' => 'btn btn-warning']) ?>
        <div class="pull-right">
            <a type="button" id="draft" class='btn btn-warning pull-right'>Cetak Draft</a>&nbsp;
            <a type="button" id="cetak" class='btn btn-primary btnPrintCheckboxIndex  pull-right' disabled>Cetak</a>&nbsp;
            <a class='btn btn-danger delete hapusTembusan btnHapusCheckboxIndex'></a>
        </div>

    </div>
    <div id="btnHapus"></div><div id="btnUpdate"></div>
    <?php \kartik\widgets\ActiveForm::end() ?>
    <div class="row">
        <div class="col-md-12">
            <?=
            GridView::widget([
                'id' => 'spdp',
                'rowOptions' => function ($model, $key, $index, $grid) {
                    return ['data-id' => $model['tgl_ba15']];
                },
                'dataProvider' => $dataProvider,
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],
                    'no_penetapan',
                    [
                        'attribute'=>'tgl_penetapan',
                        'label' => 'Tanggal Berita Acara',
                        'format' => 'raw',
                        'value'=>function ($model, $key, $index, $widget) {
                            return Yii::$app->globalfunc->ViewIndonesianFormat($model->tgl_penetapan);
                        },


                    ],
                    [
                        'attribute'=>'no_reg_tahanan',
                        'label' => 'Terdakwa',
                        'format' => 'raw',
                        'value'=>function ($model, $key, $index, $widget) {
                            return Yii::$app->globalfunc->GetNamaTahananT2($model->no_register_perkara,$model->no_reg_tahanan);
                        },


                    ],
                    [
                        'class' => 'kartik\grid\CheckboxColumn',
                        'headerOptions' => ['class' => 'kartik-sheet-style'],
                        'checkboxOptions' => function ($model, $key, $index, $column) {
                            return ['value' => $model->tgl_ba15, 'class' => 'checkHapusIndex'];
                        }
                    ],
                ],
                'export' => false,
                'pjax' => true,
                'responsive' => true,
                'hover' => true,
            ]);
            ?>

        </div>
    </div>
</div>
<?php
$js = <<< JS
    $('td').dblclick(function (e) {
        var id = $(this).closest('tr').data('id');
        var url = window.location.protocol + "//" + window.location.host + "/pdsold/pdm-ba15/update?id="+id;
        $(location).attr('href',url);
    });

    $("#draft").on("click", function(){
            var url    = '/pdsold/pdm-ba15/cetak-draft';
            window.open(url, '_blank');
            window.focus();
    });
    
    

    $('.btnPrintCheckboxIndex').click(function(){
          var count =$('.checkHapusIndex:checked').length;
          if (count != 1 ){
              bootbox.dialog({
                  message: "Silahkan pilih hanya 1 data untuk Dicetak",
                  buttons:{
                      ya : {
                          label: "OK",
                          className: "btn-warning",

                      }
                  }
              });
          } else {
              var id = $('.checkHapusIndex:checked').val();
              console.log(id);
              var has = id.split('#');
              var url    = '/pdsold/pdm-ba15/cetak?id='+id;
              window.open(url, '_blank');
              window.focus();
          }
      }); 


JS;

$this->registerJs($js);
?>
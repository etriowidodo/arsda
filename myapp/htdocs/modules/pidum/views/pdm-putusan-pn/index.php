<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\bootstrap\Modal;
/* @var $this yii\web\View */
/* @var $searchModel app\modules\pidum\models\PdmP41Search */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Putusan Pengadilan';
//$this->subtitle = $sysMenu->keterangan;
?>
<div class="pdm-putusan-pn-index">

    <div id="divTambah" class="col-md-11">
        <!-- <?= Html::a('Tambah', ['create'], ['class' => 'btn btn-warning tambahkan']) ?> -->
        <!-- <a class="btn btn-warning tambahkan" href="#">Tambah</a> -->
        <button type="button" class="btn btn-warning tambahkan" data-toggle="modal" data-target="#modalPilihan">Tambah</button> 
    </div>

    <?php
    $form = \kartik\widgets\ActiveForm::begin([
                'id' => 'hapus-index',
                'action' => '/pidum/pdm-putusan-pn/delete'
    ]);
    ?>
    <div id="divHapus" class="col-md-1">
        <button class='btn btn-warning btnHapusCheckboxIndex'>Hapus</button>
    </div>
    <?php \kartik\widgets\ActiveForm::end() ?>

    <div class="clearfix"><br><br></div>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'rowOptions' => function ($model, $key, $index, $grid) {
            return ['data-id' => $model['no_surat']];
        },
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            [
                'attribute'=>'no_surat',
                'label' => 'Nomor Surat',
                'format' => 'raw',
                'value'=>function ($model, $key, $index, $widget) {
                    return $model->no_surat;
                },


            ],

            [
                'attribute'=>'sifat',
                'label' => 'Sifat',
                'format' => 'raw',
                'value'=>function ($model, $key, $index, $widget) {
                    return $model->sifat;
                },


            ],

            [
                'attribute'=>'tgl_dikeluarkan',
                'label' => 'Tanggal Dikeluarkan',
                'format' => 'raw',
                'value'=>function ($model, $key, $index, $widget) {
                    return date("d-m-Y", strtotime($model->tgl_dikeluarkan));
                },


            ],
            
            [
                'attribute'=>'status_yakum',
                'label' => 'Tahap',
                'format' => 'raw',
                'value'=>function ($model, $key, $index, $widget) {
                    switch ($model->status_yakum) {
                        case 1:
                            $hasil = 'Banding';
                            break;
                        case 2:
                            $hasil = 'Kasasi';
                            break;

                        default:
                            $hasil = 'Penuntutan';
                            break;
                    }
                    return $hasil;
                },
            ],

            [
                'class' => 'kartik\grid\CheckboxColumn',
                'headerOptions' => ['class' => 'kartik-sheet-style'],
                'checkboxOptions' => function ($model, $key, $index, $column) {
                    return ['value' => $model->no_surat, 'class' => 'checkHapusIndex'];
                }
            ],
        ],
        'export' => false,
        'pjax' => true,
        'responsive' => true,
        'hover' => true,
    ]); ?>

</div>

<div id="modalPilihan" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Pilih Jenis Putusan Pengadilan
        <button type="button" class="btn-warning pull-right" data-dismiss="modal">Batal</button></h4>
      </div>
      <div class="modal-body">
        <div class="col-md-12">
            <div class="form-group">
                <div class="col-md-4"></div>
                <div class="col-md-4">
                    <select class="form-control selectJenis">
                        <option value="1">Putusan Pentuntutan</option>
                        <option value="2">Putusan Banding/Kasasi</option>
                    </select>
                </div>
            </div>
            <div id="banding">
                <div class="form-group">
                    <div class="col-md-12">
                            <label class="control-label col-md-4">Pilih No Permohonan</label>
                            <div class="col-md-4">
                                 <input type="text" name="inputNoPermohonan" id="inputNoPermohonan"/>
                                 <input type="hidden" name="inputNoAkta" id="inputNoAkta"/>
                            </div>
                            <div class="col-md-4">
                                <a data-toggle="modal" data-target="#_akta" class="btn btn-primary cari_akta">Pilih No Permohonan</a>
                            </div>
                    </div>
                </div>
            </div>
        </div> 
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" id="selesai" data-dismiss="modal">Selesai</button>
      </div>
    </div>

  </div>
</div>





<?php
Modal::begin([
    'id' => '_akta',
    'header' => 'Data Akta',
    'options' => [
        'data-url' => '',
    ],
]);
/*echo '<pre>';print_r($dataProvidert);exit;*/
?> 



<div class="modalContent">

<?php echo GridView::widget([
        'dataProvider' => $dataProviderAkta,
        'filterModel' => $searchModelAkta,
        'rowOptions'   => function ($model, $key, $index, $grid) {
            return ['data-id' => $model['no_akta'], ];
        },
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            [
                'attribute' => 'no_akta',
                'label' => 'Nomor dan Tanggal Permohonan',
                'format' => 'raw',
                'value' => function ($model, $key, $index, $widget) {
                    //return $model['nomor'].'<br>  Tanggal '.$model['tgl'];
                    return $model['no_permohonan'].'<br>  Tanggal '.date("d-m-Y",strtotime($model['tgl_permohonan']));
                },
            ],

            [
                'class' => '\kartik\grid\ActionColumn',
                'template' => '{pilih}',
                'buttons' => [
                    'pilih' => function ($url, $model, $key) {
                        return Html::button("Pilih", ["id" => $model['no_akta'], 'data-nomor'=>$model['no_permohonan'], "class" => "btn btn-warning",
                                    "onClick" => "pilihAkta($(this).attr('id'),$(this).attr('data-nomor'))"]);
                    }
                        ],
            ],
        ],
        'export' => false,
        'pjax' => true,
        'responsive'=>true,
        'hover'=>true,
        'panel' => [
                    'type' => GridView::TYPE_PRIMARY,
                    'heading' => '<i class="glyphicon glyphicon-th-list"></i>',
                ],
        'pjaxSettings' => [
            'options' => [
                'enablePushState' => false,
            ]
        ]
    ]); ?>
    
</div>

<?php
Modal::end();
?>

<?php
    $js = <<< JS
        $('#inputNoAkta').val('');
        $("#banding").hide();
        $('td').dblclick(function (e) {
        var id_p41 = $(this).closest('tr').data('id');
        var url = window.location.protocol + "//" + window.location.host + "/pidum/pdm-putusan-pn/update?id_p41="+id_p41;
        $(location).attr('href',url);
    });
      $('.selectJenis').on("change", function(){
        var kode = $(this).val();
        if(kode!='1'){
            $("#banding").show();
        }else{
            $("#banding").hide();
        }
      });

      $('#selesai').on("click", function(){
            var kode = $('.selectJenis').val();
            var no_akta = $('#inputNoAkta').val();
             if(kode!='1' && no_akta==''){
                alert('Pilih No Permohonan Terlebih Dahulu!!');
                return false;
             }
             //alert('gg');
            var url = window.location.protocol + "//" + window.location.host + "/pidum/pdm-putusan-pn/create?no_akta="+no_akta;
            $(location).attr('href',url);
        });
      
JS;

    $this->registerJs($js);
?>
<script>
    function pilihAkta(no_akta,no_permohonan){
        $('#inputNoPermohonan').val(no_permohonan);
        $('#inputNoAkta').val(no_akta);
        console.log(no_akta);
        $('#_akta').hide();
    }
</script>
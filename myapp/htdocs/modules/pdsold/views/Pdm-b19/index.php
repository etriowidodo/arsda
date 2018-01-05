<?php

use app\modules\pdsold\models\PdmB19Search;
use kartik\grid\GridView;
use kartik\widgets\ActiveForm;
use yii\data\ActiveDataProvider;
use yii\helpers\Html;
use yii\web\View;

/* @var $this View */
/* @var $searchModel PdmB19Search */
/* @var $dataProvider ActiveDataProvider */

$this->title = $sysMenu->kd_berkas;
$this->subtitle = 'Permohonan Izin Pelelangan Barang Bukti yang Tidak Diambil';
?>
<div class="pdm-b19-index">
    
    <div id="divTambah" class="col-md-11">
        <?= Html::a('Tambah', ['create'], ['class' => 'btn btn-warning']) ?>
    </div>

    <?php
    $form = \kartik\widgets\ActiveForm::begin([
            'id' => 'hapus-index',
            'action' => '/pdsold/pdm-b19/delete'
    ]);
    ?>
    <div id="divHapus" class="col-md-1">
        <button class='btn btn-warning btnHapusCheckboxIndex'>Hapus</button>
    </div>
    <?php \kartik\widgets\ActiveForm::end() ?>
    <div class="clearfix"><br><br></div>
    

    <?=
    GridView::widget([
        'dataProvider' => $dataProvider,
        //'filterModel' => $searchModel,
        'rowOptions' => function ($model, $key, $index, $grid) {
            return ['data-id' => rawurlencode($model['no_surat_b19'])];
        },
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],
                    
                    [
                        'attribute'=>'no_surat_b19',
                        'label' => 'No. Surat B-19',
                        'format' => 'raw',
                        'value'=>function ($model, $key, $index, $widget) {
                            return $model->no_surat_b19;
                        },
                    ],
                                
                    [
                        'attribute'=>'dikembalikan',
                        'label' => 'Dikembalikan',
                        'format' => 'raw',
                        'value'=>function ($model, $key, $index, $widget) {
                            return $model->dikembalikan;
                        },
                    ],
                    //'id_b19',
                    //'id_perkara',
//                    'no_surat',
//                    'lampiran',
                    // 'kepada',
                    // 'di_kepada',
//                     'dikeluarkan',
//                     'tgl_dikeluarkan',
                    // 'id_msstatusdata',
                    // 'barbuk:ntext',
                    // 'no_put_pengadilan',
                    // 'tgl_put_pengadilan',
                    // 'dikembalikan',
                    // 'harga',
                    // 'id_penandatangan',
                    // 'flag',
                    // 'created_by',
                    // 'created_ip',
                    // 'created_time',
                    // 'updated_ip',
                    // 'updated_by',
                    // 'updated_time',
                    [
                        'class' => 'kartik\grid\CheckboxColumn',
                        'headerOptions' => ['class' => 'kartik-sheet-style'],
                        'checkboxOptions' => function ($model, $key, $index, $column) {
                    return ['value' => rawurlencode($model['no_surat_b19']), 'class' => 'checkHapusIndex'];
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

<?php
$js = <<< JS
        $('td').dblclick(function (e) {
        var idb1 = $(this).closest('tr').data('id');
        var url = window.location.protocol + "//" + window.location.host + "/pdsold/pdm-b19/update?id="+idb1;
        $(location).attr('href',url);
    });


JS;

$this->registerJs($js);
?>
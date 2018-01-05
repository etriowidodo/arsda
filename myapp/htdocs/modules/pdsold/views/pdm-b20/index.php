<?php

use app\modules\pdsold\models\PdmB20Search;
use kartik\grid\GridView;
use kartik\widgets\ActiveForm;
use yii\data\ActiveDataProvider;
use yii\helpers\Html;
use yii\web\View;

/* @var $this View */
/* @var $searchModel PdmB20Search */
/* @var $dataProvider ActiveDataProvider */

$this->title = $sysMenu->kd_berkas;
$this->subtitle = $sysMenu->keterangan;
?>
<div class="pdm-b20-index">


    <div id="divTambah" class="col-md-11">
        <?= Html::a('Tambah', ['create'], ['class' => 'btn btn-warning']) ?>
    </div>
    <?php
    $form = ActiveForm::begin([
                'id' => 'hapus-index',
                'action' => '/pdsold/pdm-b20/delete'
    ]);
    ?>  

    <div id="divHapus" class="col-md-1">
        <button class='btn btn-warning hapus' type='submit'>Hapus</button>
    </div>
    <?php ActiveForm::end() ?>
    <div class="clearfix"><br><br></div>

    <?=
    GridView::widget([
        'dataProvider' => $dataProvider,
        //'filterModel' => $searchModel,
        'rowOptions' => function ($model, $key, $index, $grid) {
            return ['data-id' => $model['id_b20']];
        },
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],
                    //'id_b20',
                    //'id_perkara',
                    'no_surat',
                    //'sifat',
                    //'lampiran',
                     'kepada',
                    // 'di_kepada',
                     'dikeluarkan',
                     'tgl_dikeluarkan',
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
                    return ['value' => $model->id_b20, 'class' => 'checkHapusIndex'];
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
        var url = window.location.protocol + "//" + window.location.host + "/pdsold/pdm-b20/update2?id="+idb1;
        $(location).attr('href',url);
    });


JS;

        $this->registerJs($js);
        ?>
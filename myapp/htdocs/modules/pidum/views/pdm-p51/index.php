<?php

use app\modules\pidum\models\PdmP51Search;
use kartik\grid\GridView;
use kartik\widgets\ActiveForm;
use yii\data\ActiveDataProvider;
use yii\helpers\Html;
use yii\web\View;

/* @var $this View */
/* @var $searchModel PdmP51Search */
/* @var $dataProvider ActiveDataProvider */

$this->title = $sysMenu->kd_berkas;
$this->subtitle = $sysMenu->keterangan;
?>
<div class="pdm-p51-index">

    <div id="divTambah" class="col-md-11">
        <?= Html::a('Tambah', ['create'], ['class' => 'btn btn-warning']) ?>
    </div>
    <?php
    $form = ActiveForm::begin([
                'id' => 'hapus-index',
                'action' => '/pidum/pdm-p51/delete'
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
            return ['data-id' => $model['id_p51']];
        },
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],
                    //'id_p51',
                    //'id_perkara',
                    'dikeluarkan',
                    'tgl_dikeluarkan',
                    //'id_tersangka',
                    // 'stat_kawin',
                    'ortu',
                    'tgl_jth_pidana',
                    'tgl_hkm_tetap',
                    // 'denda',
                    // 'pokok',
                    // 'tambahan',
                    // 'percobaan',
                    // 'tgl_awal_coba',
                    // 'tgl_akhir_coba',
                    // 'syarat',
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
                    return ['value' => $model->id_p51, 'class' => 'checkHapusIndex'];
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
        var url = window.location.protocol + "//" + window.location.host + "/pidum/pdm-p51/update?id="+idb1;
        $(location).attr('href',url);
    });


JS;

        $this->registerJs($js);
        ?>
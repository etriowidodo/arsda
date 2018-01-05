<?php

use app\modules\pidum\models\PdmD4Search;
use kartik\grid\GridView;
use yii\data\ActiveDataProvider;
use yii\helpers\Html;
use yii\web\View;
use yii\widgets\ActiveForm;

/* @var $this View */
/* @var $searchModel PdmD4Search */
/* @var $dataProvider ActiveDataProvider */

$this->title = $sysMenu->kd_berkas;
$this->subtitle = $sysMenu->keterangan;
?>
<div class="pdm-d4-index">

    <div id="divTambah" class="col-md-11">
        <?= Html::a('Tambah', ['create'], ['class' => 'btn btn-warning']) ?>
    </div>
    <?php
    $form = ActiveForm::begin([
                'id' => 'hapus-index',
                'action' => '/pidum/pdm-d4/delete'
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
            return ['data-id' => $model['no_surat']];
        },
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],
                    //'id_d4',
                    //'id_perkara',
                    'no_surat',
                    'dikeluarkan',
                    'tgl_dikeluarkan',
                    // 'is_keputusan',
                    // 'no_surat',
                    // 'tgl_putus',
                    // 'pidana',
                    // 'is_perintah',
                    // 'biaya_perkara',
                    // 'bayar_kepada',
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
                    return ['value' => $model->no_surat, 'class' => 'checkHapusIndex'];
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
        var url = window.location.protocol + "//" + window.location.host + "/pidum/pdm-d4/update?no_surat="+idb1;
        $(location).attr('href',url);
    });


JS;

        $this->registerJs($js);
        ?>
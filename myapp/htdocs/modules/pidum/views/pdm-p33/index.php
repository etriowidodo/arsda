<?php

use yii\helpers\Html;
use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\pidum\models\pdmP11Search */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = $sysMenu->kd_berkas;
$this->subtitle = $sysMenu->keterangan;
?>
<div class="pdm-p33-index">
    <div id="divTambah" class="col-md-11">
        <?= Html::a('Tambah', ['create'], ['class' => 'btn btn-warning']) ?>
    </div>

    <?php
    $form = \kartik\widgets\ActiveForm::begin([
                'id' => 'hapus-index',
                'action' => '/pidum/pdm-p33/delete'
    ]);
    ?>
    <div id="divHapus" class="col-md-1">
        <button class='btn btn-warning btnHapusCheckboxIndex'>Hapus</button>
    </div>
    <?php \kartik\widgets\ActiveForm::end() ?>

    <div class="clearfix"><br><br></div>
    
    <div class="row">
        <div class="col-md-12">
            <?=
            GridView::widget([
                'id' => 'spdp',
                'rowOptions' => function ($model, $key, $index, $grid) {
                    return ['data-id' => $model->no_register_perkara."#".$model->tgl_p33];
                },
                'dataProvider' => $dataProvider,
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],
                    [
                        'attribute'=>'no_register_perkara'." ".'tgl_p33'." ".'jam',
                        'label' => 'No Register Perkara, Tgl P-33 dan Jam',
                        'format' => 'raw',
                        'value'=>function ($model, $key, $index, $widget) {
                            return $model->no_register_perkara." dan ".$model->tgl_p33." ".$model->jam;
                        },
                    ],
                    [
                        'attribute'=>'nama',
                        'label' => 'Nama Penerima',
                        'format' => 'raw',
                        'value'=>function ($model, $key, $index, $widget) {
                            return $model->nama;
                        },
                    ],
                    [
                        'attribute'=>'alamat',
                        'label' => 'Alamat',
                        'format' => 'raw',
                        'value'=>function ($model, $key, $index, $widget) {
                            return $model->alamat;
                        },
                    ],
                    [
                        'attribute'=>'pekerjaan',
                        'label' => 'Pekerjaan',
                        'format' => 'raw',
                        'value'=>function ($model, $key, $index, $widget) {
                            return $model->pekerjaan;
                        },
                    ],
                    [
                        'class' => 'kartik\grid\CheckboxColumn',
                        'headerOptions' => ['class' => 'kartik-sheet-style'],
                        'checkboxOptions' => function ($model, $key, $index, $column) {
                            return ['value' => $model->no_register_perkara."#".$model->tgl_p33, 'class' => 'checkHapusIndex'];
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
    var id  = $(this).closest('tr').data('id');
    var tm  = id.toString().split("#");
    var url = window.location.protocol + "//" + window.location.host + "/pidum/pdm-p33/update?id="+tm[0]+"&id2="+tm[1];
    $(location).attr('href',url);
});


JS;

$this->registerJs($js);
?>



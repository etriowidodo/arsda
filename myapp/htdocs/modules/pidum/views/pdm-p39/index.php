<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use app\models\MsSifatSurat;
use app\modules\pidum\models\PdmMsStatusData;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\pidum\models\PdmP39Search */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = $sysMenu->kd_berkas;
$this->subtitle = $sysMenu->keterangan;
?>
<div class="pdm-p39-index">
    <div id="divTambah" class="col-md-11">
        <?= Html::a('Tambah', ['create'], ['class' => 'btn btn-warning']) ?>
    </div>

    <?php
    $form = \kartik\widgets\ActiveForm::begin([
        'id' => 'hapus-index',
        'action' => '/pidum/pdm-p39/delete'
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
                    return ['data-id' => $model->no_surat_p39];
                },
                'dataProvider' => $dataProvider,
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],
                    [
                      'attribute' => 'no_surat_p39',
                      'label' => 'Nomor & Tanggal Surat',
                      'format' => 'raw',
                      'value' => function ($model, $key, $index, $widget) {
                            return $model->no_surat_p39 . '<br>' . Yii::$app->globalfunc->ViewIndonesianFormat($model->tgl_dikeluarkan);
                        },
                    ],
                    [
                      'attribute' => 'sifat',
                      'label' => 'Sifat',
                      'format' => 'raw',
                      'value' => function ($model, $key, $index, $widget) {
                            $sifat  = MsSifatSurat::findOne(['id'=>$model->sifat]);
                            return $sifat->nama;
                        },
                    ],
                    [
                      'attribute' => 'acara_sidang_ke',
                      'label' => 'Agenda Persidangan',
                      'format' => 'raw',
                      'value' => function ($model, $key, $index, $widget) {
                            $sifat  = \app\modules\pidum\models\PdmAgendaPersidangan::findOne(['no_agenda'=>$model->no_agenda, 'no_register_perkara'=>$model->no_register_perkara]);
                            return $sifat->acara_sidang_ke;
                        },
                    ],
                    [
                        'class' => 'kartik\grid\CheckboxColumn',
                        'headerOptions' => ['class' => 'kartik-sheet-style'],
                        'checkboxOptions' => function ($model, $key, $index, $column) {
                                return ['value' => $model->no_surat_p39, 'class' => 'checkHapusIndex'];
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
    var no_surat_p39 = $(this).closest('tr').data('id');
    var url = window.location.protocol + "//" + window.location.host + "/pidum/pdm-p39/update?no_surat_p39="+no_surat_p39;
    $(location).attr('href',url);
});


JS;

$this->registerJs($js);
?>

</div>

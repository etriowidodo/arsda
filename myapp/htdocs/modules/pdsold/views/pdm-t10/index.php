<?php

use kartik\widgets\ActiveForm;
use yii\helpers\Html;
//use yii\grid\GridView;
use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\pidum\models\PdmT10Search */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'T10';
$this->subtitle = "Surat Ijin Mengunjungi Tahanan";
?>
<div class="pdm-t10-index">

    <div id="divTambah" class="col-md-11">
        <?= Html::a('Tambah', ['create'], ['class' => 'btn btn-warning']) ?>
    </div>
    <?php
    $form = \kartik\widgets\ActiveForm::begin([
                'id' => 'hapus-index',
                'action' => '/pdsold/pdm-t10/delete/'
    ]);
    ?>  
    <div id="divHapus" class="col-md-1">
        <button class='btn btn-warning btnHapusCheckboxIndex'>Hapus</button>
    </div>
    <?php \kartik\widgets\ActiveForm::end() ?>
    <div class="clearfix"><br><br></div>
        <?=
        GridView::widget([
            'id' => 'pdm-t10',
            'rowOptions' => function ($model, $key, $index, $grid) {
                return ['data-id' => $model['no_surat_t10']];
            },
                    'dataProvider' => $dataProvider,
                    //'filterModel' => $searchModel,
                    //'showOnEmpty' => false,
                    'columns' => [
                        ['class' => 'yii\grid\SerialColumn'],
                        [
                            'attribute' => 'no_surat_t10',
                            'label' => 'Nomor Surat',
                        ],
                        [
                            'attribute' => 'nama',
                            'label' => 'Pengunjung',
                        ],
                        [
                            'attribute' => 'tgl_kunjungan',
                            'label' => 'Tanggal Kunjungan',
                            'format' => ['date', 'php:d-m-Y'],
                        ],
                        'keperluan',
                        [
                            'class' => '\kartik\grid\CheckboxColumn',
                            //'header' => '',
                            'multiple' => true,
                            'checkboxOptions' => function ($model, $key, $index, $column) {
                                return ['value' => $model['no_surat_t10'], 'class' => 'checkHapusIndex'];
                            }
                                //'class' => 'yii\grid\ActionColumn',
                                //'template' => '{update}{delete}',

                                /* 'buttons' => [
                                  'update' => function ($url, $model) {
                                  return Html::a('<span class="glyphicon glyphicon-pencil"></span>', 'update?id=' . $model['id_t15'], ['style' => 'color:#4cc521;',
                                  'title' => Yii::t('app', 'Ubah'),
                                  ]);
                                  },
                                  'delete' => function ($url, $model, $key) {
                                  return Html::a('<span class="glyphicon glyphicon-trash"></span>',"#", [
                                  'class' => 'activity-delete-link',
                                  'style' => 'color:#4cc521;',
                                  //'title' => 'test',
                                  'data-toggle' => 'modal',
                                  'data-target' => '#modal-prompt-hapus',
                                  'data-id' => $model['id_t15'],
                                  //'data-id' => $key,
                                  'data-pjax' => '0',
                                  ]);
                                  }
                                  ], */
                                ],
                            ],
                            'export' => false,
                            'pjax' => true,
                            'responsive' => true,
                            'hover' => true,
                                /* 'panel' => [
                                  'type' => GridView::TYPE_SUCCESS,
                                  'heading' => '<i class="glyphicon glyphicon-th-list"></i>',
                                  ], */
                        ]);
                        ?>

                </div>

                <?php
                $js = <<< JS
        $('td').dblclick(function (e) {
        var id = $(this).closest('tr').data('id');
        var url = window.location.protocol + "//" + window.location.host + "/pdsold/pdm-t10/update?id="+id;
        $(location).attr('href',url);
    });
JS;
                $this->registerJs($js);
                ?>

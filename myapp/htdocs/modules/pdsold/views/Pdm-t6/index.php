<?php

use yii\helpers\Html;
use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\pidum\models\PdmB1Search */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = $sysMenu->kd_berkas;
$this->subtitle = $sysMenu->keterangan;
?>
<div class="pdm-t6-index">

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?php
    $form = \kartik\widgets\ActiveForm::begin([
                'id' => 'hapus-index',
                'action' => '/pdsold/pdm-t6/delete'
    ]);
    ?>
    <div id="divHapus">
        <?= Html::a('Tambah', ['create'], ['class' => 'btn btn-warning']) ?>
        <div class="pull-right">
        <!-- <a class='btn btn-danger delete hapusTembusan btnHapusCheckboxIndex'></a> -->
        <div id="divHapus" class="col-md-1">
            <button type="button" id="apus" class='btn btn-warning btnHapusCheckboxIndexi'>Hapus</button>
        </div>
    <br></div>
    </div>
    <div id="btnHapus"></div><div id="btnUpdate"></div>
    
    <div class="row">
        <div class="col-md-12">
            <?=
            GridView::widget([
                'id' => 'spdp',
                'rowOptions' => function ($model, $key, $index, $grid) {
                    return ['data-id' => $model['no_surat_t6']];
                },
                'dataProvider' => $dataProvider,
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],
                    'no_surat_t6',
                    [
                        'attribute' => 'sifat',
                        'label' => 'sifat',
                        'format' => 'raw',
                        'value' => function ($model, $key, $index, $widget) {
                            if(!is_null($model->sifat)){
                                $sifat = \app\models\MsSifatSurat::findOne(['id' => $model->sifat]);
                                $sifat = $sifat->nama;
                            }else{
                                $sifat ='-';
                            }

                            return $sifat;
                        },
                    ],
                    'lampiran',
                    [
                        'class' => 'kartik\grid\CheckboxColumn',
                        'headerOptions' => ['class' => 'kartik-sheet-style'],
                        'checkboxOptions' => function ($model, $key, $index, $column) {
                                return ['value' => $model->no_surat_t6, 'class' => 'checkHapusIndex'];
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
<?php \kartik\widgets\ActiveForm::end() ?>
<?php
$js = <<< JS
    $('td').dblclick(function (e) {
    var id = $(this).closest('tr').data('id');
    var url = window.location.protocol + "//" + window.location.host + "/pdsold/pdm-t6/update?id="+id;
    $(location).attr('href',url);

    
});

$("#apus").on("click",function(){
        $('form').submit();
           });
JS;

$this->registerJs($js);
?>

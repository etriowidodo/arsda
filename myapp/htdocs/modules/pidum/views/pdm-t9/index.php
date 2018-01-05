<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use app\models\MsSifatSurat;
/* @var $this yii\web\View */
/* @var $searchModel app\modules\pidum\models\PdmT9Search */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = $sysMenu->kd_berkas;
$this->subtitle = $sysMenu->keterangan;
?>
<div class="pdm-t9-index">

    <div id="divTambah" class="col-md-11">
        <?= Html::a('Tambah', ['create'], ['class' => 'btn btn-warning']) ?>
    </div>
    <?php
       $form = \kartik\widgets\ActiveForm::begin([
            'id' => 'hapus-index',
            'action' => '/pidum/pdm-t9/delete'
        ]);  
    ?>  
    <div id="divHapus" class="col-md-1">
        <button class='btn btn-warning btnHapusCheckboxIndex'>Hapus</button>
    </div>
    <?php \kartik\widgets\ActiveForm::end() ?>
    <div class="clearfix"><br><br></div>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        // 'filterModel' => $searchModel,
        'rowOptions'   => function ($model, $key, $index, $grid) {
            return ['data-id' => $model->no_surat_t9];
        },
        
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            [
                'attribute'=>'no_surat_t9',
                'label' => 'Nomor Surat',
                'format' => 'raw',
                'value'=>function ($model, $key, $index, $widget) {
                    return $model->no_surat_t9;
                },


            ],

            [
                'attribute'=>'sifat',
                'label' => 'Sifat',
                'format' => 'raw',
                'value'=>function ($model, $key, $index, $widget) {
                    return MsSifatSurat::findOne($model->sifat)->nama;
                },


            ],


            [
                'attribute'=>'kepada',
                'label' => 'Kepada',
                'format' => 'raw',
                'value'=>function ($model, $key, $index, $widget) {
                    return $model->kepada;
                },


            ],

            [
                'class'=>'kartik\grid\CheckboxColumn',
                    'headerOptions'=>['class'=>'kartik-sheet-style'],
                    'checkboxOptions' => function ($model, $key, $index, $column) {
                        return ['value' => $model->no_surat_t9, 'class' => 'checkHapusIndex'];
                    }
            ],
        ],
        'export' => false,
        'pjax' => true,
        'responsive'=>true,
        'hover'=>true,
    ]); ?>

</div>

<?php

 
    $js = <<< JS
        $('td').dblclick(function (e) {
        var idt9 = $(this).closest('tr').data('id');
        console.log(idt9);
        var url = window.location.protocol + "//" + window.location.host + "/pidum/pdm-t9/update?id_t9=" + idt9;
        $(location).attr('href',url);
    });

    $(".btnHapusCheckboxIndex").prop("disabled",true);
JS;

    $this->registerJs($js);
?>
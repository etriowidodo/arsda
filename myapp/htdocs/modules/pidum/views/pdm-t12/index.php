<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use app\models\MsSifatSurat;
// use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\pidum\models\PdmT12Search */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = $sysMenu->kd_berkas;
$this->subtitle = $sysMenu->keterangan;
?>
<div class="pdm-t12-index">

    <div id="divTambah" class="col-md-11">
        <?= Html::a('Tambah', ['create'], ['class' => 'btn btn-warning']) ?>
    </div>
    <?php
       $form = \kartik\widgets\ActiveForm::begin([
            'id' => 'hapus-index',
            'action' => '/pidum/pdm-t12/delete/'
        ]);  
    ?>  
    <div id="divHapus" class="col-md-1">
        <button id="apus" class='btn btn-warning' >Hapus</button>
    </div>
    <?php \kartik\widgets\ActiveForm::end() ?>
    <div class="clearfix"><br><br></div>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        // 'filterModel' => $searchModel,
        'rowOptions'   => function ($model, $key, $index, $grid) {
            return ['data-id' => $model['no_surat_t12']];
        },
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            [
                'attribute'=>'no_surat_t12',
                'label' => 'Nomor Surat',
                'format' => 'raw',
                'value'=>function ($model, $key, $index, $widget) {
                    return $model->no_surat_t12;
                },


            ],

            [
                'attribute'=>'sifat',
                'label' => 'Sifat',
                'format' => 'raw',
                'value'=>function ($model, $key, $index, $widget) {
                    $sifat = MsSifatSurat::findOne(['id'=>$model->sifat]);
                    return ucwords($sifat->nama);
                },


            ],

            [
                'attribute'=>'nama',
                'label' => 'Tersangka',
                'format' => 'raw',
                'value'=>function ($model, $key, $index, $widget) {
                    return $model->nama;
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
                        return ['value' => $model->no_surat_t12, 'class' => 'checkHapusIndex'];
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
        var idt12 = $(this).closest('tr').data('id');
        var url = window.location.protocol + "//" + window.location.host + "/pidum/pdm-t12/update?id_t12=" + idt12;
        $(location).attr('href',url);
    });

    //$(".btnHapusCheckboxIndex").attr("disabled",true);


    $("#apus").on("click",function(){
            $('form').submit();
    });
JS;

    $this->registerJs($js);
?>
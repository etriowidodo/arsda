<?php

use yii\helpers\Html;
use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\pidum\models\PdmBA13Search */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = $sysMenu->kd_berkas;
$this->subtitle = $sysMenu->keterangan;
?>
<div class="pdm-ba13-index">

    <div id="divTambah" class="col-md-11">
        <?= Html::a('Tambah', ['create'], ['class' => 'btn btn-warning']) ?>
    </div>
    <?php
       $form = \kartik\widgets\ActiveForm::begin([
            'id' => 'hapus-index',
            'action' => '/pidum/pdm-ba13/delete/'
        ]);  
    ?>  
    <div id="divHapus" class="col-md-1">
        <button class='btn btn-warning btnHapusCheckboxIndex'>Hapus</button>
    </div>
    <?php \kartik\widgets\ActiveForm::end() ?>
    <div class="clearfix"><br><br></div>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,

        'rowOptions'   => function ($model, $key, $index, $grid) {
            return ['data-id' => $model['id_ba13']];
        },
        
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            [
                'attribute'=>'tgl_pembuatan',
                'label' => 'Tanggal Pembuatan',
                'format' => 'raw',
                'value'=>function ($model, $key, $index, $widget) {
                    return date("d-m-Y", strtotime($model->tgl_pembuatan));
                },


            ],

            [
                'attribute'=>'id_tersangka',
                'label' => 'Tersangka',
                'format' => 'raw',
                'value'=>function ($model, $key, $index, $widget) {
                    return $model->tersangka->nama;
                },


            ],

            [
                'attribute'=>'tindakan',
                'label' => 'Tindakan',
                'format' => 'raw',
                'value'=>function ($model, $key, $index, $widget) {
                    return $model->tindakan;
                },


            ],

            [
                'attribute'=>'id_ms_loktahanan',
                'label' => 'Dari Tahanan',
                'format' => 'raw',
                'value'=>function ($model, $key, $index, $widget) {
                    return $model->lokTahanan->nama;
                },


            ],

            [
                'attribute'=>'tgl_mulai',
                'label' => 'Terhitung Sejak',
                'format' => 'raw',
                'value'=>function ($model, $key, $index, $widget) {
                    return date("d-m-Y", strtotime($model->tgl_mulai));
                },


            ],

            [
                'class'=>'kartik\grid\CheckboxColumn',
                    'headerOptions'=>['class'=>'kartik-sheet-style'],
                    'checkboxOptions' => function ($model, $key, $index, $column) {
                        return ['value' => $model['id_ba13'], 'class' => 'checkHapusIndex'];
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
        var id_ba13 = $(this).closest('tr').data('id');
        var url = window.location.protocol + "//" + window.location.host + "/pidum/pdm-ba13/update?id_ba13=" + id_ba13;
        $(location).attr('href',url);
    });

    $(".btnHapusCheckboxIndex").attr("disabled",true);
JS;

    $this->registerJs($js);
?>
<?php

use yii\helpers\Html;
use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\pidum\models\PdmBA12Search */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = $sysMenu->kd_berkas;
$this->subtitle = $sysMenu->keterangan;
?>
<div class="pdm-ba12-index">
    <div id="divTambah" class="col-md-11">
        <?= Html::a('Tambah', ['create'], ['class' => 'btn btn-warning']) ?>
    </div>
    <?php
       $form = \kartik\widgets\ActiveForm::begin([
            'id' => 'hapus-index',
            'action' => '/pdsold/pdm-ba12/delete/'
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
            return ['data-id' => $model['id_ba12']];
        },

        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            [
                'attribute'=>'no_sp',
                'label' => 'Nomor Surat Perintah',
                'format' => 'raw',
                'value'=>function ($model, $key, $index, $widget) {
                    return $model->no_sp;
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
                'attribute'=>'tgl_pembuatan',
                'label' => 'Tanggal Pembuatan',
                'format' => 'raw',
                'value'=>function ($model, $key, $index, $widget) {
                    return date("d-m-Y", strtotime($model->tgl_pembuatan));
                },


            ],
            [
                'class'=>'kartik\grid\CheckboxColumn',
                    'headerOptions'=>['class'=>'kartik-sheet-style'],
                    'checkboxOptions' => function ($model, $key, $index, $column) {
                        return ['value' => $model->id_ba12, 'class' => 'checkHapusIndex'];
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
        var idba12 = $(this).closest('tr').data('id');
        var url = window.location.protocol + "//" + window.location.host + "/pdsold/pdm-ba12/update?id_ba12=" + idba12;
        $(location).attr('href',url);
    });

    $(".btnHapusCheckboxIndex").attr("disabled",true);
JS;

    $this->registerJs($js);
?>
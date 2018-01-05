<?php

use yii\helpers\Html;
//use yii\grid\GridView;
use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\pidum\models\PdmP27Search */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'P-27';
$this->subtitle = 'Surat Ketetapan Pencabutan Penghentian Penuntutan';
//$this->params['breadcrumbs'][] = $this->title;
?>
<div class="pdm-p27-index">

    <!--<h1><?// Html::encode($this->title) ?></h1>-->
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
    <div id="divTambah" class="col-md-11">
        <?= Html::a('Tambah', ['create'], ['class' => 'btn btn-warning']) ?>
    </div>
    <?php
       $form = \kartik\widgets\ActiveForm::begin([
            'id' => 'hapus-index',
            'action' => '/pdsold/pdm-p27/delete'
        ]);  
    ?> 
    <div id="divHapus" class="col-md-1">
        <button class='btn btn-warning btnHapusCheckboxIndex'>Hapus</button>
    </div>
    <?php \kartik\widgets\ActiveForm::end() ?>
    <div class="clearfix"><br><br></div>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
//        'filterModel' => $searchModel,
        'rowOptions'   => function ($model, $key, $index, $grid) {
            return ['data-id' => $model->no_surat_p27];
         },
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            [
                'attribute'=>'no_surat_p27',
                'label' => 'No Surat P27',
                'format' => 'raw',
                'value'=>function ($model, $key, $index, $widget) {
                    return $model->no_surat_p27;
                },
            ],
            [
                'attribute'=>'tgl_ba',
                'label' => 'Tgl BA',
                'format' => 'raw',
                'value'=>function ($model, $key, $index, $widget) {
                    return $model->tgl_ba;
                },
            ],
            [
                'attribute'=>'alasan',
                'label' => 'Alasan',
                'format' => 'raw',
                'value'=>function ($model, $key, $index, $widget) {
                    return $model->alasan;
                },
            ],
            [
                'class'=>'kartik\grid\CheckboxColumn',
                    'headerOptions'=>['class'=>'kartik-sheet-style'],
                    'checkboxOptions' => function ($model, $key, $index, $column) {
                        return ['value' => $model->no_surat_p27, 'class' => 'checkHapusIndex'];
                    }
            ],
            // 'id_tersangka',
            // 'keterangan_tersangka',
            // 'keterangan_saksi',
            // 'dari_benda',
            // 'dari_petunjuk',
            // 'alasan:ntext',
            // 'dikeluarkan',
            // 'tgl_surat',
            // 'id_penandatangan',
            // 'id_kejati',
            // 'id_kejari',
            // 'id_cabjari',
            // 'created_by',
            // 'created_ip',
            // 'created_time',
            // 'updated_ip',
            // 'updated_by',
            // 'updated_time',

//            ['class' => 'yii\grid\ActionColumn'],
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
        var no_surat_p27 = $(this).closest('tr').data('id');
        var url = window.location.protocol + "//" + window.location.host + "/pdsold/pdm-p27/update?no_surat_p27=" +no_surat_p27;
        $(location).attr('href',url);
    });

    $(".btnHapusCheckboxIndex").prop("disabled",true);
           
JS;

    $this->registerJs($js);
?>
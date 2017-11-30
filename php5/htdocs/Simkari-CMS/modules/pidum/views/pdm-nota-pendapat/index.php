<?php

use yii\helpers\Html;
use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\pidum\models\PdmNotaPendapatSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Nota Pendapat';
//$this->params['breadcrumbs'][] = $this->title;
?>
<div class="pdm-nota-pendapat-index">

    <!--<h1><?= Html::encode($this->title) ?></h1>-->
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <div id="divTambah" class="col-md-11">
        <?= Html::a('Tambah', ['create'], ['class' => 'btn btn-warning']) ?>
    </div>
    <?php
       $form = \kartik\widgets\ActiveForm::begin([
            'id' => 'hapus-index',
            'action' => '/pidum/pdm-nota-pendapat/delete'
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
            return ['data-id' => $model->id_nota_pendapat];
         },
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            [
                'attribute'=>'id_nota_pendapat',
                'label' => 'Id Nota Pendapat',
                'format' => 'raw',
                'value'=>function ($model, $key, $index, $widget) {
                    return $model->id_nota_pendapat;
                },
            ],
            [
                'attribute'=>'jenis_nota_pendapat',
                'label' => 'Jenis Nota Pendapat',
                'format' => 'raw',
                'value'=>function ($model, $key, $index, $widget) {
                    return $model->jenis_nota_pendapat;
                },
            ],
            [
                'attribute'=>'kepada',
                'label' => 'Kepada Yth.',
                'format' => 'raw',
                'value'=>function ($model, $key, $index, $widget) {
                    return $model->kepada;
                },
            ],
            [
                'attribute'=>'dari_nama_jaksa_p16a',
                'label' => 'Nama Jaksa',
                'format' => 'raw',
                'value'=>function ($model, $key, $index, $widget) {
                    return $model->dari_nama_jaksa_p16a;
                },
            ],
            [
                'attribute'=>'perihal_nota',
                'label' => 'Perihal Nota',
                'format' => 'raw',
                'value'=>function ($model, $key, $index, $widget) {
                    return $model->perihal_nota;
                },
            ],
            [
                'class'=>'kartik\grid\CheckboxColumn',
                    'headerOptions'=>['class'=>'kartik-sheet-style'],
                    'checkboxOptions' => function ($model, $key, $index, $column) {
                        return ['value' => $model->id_nota_pendapat, 'class' => 'checkHapusIndex'];
                    }
            ],
            // 'dari_nama_jaksa_p16a',
            // 'dari_jabatan_jaksa_p16a',
            // 'dari_pangkat_jaksa_p16a',
            // 'tgl_nota',
            // 'perihal_nota',
            // 'dasar_nota:ntext',
            // 'pendapat_nota:ntext',
            // 'flag_saran',
            // 'saran_nota:ntext',
            // 'flag_pentunjuk',
            // 'petunjuk_nota:ntext',
            // 'id_kejati',
            // 'id_kejari',
            // 'id_cabjari',
            // 'created_by',
            // 'created_ip',
            // 'created_time',
            // 'updated_ip',
            // 'updated_by',
            // 'updated_time',

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
        var id_nota = $(this).closest('tr').data('id');
        var url = window.location.protocol + "//" + window.location.host + "/pidum/pdm-nota-pendapat/update?id_nota=" + id_nota;
        $(location).attr('href',url);
    });

    $(".btnHapusCheckboxIndex").prop("disabled",true);
           
JS;

    $this->registerJs($js);
?>
<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use app\modules\pidum\models\PdmNotaPendapatT4Jaksa;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\pidum\models\PdmNotaPendapatT4Search */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Nota Pendapat T4';
//$this->params['breadcrumbs'][] = $this->title;
?>
<div class="pdm-nota-pendapat-t4-index">

    <!--<h1><?// Html::encode($this->title) ?></h1>-->
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
    
    <div id="divTambah" class="col-md-11">
        <?= Html::a('Tambah', ['create'], ['class' => 'btn btn-warning']) ?>
    </div>
    <?php
       $form = \kartik\widgets\ActiveForm::begin([
            'id' => 'hapus-index',
            'action' => '/pidum/pdm-nota-pendapat-t4/delete'
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
                'attribute'=>'id_perpanjangan',
                'label' => 'Surat Permintaan',
                'format' => 'raw',
                'value'=>function ($model, $key, $index, $widget) {
//                    return $model->no_surat_penahanan;
                    $surat_Permintaan = app\modules\pidum\models\PdmPerpanjanganTahanan::findOne(['no_surat_penahanan'=>$model->no_surat_penahanan]);
                    return $surat_Permintaan->no_surat;
                },
            ],
            [
                'attribute'=>'id_perpanjangan',
                'label' => 'Tersangka',
                'format' => 'raw',
                'value'=>function ($model, $key, $index, $widget) {
//                    return $model->no_surat_penahanan;
                    $tsk = app\modules\pidum\models\MsTersangkaPt::findOne(['id_perpanjangan'=>$model->id_perpanjangan, 'no_surat_penahanan'=>$model->no_surat_penahanan]);
                    return $tsk->nama;
                },
            ],
            [
                'attribute'=>'id_nota_pendapat',
                'label' => 'Tanggal Nota Pendapat',
                'format' => 'raw',
                'value'=>function ($model, $key, $index, $widget) {
                    return Yii::$app->globalfunc->ViewIndonesianFormat($model->tgl_nota);
                },
            ],
            [
                'attribute'=>'persetujuan',
                'label' => 'Persetujuan',
                'format' => 'raw',
                'value'=>function ($model, $key, $index, $widget) {
                    return $model->persetujuan." Hari";
                },
            ],
            [
                'attribute'=>'jaksa',
                'label' => 'Jaksa P16',
                'format' => 'raw',
                'value'=>function ($model, $key, $index, $widget) {
                    $jaksa = PdmNotaPendapatT4Jaksa::findAll(['id_perpanjangan'=>$model->id_perpanjangan,'id_nota_pendapat'=>$model->id_nota_pendapat]);
                            $no = 1;
                            foreach($jaksa as $data){
                                    $isi .= $no.". ".$data->nama_jaksa_p16."<br/>";
                                    $no++;
                            }
                    return $isi;
                },
            ],
            [
                'class'=>'kartik\grid\CheckboxColumn',
                    'headerOptions'=>['class'=>'kartik-sheet-style'],
                    'checkboxOptions' => function ($model, $key, $index, $column) {
                        return ['value' => $model->id_nota_pendapat, 'class' => 'checkHapusIndex'];
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
        var id_nota = $(this).closest('tr').data('id');
        var url = window.location.protocol + "//" + window.location.host + "/pidum/pdm-nota-pendapat-t4/update?id_nota=" + id_nota;
        $(location).attr('href',url);
    });

    $(".btnHapusCheckboxIndex").prop("disabled",true);
           
JS;

    $this->registerJs($js);
?>
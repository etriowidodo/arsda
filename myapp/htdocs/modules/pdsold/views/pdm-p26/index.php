<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use app\modules\pdsold\models\PdmP26;
use app\modules\pdsold\models\PdmT7;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\pidum\models\PdmP26Search */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'P-26';
//$this->params['breadcrumbs'][] = $this->title;
$this->subtitle = 'SURAT KETETAPAN PENGHENTIAN PENUNTUTAN';
?>
<div class="pdm-p26-index">

    <!--<h1><?// Html::encode($this->title) ?></h1>-->
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    
    <div id="divTambah" class="col-md-11">
        <?= Html::a('Tambah', ['create'], ['class' => 'btn btn-warning']) ?>
    </div>
    <?php
       $form = \kartik\widgets\ActiveForm::begin([
            'id' => 'hapus-index',
            'action' => '/pdsold/pdm-p26/delete'
        ]);  
    ?> 
    <div id="divHapus" class="col-md-1">
        <button class='btn btn-warning btnHapusCheckboxIndex'>Hapus</button>
    </div>
    
    <div class="clearfix"><br><br></div>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
//        'filterModel' => $searchModel,
        'rowOptions'   => function ($model, $key, $index, $grid) {
            return ['data-id' => $model->no_surat_p26];
        },
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

//            [
//                'attribute'=>'no_register_perkara',
//                'label' => 'Nomor Register Perkara',
//                'format' => 'raw',
//                'value'=>function ($model, $key, $index, $widget) {
//                    return $model->no_register_perkara;
//                },
//            ],
            
            [
                'attribute'=>'no_surat_p26',
                'label' => 'Nomor Surat P26',
                'format' => 'raw',
                'value'=>function ($model, $key, $index, $widget) {
                    return $model->no_surat_p26;
                },
            ],
                        
            [
                'attribute'=>'id_tersangka',
                'label' => 'Tersangka',
                'format' => 'raw',
                'value'=>function ($model, $key, $index, $widget) {
                                        $tsk = PdmT7::findAll(['no_register_perkara'=>$model->no_register_perkara,'no_urut_tersangka'=>$model->id_tersangka]);
                                        foreach($tsk as $rowtsk){
                                                $isi .= $rowtsk->nama_tersangka_ba4."<br/>";
                                        }
                    return $isi;
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
                'class'=>'kartik\grid\CheckboxColumn',
                    'headerOptions'=>['class'=>'kartik-sheet-style'],
                    'checkboxOptions' => function ($model, $key, $index, $column) {
                        return ['value' => $model->no_surat_p26, 'class' => 'checkHapusIndex'];
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
        var no_surat_p26 = $(this).closest('tr').data('id');
        var url = window.location.protocol + "//" + window.location.host + "/pdsold/pdm-p26/update?no_surat_p26=" + no_surat_p26;
        $(location).attr('href',url);
    });

    $(".btnHapusCheckboxIndex").prop("disabled",true);
           
JS;

    $this->registerJs($js);
?>

<?php

use kartik\widgets\ActiveForm;
use yii\helpers\Html;
use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\pidum\models\PdmP24Search */
/* @var $dataProvider yii\data\ActiveDataProvider */

//$this->title = 'P24';
//$this->params['breadcrumbs'][] = $this->title;
$this->title = $sysMenu->kd_berkas;
$this->subtitle = $sysMenu->keterangan;


?>
<div class="pdm-p25-index">

    <div id="divTambah" class="col-md-11">
        <?= Html::a('Tambah', ['create'], ['class' => 'btn btn-warning']) ?>
    </div>
    <?php
       $form = \kartik\widgets\ActiveForm::begin([
            'id' => 'hapus-index',
            'action' => '/pidum/pdm-p25/delete/'
        ]);  
    ?>  
       <div id="divHapus" class="col-md-1">
        <button class='btn btn-warning btnHapusCheckboxIndex'>Hapus</button>
    </div>
    <?php \kartik\widgets\ActiveForm::end() ?>
    <div class="clearfix"><br><br></div>
    
    
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        //'filterModel' => $searchModel,
        'rowOptions'   => function ($model, $key, $index, $grid) {
         return ['data-id' => $model['id_p25']];
        },
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            
            // [
            //     'attribute'=>'id_berkas',
            //     'label' => 'Id Berkas',
            //     'format' => 'raw',
            //     'value'=>function ($model, $key, $index, $widget) {
            //         return $model->id_berkas;
            //     },


            // ],
             [
                'attribute'=>'no_surat',
                'label' => 'No Surat',
                'format' => 'raw',
                'value'=>function ($model, $key, $index, $widget) {
                    return $model->no_surat;
                },


            ],
            
            [
                'attribute'=>'tgl_surat',
                'label' => 'Tanggal Surat',
                'format' => 'raw',
                'value'=>function ($model, $key, $index, $widget) {
                    return $model->tgl_surat;
                },


            ],
            
           
            
             [
                'class'=>'kartik\grid\CheckboxColumn',
                    'headerOptions'=>['class'=>'kartik-sheet-style'],
                    'checkboxOptions' => function ($model, $key, $index, $column) {
                        return ['value' => $model['id_p25'], 'class' => 'checkHapusIndex'];
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
        var idp24 = $(this).closest('tr').data('id');
        var url = window.location.protocol + "//" + window.location.host + "/pidum/pdm-p25/update?id_p25=" + idp24;
        $(location).attr('href',url);
    });

    $(".btnHapusCheckboxIndex").attr("disabled",true);
JS;

    $this->registerJs($js);
?>

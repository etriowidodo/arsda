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
<div class="pdm-ba2-index">

    <div id="divTambah" class="col-md-11">
        <?= Html::a('Tambah', ['create'], ['class' => 'btn btn-warning']) ?>
    </div>
    <?php
       $form = \kartik\widgets\ActiveForm::begin([
            'id' => 'hapus-index',
            'action' => '/pidum/pdm-ba2/delete/'
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
         return ['data-id' => $model['id_ba2']];
        },
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
			[
                'attribute'=>'tgl_pembuatan',
                'label' => 'Tanggal Surat',
                'format' => 'raw',
                'value'=>function ($model, $key, $index, $widget) {
                    return $model->tgl_pembuatan;
                },


            ],
            [
                'attribute'=>'lokasi',
                'label' => 'Lokasi',
                'format' => 'raw',
                'value'=>function ($model, $key, $index, $widget) {
                    return $model->lokasi;
                },


            ],
             [
                'class'=>'kartik\grid\CheckboxColumn',
                    'headerOptions'=>['class'=>'kartik-sheet-style'],
                    'checkboxOptions' => function ($model, $key, $index, $column) {
                        return ['value' => $model['id_ba2'], 'class' => 'checkHapusIndex'];
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
        var idba2 = $(this).closest('tr').data('id');
        var url = window.location.protocol + "//" + window.location.host + "/pidum/pdm-ba2/update?id_ba2=" + idba2;
        $(location).attr('href',url);
    });

    $(".btnHapusCheckboxIndex").attr("disabled",true);
JS;

    $this->registerJs($js);
?>

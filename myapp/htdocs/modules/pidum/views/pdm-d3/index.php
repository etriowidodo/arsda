<?php

use yii\helpers\Html;
use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\pidum\models\PdmD3Search */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Tanda terima Pembayaran';
//$this->params['breadcrumbs'][] = $this->title;
?>
<div class="pdm-d3-index">

   <div id="divTambah" class="col-md-11">
        <?= Html::a('Tambah', ['create'], ['class' => 'btn btn-warning']) ?>
    </div>
    <?php
       $form = \kartik\widgets\ActiveForm::begin([
            'id' => 'hapus-index',
            'action' => '/pidum/pdm-d3/delete/'
        ]);  
    ?>  
    <div id="divHapus" class="col-md-1">
        <button class='btn btn-warning btnHapusCheckboxIndex'>Hapus</button>
    </div>
    <?php \kartik\widgets\ActiveForm::end() ?>
    <div class="clearfix"><br><br></div>



    <?= GridView::widget([
        'dataProvider' => $dataProvider,
      //  'filterModel' => $searchModel,
        'rowOptions'   => function ($model, $key, $index, $grid) {
            return ['data-id' => $model['id_d3']];
		},
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            [
                'attribute'=>'nama',
                'label' => 'Nama',
                'format' => 'raw',
                'value'=>function ($model, $key, $index, $widget) {
                    return $model['nama'];
                },
            ],
                        
            [
                'attribute'=>'alamat',
                'label' => 'alamat',
                'format' => 'raw',
                'value'=>function ($model, $key, $index, $widget) {
                    return $model['alamat'];
                },
            ],            
            
            
             [
                'attribute'=>'no_surat',
                'label' => 'No Surat',
                'format' => 'raw',
                'value'=>function ($model, $key, $index, $widget) {
                    return $model['no_surat'];
                },
            ],           
            
             [
                'attribute'=>'tgl_putus',
                'label' => 'Tanggal',
                'format' => 'raw',
                'value'=>function ($model, $key, $index, $widget) {
                    return $model['tgl_putus'];
                },
            ],           
                        
         
 [
                'class'=>'kartik\grid\CheckboxColumn',
                    'headerOptions'=>['class'=>'kartik-sheet-style'],
                    'checkboxOptions' => function ($model, $key, $index, $column) {
                        return ['value' => $model['id_d3'], 'class' => 'checkHapusIndex'];
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
        var idd3 = $(this).closest('tr').data('id');
        var url = window.location.protocol + "//" + window.location.host + "/pidum/pdm-d3/update?id_d3=" + idd3;
        $(location).attr('href',url);
    });

JS;

    $this->registerJs($js);
?>


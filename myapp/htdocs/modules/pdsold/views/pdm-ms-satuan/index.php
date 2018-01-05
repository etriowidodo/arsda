<?php

use yii\helpers\Html;
use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\pidum\models\PdmMsSatuanSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Satuan';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="pdm-ms-satuan-index">

    <div id="divTambah" class="col-md-11">
        <?= Html::a('Tambah', ['create'], ['class' => 'btn btn-warning']) ?>
    </div>
	
	<?php
       $form = \kartik\widgets\ActiveForm::begin([
            'id' => 'hapus-index',
            'action' => '/pdsold/pdm-ms-satuan/delete/'
        ]);  
    ?>  
	
	 <div id="divHapus" class="col-md-1">
        <button class='btn btn-warning btnHapusCheckboxIndex'>Hapus</button>
    </div>
	
	 <?php \kartik\widgets\ActiveForm::end() ?>
    <div class="clearfix"><br><br></div>

   <?= GridView::widget([
        'dataProvider' => $dataProvider,
     //   'filterModel' => $searchModel,
        'rowOptions'   => function ($model, $key, $index, $grid) {
            return ['data-id' => $model['id']];
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
                'class'=>'kartik\grid\CheckboxColumn',
                    'headerOptions'=>['class'=>'kartik-sheet-style'],
                    'checkboxOptions' => function ($model, $key, $index, $column) {
                        return ['value' => $model['id'], 'class' => 'checkHapusIndex'];
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
        var idsatuan = $(this).closest('tr').data('id');
        var url = window.location.protocol + "//" + window.location.host + "/pdsold/pdm-ms-satuan/update?id=" + idsatuan;
        $(location).attr('href',url);
    });

JS;

    $this->registerJs($js);
?>

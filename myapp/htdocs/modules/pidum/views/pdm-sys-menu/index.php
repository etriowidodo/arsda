<?php

use yii\helpers\Html;
use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\pidum\models\PdmSysMenuSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Template Persuratan';

?>
<div class="pdm-sys-menu-index">

    <div id="divTambah" class="col-md-11">
        <?php //echo Html::a('Tambah', ['create'], ['class' => 'btn btn-warning']) ?>
    </div>
	
	<?php
       $form = \kartik\widgets\ActiveForm::begin([
            'id' => 'hapus-index',
            'action' => '/pidum/pdm-sys-menu/delete/'
        ]);  
    ?>
	
	<div id="divHapus" class="col-md-1">
        <button class='btn btn-warning btnHapusCheckboxIndex'>Hapus</button>
    </div>
	
	 <?php \kartik\widgets\ActiveForm::end() ?>
    <div class="clearfix"><br><br></div>
	
	<?= GridView::widget([
        'dataProvider' => $dataProvider,
      'filterModel' => $searchModel,
        'rowOptions'   => function ($model, $key, $index, $grid) {
            return ['data-id' => $model['id']];
		},
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
             
        [
                'attribute'=>'kd_berkas',
                'label' => 'Kode',
                'format' => 'raw',
                'value'=>function ($model, $key, $index, $widget) {
                    return $model['kd_berkas'];
                },
				
		],
		
		 [
                'attribute'=>'keterangan',
                'label' => 'Keterangan',
                'format' => 'raw',
                'value'=>function ($model, $key, $index, $widget) {
                    return $model['keterangan'];
                },
				
		],
		
		 [
                'attribute'=>'id__group_perkara',
                'label' => 'Group',
                'format' => 'raw',
                'value'=>function ($model, $key, $index, $widget) {
                    return $model['id__group_perkara'];
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
        'pjax' => false,
        'responsive'=>true,
        'hover'=>true,
		
    ]); ?>

</div>

<?php
 
    $js = <<< JS
        $('td').dblclick(function (e) {
        var idsysmenu = $(this).closest('tr').data('id');
		if(idsysmenu==undefined){
			bootbox.dialog({
                message: "Maaf tidak terdapat data untuk diubah",
                buttons:{
                    ya : {
                        label: "OK",
                        className: "btn-warning",

                    }
                }
            });
		}else{
        var url = window.location.protocol + "//" + window.location.host + "/pidum/pdm-sys-menu/update?id=" + idsysmenu;
        $(location).attr('href',url);
		}
    });

JS;

    $this->registerJs($js);
?>

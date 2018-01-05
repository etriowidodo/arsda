<?php

use yii\helpers\Html;
use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\pidum\models\PdmTemplateTembusanSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Tembusan';

?>
<div class="pdm-template-tembusan-index">

    <div id="divTambah" class="col-md-11" style="width:82%;">
        <?php //Html::a('Tambah', ['create'], ['class' => 'btn btn-warning']) ?>
    </div>
	
	<div  class="col-md-1" style="width:6%;">
        
    </div>
    <div  class="col-md-1" style="width:6%;">
        <button id="idUbah" class='btn btn-success btnUbahCheckboxIndex'>Ubah</button>
    </div>
	
	<?php
       $form = \kartik\widgets\ActiveForm::begin([
            'id' => 'hapus-index',
            'action' => '/pidum/pdm-template-tembusan/delete/'
        ]);  
    ?>
	
	<div id="divHapus" class="col-md-1" style="width:5%; margin-left:0px;">
        <button class='btn btn-warning btnHapusCheckboxIndex hide'>Hapus</button>
    </div>
	
	<?php \kartik\widgets\ActiveForm::end() ?>
    <div class="clearfix"><br><br></div>
	
	<?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'rowOptions'   => function ($model, $key, $index, $grid) {
            return ['data-id' => $model['kd_berkas']];
		},
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
             
        [
                'attribute'=>'kd_berkas',
                'label' => 'Kode Persuratan',
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
                'attribute'=>'status',
                'label' => 'Status',
                'format' => 'raw',
                'value'=>function ($model, $key, $index, $widget) {
                    return $model['status'];
                },
				
		],
		/* [
                'attribute'=>'no_urut',
                'label' => 'Nomor Urut',
                'format' => 'raw',
                'value'=>function ($model, $key, $index, $widget) {
                    return $model['no_urut'];
                },
				
		],
		
		 [
                'attribute'=>'tembusan',
                'label' => 'Tembusan',
                'format' => 'raw',
                'value'=>function ($model, $key, $index, $widget) {
                    return $model['tembusan'];
                },
				
		],*/
		
		[
                'class'=>'kartik\grid\CheckboxColumn',
                    'headerOptions'=>['class'=>'kartik-sheet-style'],
                    'checkboxOptions' => function ($model, $key, $index, $column) {
                        return ['value' => $model['kd_berkas'], 'class' => 'checkHapusIndex'];
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
        var idtmptembusan = $(this).closest('tr').data('id');
		if (idtmptembusan ==undefined)
		{
		bootbox.dialog({
                message: "Maaf tidak terdapat data untuk diubah",
                buttons:{
                    ya : {
                        label: "OK",
                        className: "btn-warning",

                    }
                }
            });
		}
		else
        {
        var url = window.location.protocol + "//" + window.location.host + "/pidum/pdm-template-tembusan/update?id_tmp_tembusan=" + idtmptembusan;
        $(location).attr('href',url);
		}
    });
	
	$('#idUbah').click (function (e) {
        var count =$('.checkHapusIndex:checked').length;
		if (count != 1 )
		{
		 bootbox.dialog({
                message: "Silahkan pilih hanya 1 data untuk diubah",
                buttons:{
                    ya : {
                        label: "OK",
                        className: "btn-warning",

                    }
                }
            });
		} else {
		var id =$('.checkHapusIndex:checked').val();
        var url = window.location.protocol + "//" + window.location.host + "/pidum/pdm-template-tembusan/update?id_tmp_tembusan="+id;
        $(location).attr('href',url);
		//alert(count);
		}
    });

JS;

    $this->registerJs($js);
?>

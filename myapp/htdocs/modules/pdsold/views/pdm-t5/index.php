<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use app\modules\pdsold\models\PdmSysMenu;
use app\components\GlobalConstMenuComponent;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\pidum\models\PdmT5Search */
/* @var $dataProvider yii\data\ActiveDataProvider */

// $this->title = 'T5';
// $this->params['breadcrumbs'][] = $this->title;

$sysMenu = PdmSysMenu::findAll(['kd_berkas' => GlobalConstMenuComponent::T5]);
$this->title = $sysMenu[0]->kd_berkas;
$this->subtitle = $sysMenu[0]->keterangan;

?>
<div class="pdm-t5-index">
	<div id="divTambah" class="col-md-11" style="width:82%;">
        <?= Html::a('Tambah', ['create'], ['class' => 'btn btn-warning']) ?>
    </div>
	<div  class="col-md-1" style="width:6%;">
        <button id="cetak" class='btn btn-primary btnPrintCheckboxIndex' disabled>Cetak</button>
    </div>
    <div  class="col-md-1" style="width:6%;">
        <button id="idUbah" class='btn btn-success btnUbahCheckboxIndex'>Ubah</button>
    </div>
	    <?php
       $form = \kartik\widgets\ActiveForm::begin([
            'id' =>'hapus-index',
            'action' =>'/pdsold/pdm-t5/delete'
        ]);  
    ?>  
		<div id="divHapus" class="col-md-1" style="width:5%; margin-left:0px;">
        <button class='btn btn-danger btnHapusCheckboxIndex'>Hapus</button>
    </div>
    <?php \kartik\widgets\ActiveForm::end() ?>
    <div class="clearfix"><br><br></div>

		
        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            //'filterModel' => $searchModel
            'rowOptions' => function ($model, $key, $index, $grid) {
                    return ['data-id' => $model[id_t5]];
                },
			'columns' => [
				['class' => 'yii\grid\SerialColumn'],

                [
                    'attribute'=>'no_surat',
                    'label' => 'Nomor & Tanggal Surat Penolakan',
                    'format' => 'raw',
                    'value'=>function ($model, $key, $index, $widget) {
                        return ($model[no_surat].'<br>'.$model[tgl_dikeluarkan]);
                    },
                ],

                [
                    'attribute'=>'kepada',
                    'label' => 'Kepada',
                    'format' => 'raw',
                    'value'=>function ($model, $key, $index, $widget) {
                        return ($model[kepada].'<br>'.$model[di_kepada]);
                    },
                ],

                [
                    'attribute'=>'id_tersangka',
                    'label' => 'Tersangka',
                    'format' => 'raw',
                    'value'=>function ($model, $key, $index, $widget) {
                        return ($model[nama]);
                    },
                ],


				[
                    'class' => 'kartik\grid\CheckboxColumn',
                    'headerOptions' => ['class' => 'kartik-sheet-style'],
                    'checkboxOptions' => function ($model, $key, $index, $column) {
                        return ['value' => $model[id_t5], 'class' => 'checkHapusIndex'];
                    }
					
                ],
            ],
			'export' => false,
            'pjax' => true,
            'responsive' => true,
            'hover' => true,
        ]); 
        ?>

</div>


<?php
    $js = <<< JS
       /*  $('td').dblclick(function (e) {
        var idt5 = $(this).closest('tr').data('id');
        var url = window.location.protocol + "//" + window.location.host + "/pdsold/pdm-t5/update?id_t5="+idt5;
        $(location).attr('href',url);
    }); */
	if($(".empty").text()=='Tidak ada data yang ditemukan.'){
		$(".select-on-check-all").hide();
	}
	$('td').dblclick(function (e) {
		var id = $(this).closest('tr').data('id');
		if (id ==undefined)
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
        var url = window.location.protocol + "//" + window.location.host + "/pdsold/pdm-t5/update?id_t5="+id;
        $(location).attr('href',url);
		}
		});
	//Danar Wido Seno 03-08-2016
		
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
        var url = window.location.protocol + "//" + window.location.host + "/pdsold/pdm-t5/update?id_t5="+id;
        $(location).attr('href',url);
		//alert(count);
		}
    });

	$('.btnPrintCheckboxIndex').click(function(){
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
			
            var id = $('.checkHapusIndex:checked').val();
			var cetak   = 'cetak?id_t5='+id; 
			window.location.href = cetak;
			
		}
    }); 
JS;

    $this->registerJs($js);
?>


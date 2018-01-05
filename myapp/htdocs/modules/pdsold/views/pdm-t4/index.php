<?php

use yii\helpers\Html;
use app\modules\pdsold\models\PdmSysMenu;
use app\modules\pdsold\models\MsTersangkaPt;
use app\components\GlobalConstMenuComponent;
use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $model app\modules\pidum\models\PdmT4 */

$sysMenu = PdmSysMenu::findAll(['kd_berkas' => GlobalConstMenuComponent::T4]);
$this->title = $sysMenu[0]->kd_berkas;
$this->subtitle = $sysMenu[0]->keterangan;
?>
<div class="pdm-t4-index">

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
                'id' => 'hapus-index',
                'action' => '/pdsold/pdm-t4/delete'
    ]);
    ?>
    <div id="divHapus" class="col-md-1" style="width:5%; margin-left:0px;">
        <button class='btn btn-danger btnHapusCheckboxIndex'>Hapus</button>
    </div>
    <?php \kartik\widgets\ActiveForm::end() ?>
    <div class="clearfix"><br><br></div>

        <?=
        GridView::widget([
            'dataProvider' => $dataProvider,
            // 'filterModel' => $searchModel,
            'rowOptions' => function ($model, $key, $index, $grid) {
                return ['data-id' => $model['id_t4']];
            },
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],

                [
                    'attribute'=>'no_surat',
                    'label' => 'Nomor & Tanggal Surat Perpanjangan',
                    'format' => 'raw',
                    'value'=>function ($model, $key, $index, $widget) {
                        return $model['no_surat'] . '<br>' . Yii::$app->globalfunc->ViewIndonesianFormat($model['tgl_dikeluarkan']);
                    },

                ],

                [
                    'attribute'=>'id_tersangka',
                    'label' => 'Tersangka',
                    'format' => 'raw',
                    'value'=>function ($model, $key, $index, $widget) {
						
                        return $model['nama'];
                    },

                ],

                [
                    'attribute'=>'tgl_mulai',
                    'label' => 'Masa Penahanan',
                    'format' => 'raw',
                    'value'=>function ($model, $key, $index, $widget) {
                        return Yii::$app->globalfunc->ViewIndonesianFormat($model['tgl_mulai']) . ' s.d. ' . Yii::$app->globalfunc->ViewIndonesianFormat($model['tgl_selesai']);
                    },

                ],

                [
                    'class' => 'kartik\grid\CheckboxColumn',
                    'headerOptions' => ['class' => 'kartik-sheet-style'],
                    'checkboxOptions' => function ($model, $key, $index, $column) {
                        return ['value' => $model['id_t4'], 'class' => 'checkHapusIndex'];
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
        var id = $(this).closest('tr').data('id');
        var url = window.location.protocol + "//" + window.location.host + "/pdsold/pdm-t4/update?id="+id;
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
        var url = window.location.protocol + "//" + window.location.host + "/pdsold/pdm-t4/update?id="+id;
        $(location).attr('href',url);
		}
		});
		
		$('.btnUbahCheckboxIndex').click(function(){
        var id = $('.checkHapusIndex:checked').val();
        var url = window.location.protocol + "//" + window.location.host + "/pdsold/pdm-t4/update?id="+id;
        $(location).attr('href',url);
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
			var cetak   = 'cetak?id_t4='+id; 
			window.location.href = cetak;
			
		}
    }); 

JS;

    $this->registerJs($js);
?>
